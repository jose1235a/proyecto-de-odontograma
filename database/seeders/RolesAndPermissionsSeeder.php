<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Definir acciones comunes
        $actions = ['view', 'show', 'create', 'edit', 'delete', 'export'];

        // Leer módulos desde la tabla system_modules
        $modules = DB::table('system_modules')->whereNull('deleted_at')->get();

        // Crear permisos dinámicamente
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => "{$module->permission_key}.{$action}",
                    'guard_name' => 'web',
                ]);
            }
        }

        // Crear roles globales
        $super = Role::firstOrCreate(['name' => 'super', 'guard_name' => 'web'], ['description' => 'Rol con todos los permisos']);
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web'], ['description' => 'Rol administrativo con todos los permisos']);
        $doctor = Role::firstOrCreate(['name' => 'doctor', 'guard_name' => 'web'], ['description' => 'Rol para doctores con permisos de gestión dental']);
        $user  = Role::firstOrCreate(['name' => 'user',  'guard_name' => 'web'], ['description' => 'Rol básico de usuario']);

        // Super tiene todos los permisos
        $super->syncPermissions(Permission::all());

        // Admin tiene todos los permisos (igual que super en este caso)
        $admin->syncPermissions(Permission::all());

        // Doctor tiene permisos solo de módulos de dental_management
        $dentalModules = ['doctors', 'patients', 'treatments', 'appointments', 'specialties', 'odontogram', 'consultations', 'payments', 'reports', 'summary', 'calendar', 'appointment_history'];
        $doctorPermissions = [];
        foreach ($dentalModules as $module) {
            foreach ($actions as $action) {
                $doctorPermissions[] = "{$module}.{$action}";
            }
        }
        $doctor->syncPermissions($doctorPermissions);

        // User tiene permisos limitados
        $user->syncPermissions([
            'countries.view',
            'countries.show',
        ]);
    }
}
