<?php

// Namespace
namespace App\Http\Controllers\SystemManagement;

// Controllers
use App\Http\Controllers\Controller;

// Models
use App\Models\Region;

// Requests
use App\Http\Requests\SystemManagement\Region\StoreRequest;
use App\Http\Requests\SystemManagement\Region\UpdateRequest;
use App\Http\Requests\SystemManagement\Region\DeleteRequest;

// Services
use App\Services\SystemManagement\RegionService;

// Illuminates
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// Localization
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Main class
class RegionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:regions.view')->only(['index', 'show']);
        $this->middleware('permission:regions.create')->only(['create', 'store']);
        $this->middleware('permission:regions.edit')->only(['edit', 'update', 'editAll', 'updateInline']);
        $this->middleware('permission:regions.delete')->only(['delete', 'deleteSave']);
        $this->middleware('permission:regions.export')->only(['exportExcel', 'exportPdf', 'exportWord']);
    }

    // Action Index
    public function index(Request $request)
    {
        // Base query using filter scope from the model
        $regions = Region::filter($request)
            ->paginate(10) // Pagination for 10 rows
            ->appends($request->all());

        // Return data to index
        return view('system_management.regions.index', compact('regions'));
    }

    // Action Create
    public function create()
    {
        // Displays create.blade.php
        return view('system_management.regions.create');
    }

    // Action Insert data from view create.blade.php
    public function store(StoreRequest $request, RegionService $service)
    {
        // Using Service from app/Services
        $service->create($request->validated());

        // Redirect to view with success message
        return redirect()
            ->route('system_management.regions.index')
            ->with('success', __('global.created_success'));
    }

    // Action Show
    public function show($slug)
    {
        // Find by Slug
        $region = Region::withTrashed()->where('slug', $slug)->firstOrFail();

        // Displays show.blade.php
        return view('system_management.regions.show', compact('region'));
    }

    // Action Edit
    public function edit(Region $region)
    {
        // Displays edit.blade.php
        return view('system_management.regions.edit', compact('region'));
    }

    // Action Update data from view edit.blade.php
    public function update(UpdateRequest $request, Region $region, RegionService $service)
    {
        // Using Service from app/Services
        $service->update($region, $request->validated());

        // Redirect to view with success message
        return redirect()
            ->route('system_management.regions.index')
            ->with('success', __('global.updated_success'));
    }

    // Action Delete
    public function delete(Region $region)
    {
        // Displays delete.blade.php
        return view('system_management.regions.delete', compact('region'));
    }

    // Action Update column deleted_at (hide from view)
    public function deleteSave(DeleteRequest $request, Region $region, RegionService $service)
    {
        // Using Service from app/Services
        $service->delete($region, $request->deleted_description);

        // Redirect to view with success message
        return redirect()
            ->route('system_management.regions.index')
            ->with('success', __('global.deleted_success'));
    }

    // Edit All View (like index but with inline editing)
    public function editAll(Request $request, Region $region)
    {
        // Base query using scope 'notDeleted' from the model
        $query = $region::query();

        // Apply filters
        $query = $query->filter($request);

        // Order
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');

        if (in_array($sort, ['id', 'name', 'is_active']) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }

        // Pagination for 10 rows
        $regions = $query->paginate(10)->appends($request->all());

        return view('system_management.regions.edit_all', compact('regions'));
    }

    // Action Update inline
    public function updateInline(Request $request)
    {
        $region = Region::findOrFail($request->id);
        $region->{$request->field} = $request->value;
        $region->save();

        return response()->json(['success' => true]);
    }

    // Export PDF (background download)
    public function exportPdf(Request $request)
    {
        \App\Jobs\SystemManagement\Regions\GenerateRegionsPdfJob::dispatch(
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
        \App\Jobs\SystemManagement\Regions\GenerateRegionsExcelJob::dispatch(
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
        \App\Jobs\SystemManagement\Regions\GenerateRegionsWordJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }
}
