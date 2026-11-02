<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Roles
        $roles = [
            'super_admin',
            'general_manager',
            'crm_sales_manager',
            'chief_geologist',
            'alliance_contract_manager',
            'lab_director',
            'senior_lab_chemist',
            'lab_prep_technician',
            'finance_controller',
            'operations_fleet_manager',
            'hr_payroll_manager',
            'support_agent'
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
