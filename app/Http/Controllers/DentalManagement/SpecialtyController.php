<?php

namespace App\Http\Controllers\DentalManagement;

use App\Http\Controllers\Controller;
use App\Services\DentalManagement\SpecialtyService;
use App\Models\Specialty;
use App\Http\Requests\DentalManagement\Specialty\StoreRequest;
use App\Http\Requests\DentalManagement\Specialty\UpdateRequest;
use App\Http\Requests\DentalManagement\Specialty\DeleteRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SpecialtyController extends Controller
{
    public function __construct(
        private SpecialtyService $specialtyService
    ) {}

    public function index(Request $request): View
    {
        $specialties = $this->specialtyService->getPaginated($request);

        return view('dental_management.specialties.index', compact('specialties'));
    }

    public function create(): View
    {
        return view('dental_management.specialties.create');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $this->specialtyService->create($request->validated());

        return redirect()->route('dental_management.specialties.index')
            ->with('success', __('dental_management.specialties.create'));
    }

    public function show(Specialty $specialty): View
    {
        return view('dental_management.specialties.show', compact('specialty'));
    }

    public function edit(Specialty $specialty): View
    {
        return view('dental_management.specialties.edit', compact('specialty'));
    }

    public function update(UpdateRequest $request, Specialty $specialty): RedirectResponse
    {
        $this->specialtyService->update($specialty->id, $request->validated());

        return redirect()->route('dental_management.specialties.index')
            ->with('success', __('dental_management.specialties.edit'));
    }

    public function delete(Specialty $specialty): View
    {
        return view('dental_management.specialties.delete', compact('specialty'));
    }

    public function deleteSave(DeleteRequest $request, Specialty $specialty): RedirectResponse
    {
        $this->specialtyService->delete($specialty->id, $request->validated()['reason']);

        return redirect()->route('dental_management.specialties.index')
            ->with('success', __('dental_management.specialties.delete'));
    }

    public function editAll(Request $request): View
    {
        $query = Specialty::query();

        $query = $query->filter($request);

        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');

        if (in_array($sort, ['id', 'name', 'is_active']) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }

        $specialties = $query->paginate(15)->appends($request->all());

        return view('dental_management.specialties.edit_all', compact('specialties'));
    }

    public function updateInline(Request $request)
    {
        $specialty = Specialty::findOrFail($request->id);
        $specialty->{$request->field} = $request->value;
        $specialty->save();

        return response()->json(['success' => true]);
    }

    public function exportExcel(Request $request)
    {
        return $this->specialtyService->exportExcel($request);
    }

    public function exportPdf(Request $request)
    {
        return $this->specialtyService->exportPdf($request);
    }

    public function exportWord(Request $request)
    {
        return $this->specialtyService->exportWord($request);
    }
}
