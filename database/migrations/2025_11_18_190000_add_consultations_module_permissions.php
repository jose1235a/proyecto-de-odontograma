<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $module = DB::table('system_modules')
            ->where('permission_key', 'consultations')
            ->first();

        if (!$module) {
            DB::table('system_modules')->insert([
                'slug' => Str::random(22),
                'name' => 'Consultations',
                'permission_key' => 'consultations',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $actions = ['view', 'show', 'create', 'edit', 'delete', 'export', 'edit_all'];
        foreach ($actions as $action) {
            Permission::firstOrCreate([
                'name' => "consultations.{$action}",
                'guard_name' => 'web',
            ]);
        }

        $roles = Role::whereIn('name', ['super', 'admin', 'doctor'])->get();
        $permissions = Permission::whereIn('name', array_map(
            fn ($action) => "consultations.{$action}",
            $actions
        ))->get();

        foreach ($roles as $role) {
            $role->givePermissionTo($permissions);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $actions = ['view', 'show', 'create', 'edit', 'delete', 'export', 'edit_all'];

        $permissions = Permission::whereIn('name', array_map(
            fn ($action) => "consultations.{$action}",
            $actions
        ))->get();

        foreach ($permissions as $permission) {
            $permission->delete();
        }

        DB::table('system_modules')
            ->where('permission_key', 'consultations')
            ->delete();
    }
};
