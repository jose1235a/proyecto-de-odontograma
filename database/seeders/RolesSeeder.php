<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $definitions = [
            'super' => 'Super Admin: Full Access',
            'admin' => 'Tenant Administrator',
            'doctor' => 'Medical Doctor: Access to dental management',
            'user' => 'User with profiles',
            'language_manager' => 'Manages system languages',
        ];

        $roles = [];
        foreach ($definitions as $name => $description) {
            $role = Role::firstOrCreate(
                ['name' => $name, 'guard_name' => 'web'],
                ['description' => $description]
            );

            if (empty($role->slug)) {
                $role->slug = Str::random(22);
                $role->save();
            }

            $roles[$name] = $role;
        }

        $allPermissions = Permission::all();
        $roles['super']->syncPermissions($allPermissions);
        $roles['admin']->syncPermissions($allPermissions);

        // Assign permissions to doctor role
        $doctorPermissions = Permission::where('name', 'like', 'doctors.%')
            ->orWhere('name', 'like', 'patients.%')
            ->orWhere('name', 'like', 'appointments.%')
            ->orWhere('name', 'like', 'treatments.%')
            ->orWhere('name', 'like', 'odontogram.%')
            ->orWhere('name', 'like', 'consultations.%')
            ->orWhere('name', 'like', 'calendar.%')
            ->get();
        $roles['doctor']->syncPermissions($doctorPermissions);

        $roles['user']->syncPermissions(['users.view', 'countries.view']);

        $languagePermissions = Permission::where('name', 'like', 'languages.%')->get();
        $roles['language_manager']->syncPermissions($languagePermissions);
    }
}
