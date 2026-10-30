<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lab_test_catalogs', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();
            $table->string('test_code')->unique();
            $table->enum('category', [
                'gold_precious_metals',
                'multi_element_geochem',
                'whole_rock_oxides',
                'mineralogy_petrography',
                'metallurgical_comminution',
                'bullion_dore_smelting',
                'environmental_water_aba'
            ]);
            $table->json('name');
            $table->json('short_description');
            $table->string('methodology_standard', 120);
            $table->json('target_elements');
            $table->integer('required_sample_weight_grams');
            $table->string('lower_detection_limit', 50);
            $table->string('upper_detection_limit', 50);
            $table->enum('default_reporting_unit', [
                'ppm_gpt',
                'ppb',
                'percent',
                'oz_per_ton',
                'fineness_per_mille',
                'karat',
                'kwh_per_ton',
                'g_per_cm3'
            ]);
            $table->integer('standard_turnaround_hours');
            $table->integer('express_turnaround_hours');
            $table->decimal('price_usd', 10, 2);
            $table->decimal('express_price_usd', 10, 2);
            $table->string('calculation_formula_key', 60);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_test_catalogs');
    }
};
