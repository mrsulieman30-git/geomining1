<?php

declare(strict_types=1);

namespace App\Services\Lims;

use InvalidArgumentException;

final class AssayCalculationEngine
{
    public const TROY_OUNCE_GRAMS = 31.1034768;
    public const PURE_GOLD_SG = 19.32;

    /**
     * 1. Fire Assay Gravimetric Finish (AU-FA50-GRAV / AU-FA30-GRAV)
     * Formula: Au (g/t or ppm) = (Parted Gold Bead Weight in mg * 1000) / Sample Charge Weight in g
     */
    public function calculateFireAssayGravimetric(
        float $chargeWeightGrams,
        float $doreBeadWeightMg,
        float $partedGoldBeadWeightMg,
        float $blankSilverInquartMg = 0.0
    ): array {
        if ($chargeWeightGrams <= 0) {
            throw new InvalidArgumentException('Sample charge weight must be greater than zero.');
        }

        $auPpmGpt = ($partedGoldBeadWeightMg * 1000.0) / $chargeWeightGrams;
        $silverWeightMg = max(0.0, $doreBeadWeightMg - $partedGoldBeadWeightMg - $blankSilverInquartMg);
        $agPpmGpt = ($silverWeightMg * 1000.0) / $chargeWeightGrams;

        return [
            'final_gold_grade_ppm_gpt' => round($auPpmGpt, 4),
            'final_gold_grade_oz_per_ton' => round($auPpmGpt / self::TROY_OUNCE_GRAMS, 4),
            'final_gold_percentage' => round($auPpmGpt / 10000.0, 6),
            'silver_grade_ppm_gpt' => round($agPpmGpt, 4),
        ];
    }

    /**
     * 2. Fire Assay / Aqua Regia with AAS or ICP-OES Finish (AU-FA50-AAS / AU-AR25-ICP)
     * Formula: Au (ppm) = ((Instrument Reading mg/L - Blank mg/L) * Final Volume mL * Dilution Factor) / Charge Weight g
     */
    public function calculateInstrumentalAssay(
        float $chargeWeightGrams,
        float $instrumentReadingMgPerL,
        float $blankReadingMgPerL,
        float $digestionVolumeMl,
        float $dilutionFactor = 1.0
    ): array {
        if ($chargeWeightGrams <= 0) {
            throw new InvalidArgumentException('Sample charge weight must be greater than zero.');
        }

        $correctedReading = max(0.0, $instrumentReadingMgPerL - $blankReadingMgPerL);
        $auPpmGpt = ($correctedReading * $digestionVolumeMl * $dilutionFactor) / $chargeWeightGrams;

        return [
            'final_gold_grade_ppm_gpt' => round($auPpmGpt, 4),
            'final_gold_grade_oz_per_ton' => round($auPpmGpt / self::TROY_OUNCE_GRAMS, 4),
            'final_gold_percentage' => round($auPpmGpt / 10000.0, 6),
        ];
    }

    /**
     * 3. Metallic Screen Fire Assay for Coarse / Nuggety Gold (AU-SCR1000)
     * Combines +106 micron coarse gold total gravimetric assay with -106 micron undersize duplicate average.
     */
    public function calculateMetallicScreenFireAssay(
        float $plusFractionWeightGrams,
        float $minusFractionWeightGrams,
        float $plusFractionTotalGoldMg,
        float $minusAssay1Ppm,
        float $minusAssay2Ppm
    ): array {
        $totalSampleWeightGrams = $plusFractionWeightGrams + $minusFractionWeightGrams;
        if ($totalSampleWeightGrams <= 0) {
            throw new InvalidArgumentException('Total screen sample weight must be greater than zero.');
        }

        $minusAveragePpm = ($minusAssay1Ppm + $minusAssay2Ppm) / 2.0;
        $plusFractionGoldPpm = ($plusFractionWeightGrams > 0)
            ? (($plusFractionTotalGoldMg * 1000.0) / $plusFractionWeightGrams)
            : 0.0;

        $totalGoldMgInMinus = ($minusFractionWeightGrams * $minusAveragePpm) / 1000.0;
        $totalGoldMgOverall = $plusFractionTotalGoldMg + $totalGoldMgInMinus;
        $weightedTotalAuPpm = ($totalGoldMgOverall * 1000.0) / $totalSampleWeightGrams;
        $coarseGoldContributionPct = ($totalGoldMgOverall > 0)
            ? (($plusFractionTotalGoldMg / $totalGoldMgOverall) * 100.0)
            : 0.0;

        return [
            'plus_fraction_au_ppm' => round($plusFractionGoldPpm, 4),
            'minus_fraction_avg_au_ppm' => round($minusAveragePpm, 4),
            'final_gold_grade_ppm_gpt' => round($weightedTotalAuPpm, 4),
            'final_gold_grade_oz_per_ton' => round($weightedTotalAuPpm / self::TROY_OUNCE_GRAMS, 4),
            'final_gold_percentage' => round($weightedTotalAuPpm / 10000.0, 6),
            'coarse_gold_contribution_pct' => round($coarseGoldContributionPct, 2),
        ];
    }

