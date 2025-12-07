<?php

namespace App\Http\Controllers\DentalManagement;

use App\Http\Controllers\Controller;
use App\Services\DentalManagement\TreatmentService;
use App\Models\Treatment;
use App\Http\Requests\DentalManagement\Treatment\StoreRequest;
use App\Http\Requests\DentalManagement\Treatment\UpdateRequest;
use App\Http\Requests\DentalManagement\Treatment\DeleteRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TreatmentController extends Controller
{
    public function __construct(
        private TreatmentService $treatmentService
    ) {}

    public function index(Request $request): View
    {
        $treatments = $this->treatmentService->getPaginated($request);

        return view('dental_management.treatments.index', compact('treatments'));
    }

    public function create(): View
    {
        return view('dental_management.treatments.create');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $this->treatmentService->create($request->validated());

        return redirect()->route('dental_management.treatments.index')
            ->with('success', __('dental_management.treatments.create'));
    }

    public function show(Treatment $treatment): View
    {
        return view('dental_management.treatments.show', compact('treatment'));
    }

    public function edit(Treatment $treatment, Request $request): View
    {
        $returnUrl = $request->input('return_url');
        $backUrl = $returnUrl ?? route('dental_management.treatments.index');
        return view('dental_management.treatments.edit', compact('treatment', 'returnUrl', 'backUrl'));
    }

    public function update(UpdateRequest $request, Treatment $treatment): RedirectResponse
    {
        $this->treatmentService->update($treatment->id, $request->validated());

        if ($request->filled('return_url')) {
            return redirect($request->input('return_url'))
                ->with('success', __('dental_management.treatments.edit'));
        }

        return redirect()->route('dental_management.treatments.index')
            ->with('success', __('dental_management.treatments.edit'));
    }

    public function delete(Treatment $treatment, Request $request): View
    {
        $returnUrl = $request->input('return_url');
        $backUrl = $returnUrl ?? route('dental_management.treatments.index');
        return view('dental_management.treatments.delete', compact('treatment', 'returnUrl', 'backUrl'));
    }

    public function deleteSave(DeleteRequest $request, Treatment $treatment): RedirectResponse
    {
        $this->treatmentService->delete($treatment->id, $request->validated()['reason']);

        if ($request->filled('return_url')) {
            return redirect($request->input('return_url'))
                ->with('success', __('dental_management.treatments.delete'));
        }

        return redirect()->route('dental_management.treatments.index')
            ->with('success', __('dental_management.treatments.delete'));
    }

    public function editAll(Request $request): View
    {
        $query = Treatment::query()->filter($request);

        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');

        if (in_array($sort, ['id', 'name', 'cost', 'is_active']) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }

        $treatments = $query->paginate(15)->appends($request->all());

        return view('dental_management.treatments.edit_all', compact('treatments'));
    }

    public function updateInline(Request $request): JsonResponse
    {
        $request->validate([
            'id' => ['required', 'integer', 'exists:treatments,id'],
            'field' => ['required', 'string', 'in:name,cost,is_active'],
        ]);

        $treatment = Treatment::findOrFail($request->id);
        $field = $request->field;
        $value = $request->value;

        $rules = match ($field) {
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('treatments', 'name')->ignore($treatment->id)
            ],
            'cost' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'is_active' => ['required', 'in:0,1'],
            default => ['nullable'],
        };

        $request->validate(['value' => $rules]);

        $normalizedValue = match ($field) {
            'cost' => round((float) $value, 2),
            'is_active' => (int) $value,
            default => $value,
        };

        $treatment->{$field} = $normalizedValue;
        $treatment->save();

        $responseValue = $field === 'cost'
            ? number_format($treatment->cost, 2, '.', '')
            : $treatment->{$field};

        return response()->json([
            'success' => true,
            'value' => $responseValue,
        ]);
    }

    public function updateColors(Request $request): JsonResponse
    {
        $request->validate([
            'colors' => 'required|array',
            'colors.*.id' => 'required|integer|exists:treatments,id',
            'colors.*.color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
        ]);

        foreach ($request->colors as $colorUpdate) {
            $treatment = Treatment::find($colorUpdate['id']);
            if ($treatment) {
                $treatment->color = $colorUpdate['color'];
                $treatment->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Colores actualizados correctamente',
        ]);
    }

    public function exportExcel(Request $request)
    {
        return $this->treatmentService->exportExcel($request);
    }

    public function exportPdf(Request $request)
    {
        return $this->treatmentService->exportPdf($request);
    }

    public function exportWord(Request $request)
    {
        return $this->treatmentService->exportWord($request);
    }
}
