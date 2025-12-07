<?php

// Namespace
namespace App\Http\Controllers\SystemManagement;

// Controllers
use App\Http\Controllers\Controller;

// Models
use App\Models\Tenant;

// Requests
use App\Http\Requests\SystemManagement\Tenant\StoreRequest;
use App\Http\Requests\SystemManagement\Tenant\UpdateRequest;
use App\Http\Requests\SystemManagement\Tenant\DeleteRequest;

// Services
use App\Services\SystemManagement\TenantService;

// Illuminates
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// Localization
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Main class
class TenantController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:tenants.view')->only(['index', 'show']);
        $this->middleware('permission:tenants.create')->only(['create', 'store']);
        $this->middleware('permission:tenants.edit')->only(['edit', 'update', 'editAll', 'updateInline']);
        $this->middleware('permission:tenants.delete')->only(['delete', 'deleteSave']);
        $this->middleware('permission:tenants.export')->only(['exportExcel', 'exportPdf', 'exportWord']);
    }

    // Action Index
    public function index(Request $request)
    {
        // Base query using filter scope from the model
        $tenants = Tenant::filter($request)
            ->paginate(10) // Pagination for 10 rows
            ->appends($request->all());

        // Return data to index
        return view('system_management.tenants.index', compact('tenants'));
    }

    // Action Create
    public function create()
    {
        // Displays create.blade.php
        return view('system_management.tenants.create');
    }

    // Action Insert data from view create.blade.php
    public function store(StoreRequest $request, TenantService $service)
    {
        // Using Service from app/Services
        $service->create($request->validated());

        // Redirect to view with success message
        return redirect()
            ->route('system_management.tenants.index')
            ->with('success', __('global.created_success'));
    }

    // Action Show
    public function show($slug)
    {
        // Find by Slug
        $tenant = Tenant::withTrashed()->where('slug', $slug)->firstOrFail();

        // Displays show.blade.php
        return view('system_management.tenants.show', compact('tenant'));
    }

    // Action Edit
    public function edit(Tenant $tenant)
    {
        // Displays edit.blade.php
        return view('system_management.tenants.edit', compact('tenant'));
    }

    // Action Update data from view edit.blade.php
    public function update(UpdateRequest $request, Tenant $tenant, TenantService $service)
    {
        // Using Service from app/Services
        $service->update($tenant, $request->validated());

        // Redirect to view with success message
        return redirect()
            ->route('system_management.tenants.index')
            ->with('success', __('global.updated_success'));
    }

    // Action Delete
    public function delete(Tenant $tenant)
    {
        // Displays delete.blade.php
        return view('system_management.tenants.delete', compact('tenant'));
    }

    // Action Update column deleted_at (hide from view)
    public function deleteSave(DeleteRequest $request, Tenant $tenant, TenantService $service)
    {
        // Using Service from app/Services
        $service->delete($tenant, $request->deleted_description);

        // Redirect to view with success message
        return redirect()
            ->route('system_management.tenants.index')
            ->with('success', __('global.deleted_success'));
    }

    // Edit All View (like index but with inline editing)
    public function editAll(Request $request, Tenant $tenant)
    {
        // Base query using scope 'notDeleted' from the model
        $query = $tenant::query();

        // Apply filters
        $query = $query->filter($request);

        // Order
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');

        if (in_array($sort, ['id', 'name', 'is_active']) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }

        // Pagination for 10 rows
        $tenants = $query->paginate(10)->appends($request->all());

        return view('system_management.tenants.edit_all', compact('tenants'));
    }

    // Action Update inline
    public function updateInline(Request $request)
    {
        $tenant = Tenant::findOrFail($request->id);
        $tenant->{$request->field} = $request->value;
        $tenant->save();

        return response()->json(['success' => true]);
    }

    // Export PDF (background download)
    public function exportPdf(Request $request)
    {
        \App\Jobs\SystemManagement\Tenants\GenerateTenantsPdfJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }

    // Export Excel (background download)
    public function exportExcel(Request $request)
    {
        \App\Jobs\SystemManagement\Tenants\GenerateTenantsExcelJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }

    // Export Word (background download)
    public function exportWord(Request $request)
    {
        \App\Jobs\SystemManagement\Tenants\GenerateTenantsWordJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }
}