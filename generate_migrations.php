<?php
use Illuminate\Support\Str;

$tables = [
    'roles', 'permissions', 'model_has_roles', 'model_has_permissions', 'role_has_permissions',
    'departments', 'security_audit_logs', 'cms_pages', 'cms_services', 'cms_public_team_profiles',
    'cms_case_studies_projects', 'customers', 'crm_leads', 'external_allied_companies',
    'alliance_contracts', 'mining_projects', 'project_phases_milestones', 'project_geological_logs_and_files',
    'lab_orders', 'lab_samples', 'lab_sample_custody_logs', 'lab_sample_test_runs',
    'lab_certificates_of_analysis', 'finance_chart_of_accounts', 'finance_invoices',
    'finance_payments_and_disbursements', 'operations_equipment_assets', 'operations_field_daily_logs',
    'hr_employee_profiles', 'hr_attendance_and_shifts', 'hr_payroll_runs', 'hr_payslips',
    'communication_threads', 'communication_messages', 'openwa_automation_rules'
];

foreach ($tables as $table) {
    $modelName = str_replace(' ', '', ucwords(str_replace('_', ' ', Str::singular($table))));
    // if model exists skip
    if (!file_exists("app/Models/$modelName.php")) {
        echo "Generating $modelName...\n";
        shell_exec("php artisan make:model $modelName -m");
    }
}