    /**
     * 4. Gold Bullion / Doré Bar Purity, Fineness (‰), Karat & Hydrostatic Specific Gravity (AU-BULLION-FA)
     */
    public function calculateBullionPurityAndDensity(
        float $barTotalWeightAirGrams,
        float $barWeightSubmergedWaterGrams,
        float $assayInitialSampleWeightMg,
        float $assayPureGoldRecoveredMg,
        float $proofCheckCorrectionMg = 0.0
    ): array {
        if ($assayInitialSampleWeightMg <= 0 || $barTotalWeightAirGrams <= 0) {
            throw new InvalidArgumentException('Bullion weights must be greater than zero.');
        }

        $displacedWaterGrams = $barTotalWeightAirGrams - $barWeightSubmergedWaterGrams;
        $specificGravity = ($displacedWaterGrams > 0)
            ? ($barTotalWeightAirGrams / $displacedWaterGrams)
            : 0.0;

        $finenessPerMille = (($assayPureGoldRecoveredMg + $proofCheckCorrectionMg) / $assayInitialSampleWeightMg) * 1000.0;
        $finenessPerMille = min(999.99, max(0.0, $finenessPerMille));
        $purityPercentage = $finenessPerMille / 10.0;
        $karatValue = ($finenessPerMille / 1000.0) * 24.0;
        $fineGoldGrams = $barTotalWeightAirGrams * ($finenessPerMille / 1000.0);
        $fineGoldTroyOunces = $fineGoldGrams / self::TROY_OUNCE_GRAMS;

        // Expected density verification to flag tungsten or base-metal adulteration
        $expectedMinSg = ($finenessPerMille >= 900) ? 17.20 : 14.50;
        $densityAnomalyDetected = ($specificGravity < $expectedMinSg || $specificGravity > 19.40);

        return [
            'specific_gravity_g_cm3' => round($specificGravity, 3),
            'gold_fineness_per_mille' => round($finenessPerMille, 2),
            'final_gold_percentage' => round($purityPercentage, 4),
            'gold_karat_value' => round($karatValue, 2),
            'fine_gold_weight_grams' => round($fineGoldGrams, 3),
            'fine_gold_weight_troy_oz' => round($fineGoldTroyOunces, 4),
            'density_fraud_alert' => $densityAnomalyDetected,
        ];
    }

    /**
     * 5. Cyanide Bottle Roll / BLEG Leach Recovery Calculation (AU-BLEG2000)
     */
    public function calculateCyanideLeachRecovery(
        float $leachableSolutionAuGpt,
        float $washedTailingsResidueAuGpt
    ): array {
        $reconstructedHeadGradeGpt = $leachableSolutionAuGpt + $washedTailingsResidueAuGpt;
        $recoveryPct = ($reconstructedHeadGradeGpt > 0)
            ? (($leachableSolutionAuGpt / $reconstructedHeadGradeGpt) * 100.0)
            : 0.0;

        return [
            'solution_extracted_au_gpt' => round($leachableSolutionAuGpt, 4),
            'tailings_residue_au_gpt' => round($washedTailingsResidueAuGpt, 4),
            'reconstructed_head_grade_au_gpt' => round($reconstructedHeadGradeGpt, 4),
            'cyanide_gold_recovery_pct' => round($recoveryPct, 2),
        ];
    }
}