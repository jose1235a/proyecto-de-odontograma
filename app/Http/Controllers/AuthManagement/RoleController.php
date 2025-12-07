<?php

namespace App\Http\Controllers\AuthManagement;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\AuthManagement\RoleStoreRequest;
use App\Http\Requests\AuthManagement\RoleUpdateRequest;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:roles.view')->only(['index', 'show']);
        $this->middleware('permission:roles.create')->only(['create', 'store']);
        $this->middleware('permission:roles.edit')->only(['edit', 'update']);
        $this->middleware('permission:roles.delete')->only(['delete', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('auth_management.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = new Role();
        $permissions = Permission::all();
        return view('auth_management.roles.create', compact('role', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleStoreRequest $request)
    {
        $role = Role::create($request->only('name', 'description'));

        $role->syncPermissions($request->input('permissions', []));

        return redirect()
            ->route('auth_management.roles.index')
            ->with('success', __('global.created_success'));
    }

    /**
     * Display the specified resource for editing.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('auth_management.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        $role->update($request->only('name', 'description'));

        $role->syncPermissions($request->input('permissions', []));

        return redirect()
            ->route('auth_management.roles.index')
            ->with('success', __('global.updated_success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return view('auth_management.roles.show', compact('role'));
    }

    /**
     * Show the form for deleting the specified resource.
     */
    public function delete(Role $role)
    {
        return view('auth_management.roles.delete', compact('role'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        // Cannot delete super-admin role
        if ($role->name === 'super') {
            return redirect()
                ->route('auth_management.roles.index')
                ->with('error', __('roles.cannot_delete_super'));
        }

        $role->delete();

        return redirect()
            ->route('auth_management.roles.index')
            ->with('success', __('global.deleted_success'));
    }
}
