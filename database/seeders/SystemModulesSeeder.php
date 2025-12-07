<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SystemModulesSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            ['name' => 'Countries', 'permission_key' => 'countries'],
            ['name' => 'Users', 'permission_key' => 'users'],
            ['name' => 'Companies', 'permission_key' => 'companies'],
            ['name' => 'Doctors', 'permission_key' => 'doctors'],
            ['name' => 'Patients', 'permission_key' => 'patients'],
            ['name' => 'Treatments', 'permission_key' => 'treatments'],
            ['name' => 'Appointments', 'permission_key' => 'appointments'],
            ['name' => 'Specialties', 'permission_key' => 'specialties'],
            ['name' => 'Odontogram', 'permission_key' => 'odontogram'],
            ['name' => 'Consultations', 'permission_key' => 'consultations'],
            ['name' => 'Payments', 'permission_key' => 'payments'],
            ['name' => 'Reports', 'permission_key' => 'reports'],
            ['name' => 'Summary', 'permission_key' => 'summary'],
            ['name' => 'Calendar', 'permission_key' => 'calendar'],
            ['name' => 'Appointment History', 'permission_key' => 'appointment_history'],
            ['name' => 'Languages', 'permission_key' => 'languages'],
            ['name' => 'Regions', 'permission_key' => 'regions'],
            ['name' => 'Tenants', 'permission_key' => 'tenants'],
            ['name' => 'System Modules', 'permission_key' => 'system_modules'],
            ['name' => 'Roles', 'permission_key' => 'roles'],
        ];

        $data = [];
        foreach ($modules as $module) {
            $data[] = [
                'slug' => Str::random(22),
                'name' => $module['name'],
                'permission_key' => $module['permission_key'],
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('system_modules')->insertOrIgnore($data);
    }
}
