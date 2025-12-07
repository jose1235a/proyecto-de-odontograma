<?php

// Namespace
namespace App\Http\Controllers\SystemManagement;

// Controllers
use App\Http\Controllers\Controller;

// Models
use App\Models\SystemModule;
use Spatie\Permission\Models\Permission;

// Requests
use App\Http\Requests\SystemManagement\SystemModule\StoreRequest;
use App\Http\Requests\SystemManagement\SystemModule\UpdateRequest;
use App\Http\Requests\SystemManagement\SystemModule\DeleteRequest;

// Services
use App\Services\SystemManagement\SystemModuleService;

// Excel
use App\Exports\SystemManagement\SystemModules\SystemModulesExport;
use Maatwebsite\Excel\Facades\Excel;

// PDF
use App\Pdfs\SystemManagement\SystemModulesPdf;
use Barryvdh\DomPDF\Facade\Pdf;

// Word
use App\Exports\SystemManagement\SystemModules\SystemModulesWord;

// Illuminates
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// Localization
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Job
use App\Jobs\GenerateReportJob;

// Main class
class SystemModuleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:system_modules.view')->only(['index', 'show']);
        $this->middleware('permission:system_modules.create')->only(['create', 'store']);
        $this->middleware('permission:system_modules.edit')->only(['edit', 'update', 'editAll', 'updateInline']);
        $this->middleware('permission:system_modules.delete')->only(['delete', 'deleteSave']);
        $this->middleware('permission:system_modules.export')->only(['exportExcel', 'exportPdf', 'exportWord']);
    }

    // Action Index
    public function index(Request $request)
    {
        // Base query using filter scope from the model
        $system_modules = SystemModule::filter($request)
            ->paginate(10) // Pagination for 10 rows
            ->appends($request->all());

        // Return data to index
        return view('system_management.system_modules.index', compact('system_modules'));
    }

    // Action Create
    public function create()
    {
        // Displays create.blade.php
        return view('system_management.system_modules.create');
    }

    // Action Insert data from view create.blade.php
    public function store(StoreRequest $request, SystemModuleService $service)
    {
        // Using Service from app/Services
        $service->create($request->validated());

        // Redirect to view with success message
        return redirect()
            ->route('system_management.system_modules.index')
            ->with('success', __('global.created_success'));
    }

    // Action Show
    public function show($slug)
    {
        // Find by Slug
        $system_module = SystemModule::withTrashed()->where('slug', $slug)->firstOrFail();

        // Displays show.blade.php
        return view('system_management.system_modules.show', compact('system_module'));
    }

    // Action Edit
    public function edit(SystemModule $system_module)
    {
        // Get permissions associated to the module
        $permissions = $system_module->permissions;

        // Displays edit.blade.php
        return view('system_management.system_modules.edit', compact('system_module', 'permissions'));
    }

    // Action Update data from view edit.blade.php
    public function update(UpdateRequest $request, SystemModule $system_module, SystemModuleService $service)
    {
        // Using Service from app/Services
        $service->update($system_module, $request->validated());

        // Redirect to view with success message
        return redirect()
            ->route('system_management.system_modules.index')
            ->with('success', __('global.updated_success'));
    }

    // Action Delete
    public function delete(SystemModule $system_module)
    {
        // Displays delete.blade.php
        return view('system_management.system_modules.delete', compact('system_module'));
    }

    // Action Update column deleted_at (hide from view)
    public function deleteSave(DeleteRequest $request, SystemModule $system_module, SystemModuleService $service)
    {
        // Using Service from app/Services
        $service->delete($system_module, $request->deleted_description);

        // Redirect to view with success message
        return redirect()
            ->route('system_management.system_modules.index')
            ->with('success', __('global.deleted_success'));
    }

    // Export Excel
    public function exportExcel(Request $request)
    {
        // Data from filters
        $system_modules = SystemModule::filter($request)->with('creator')->get();

        // Generate filename
        $filename = __('system_modules.export_filename') . '_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        // Export file
        return Excel::download(new SystemModulesExport($system_modules), $filename);
    }

    // Export Pdf
    public function exportPdf(Request $request)
    {
        // You can pass filters or data to the Job
        $filters = $request->all();

        // Dispatch the job to the queue
        GenerateReportJob::dispatch(auth()->id(), 'pdf', $filters);

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', 'Your PDF report is being generated. Check your downloads queue soon.');
    }


    // Export Word
    public function exportWord(Request $request, SystemModulesWord $wordService)
    {
        $system_modules = SystemModule::filter($request)->with('creator')->get();

        $filename = __('system_modules.export_filename') . '_' . now()->format('Y-m-d_H-i-s') . '.docx';

        return $wordService->generate($system_modules, $filename);
    }

    // Edit All View (like index but with inline editing)
    public function editAll(Request $request, SystemModule $system_module)
    {
        // Base query using scope 'notDeleted' from the model
        $query = $system_module::query();

        // Apply filters
        $query = $query->filter($request);

        // Order
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');

        if (in_array($sort, ['id', 'name', 'permission_key']) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }

        // Pagination for 10 rows
        $system_modules = $query->paginate(10)->appends($request->all());

        return view('system_management.system_modules.edit_all', compact('system_modules'));
    }

    // Action Update inline
    public function updateInline(Request $request)
    {
        $system_module = SystemModule::findOrFail($request->id);
        $system_module->{$request->field} = $request->value;
        $system_module->save();

        return response()->json(['success' => true]);
    }

    public function storePermission(Request $request, SystemModule $system_module)
    {
        $request->validate([
            'action' => 'required|string|max:50',
        ]);

        Permission::firstOrCreate([
            'name' => "{$system_module->permission_key}.{$request->action}",
            'guard_name' => 'web',
        ]);

        return back()->with('success', __('global.created_success'));
    }

    public function destroyPermission(SystemModule $system_module, Permission $permission)
    {
        // Permisos base que no deben eliminarse
        $base = [
            "{$system_module->permission_key}.view",
            "{$system_module->permission_key}.create",
            "{$system_module->permission_key}.edit",
            "{$system_module->permission_key}.delete",
            "{$system_module->permission_key}.export",
        ];

        if (in_array($permission->name, $base)) {
            return back()->with('error', __('system_modules.base_permission_protected'));
        }

        $permission->delete();

        return back()->with('success', __('global.deleted_success'));
    }
}