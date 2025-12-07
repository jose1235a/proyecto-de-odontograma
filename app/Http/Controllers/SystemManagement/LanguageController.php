<?php

// Namespace
namespace App\Http\Controllers\SystemManagement;

// Controllers
use App\Http\Controllers\Controller;

// Models
use App\Models\Language;

// Requests
use App\Http\Requests\SystemManagement\Language\StoreRequest;
use App\Http\Requests\SystemManagement\Language\UpdateRequest;
use App\Http\Requests\SystemManagement\Language\DeleteRequest;

// Services
use App\Services\SystemManagement\LanguageService;

// Illuminates
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// Localization
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Main class
class LanguageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:languages.view')->only(['index', 'show']);
        $this->middleware('permission:languages.create')->only(['create', 'store']);
        $this->middleware('permission:languages.edit')->only(['edit', 'update', 'editAll', 'updateInline']);
        $this->middleware('permission:languages.delete')->only(['delete', 'deleteSave']);
        $this->middleware('permission:languages.export')->only(['exportExcel', 'exportPdf', 'exportWord']);
    }

    // Action Index
    public function index(Request $request)
    {
        // Base query using filter scope from the model
        $languages = Language::filter($request)
            ->paginate(10) // Pagination for 10 rows
            ->appends($request->all());
 
        // Return data to index
        return view('system_management.languages.index', compact('languages'));
    }

    // Action Create
    public function create()
    {
        // Displays create.blade.php
        return view('system_management.languages.create');
    }

    // Action Insert data from view create.blade.php
    public function store(StoreRequest $request, LanguageService $service)
    {
        // Using Service from app/Services
        $service->create($request->validated());

        // Redirect to view with success message 
        return redirect()
            ->route('system_management.languages.index')
            ->with('success', __('global.created_success'));
    }

    // Action Show
    public function show($slug)
    {
        // Find by Slug
        $language = Language::withTrashed()->where('slug', $slug)->firstOrFail();
        
        // Displays show.blade.php
        return view('system_management.languages.show', compact('language'));
    }

    // Action Edit
    public function edit(Language $language)
    {
        // Displays edit.blade.php
        return view('system_management.languages.edit', compact('language'));
    }

    // Action Update data from view edit.blade.php
    public function update(UpdateRequest $request, Language $language, LanguageService $service)
    {
        // Using Service from app/Services
        $service->update($language, $request->validated());
        
        // Redirect to view with success message 
        return redirect()
            ->route('system_management.languages.index')
            ->with('success', __('global.updated_success'));
    }

    // Action Delete
    public function delete(Language $language)
    {
        // Displays delete.blade.php
        return view('system_management.languages.delete', compact('language'));
    }

    // Action Update column deleted_at (hide from view)
    public function deleteSave(DeleteRequest $request, Language $language, LanguageService $service)
    {
        // Using Service from app/Services
        $service->delete($language, $request->deleted_description);
        
        // Redirect to view with success message 
        return redirect()
            ->route('system_management.languages.index')
            ->with('success', __('global.deleted_success'));
    }

    // Edit All View (like index but with inline editing)
    public function editAll(Request $request, Language $language)
    {
        // Base query using scope 'notDeleted' from the model
        $query = $language::query();

        // Apply filters
        $query = $query->filter($request);

        // Order
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');

        if (in_array($sort, ['id', 'name', 'is_active']) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }

        // Pagination for 10 rows
        $languages = $query->paginate(10)->appends($request->all());

        return view('system_management.languages.edit_all', compact('languages'));
    }

    // Action Update inline
    public function updateInline(Request $request)
    {
        $language = Language::findOrFail($request->id);
        $language->{$request->field} = $request->value;
        $language->save();

        return response()->json(['success' => true]);
    }

    // Export PDF (background download)
    public function exportPdf(Request $request)
    {
        \App\Jobs\SystemManagement\Languages\GenerateLanguagesPdfJob::dispatch(
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
        \App\Jobs\SystemManagement\Languages\GenerateLanguagesExcelJob::dispatch(
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
        \App\Jobs\SystemManagement\Languages\GenerateLanguagesWordJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }
}