<?php

namespace App\Http\Controllers\DentalManagement;

use App\Http\Controllers\Controller;
use App\Traits\Redirectable;
use App\Services\DentalManagement\OdontogramService;
use App\Models\Odontogram;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Treatment;
use App\Models\OdontogramHistory;
use App\Http\Requests\DentalManagement\Odontogram\StoreRequest;
use App\Http\Requests\DentalManagement\Odontogram\UpdateRequest;
use App\Http\Requests\DentalManagement\Odontogram\DeleteRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class OdontogramController extends Controller
{
    use Redirectable;

    public function __construct(
        private OdontogramService $odontogramService
    ) {}

    public function index(Request $request): View
    {
        $odontograms = $this->odontogramService->getPaginated($request);

        $patients = Patient::notDeleted()
            ->orderBy('name')
            ->get(['id', 'name', 'last_name', 'document']);

        $doctors = Doctor::notDeleted()
            ->orderBy('name')
            ->get(['id', 'name', 'last_name']);

        return view('dental_management.odontogram.index', compact('odontograms', 'patients', 'doctors'));
    }

    public function create(Request $request): View
    {
        $patient = null;
        if ($request->filled('patient_id')) {
            $patientKey = $request->patient_id;
            $patient = Patient::where('slug', $patientKey)->first() ?? Patient::find($patientKey);
        }

        $patients = Patient::notDeleted()->orderBy('name')->get();
        $doctors = Doctor::notDeleted()->orderBy('name')->get();
        $treatments = Treatment::notDeleted()->where('is_active', true)->orderBy('name')->get();
        $backUrl = $patient
            ? route('dental_management.patients.show', $patient->slug)
            : route('dental_management.odontogram.index');

        return view('dental_management.odontogram.create', compact('patient', 'patients', 'doctors', 'treatments', 'backUrl'));
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $odontogram = $this->odontogramService->create($request->validated());
        $redirectUrl = $this->determineRedirectRoute($request->patient_id, null);

        return redirect($redirectUrl)->with('success', __('dental_management.odontogram.create'));
    }

    public function show($odontogram, Request $request): View
    {
        $odontogram = $this->odontogramService->find($odontogram);
        $odontogram->load(['patient', 'histories.doctor', 'histories.details']);
        $treatments = Treatment::notDeleted()->where('is_active', true)->orderBy('name')->get();

        $histories = $odontogram->histories
            ->sortByDesc(fn ($history) => optional($history->date_procedure ?? $history->created_at))
            ->values();
        $activeHistory = $this->odontogramService->resolveActiveHistory($histories, $request->input('history_id'));
        $initialData = $this->odontogramService->formatHistoryData($activeHistory);

        return view('dental_management.odontogram.show', compact('odontogram', 'treatments', 'histories', 'activeHistory', 'initialData'));
    }

    public function edit(Odontogram $odontogram, Request $request): View
    {
        $returnUrl = $request->input('return_url');
        $patients = Patient::notDeleted()->orderBy('name')->get();
        $doctors = Doctor::notDeleted()->orderBy('name')->get();
        $treatments = Treatment::notDeleted()->where('is_active', true)->orderBy('name')->get();
        $backUrl = $returnUrl ?? route('dental_management.odontogram.index');

        $odontogram->load(['patient', 'histories.doctor', 'histories.details']);
        $historySnapshots = $this->odontogramService->buildHistorySnapshots($odontogram->histories);
        $histories = $odontogram->histories
            ->sortByDesc(fn ($history) => optional($history->date_procedure ?? $history->created_at))
            ->values()
            ->map(function ($history) use ($historySnapshots) {
                $history->setAttribute('cumulative_canvas_data', $historySnapshots[$history->id] ?? []);
                return $history;
            });
        $activeHistory = $this->odontogramService->resolveActiveHistory($histories, $request->input('history_id'));
        $initialData = $this->odontogramService->formatHistoryData($activeHistory);

        return view('dental_management.odontogram.edit', compact(
            'odontogram',
            'returnUrl',
            'patients',
            'doctors',
            'treatments',
            'backUrl',
            'histories',
            'activeHistory',
            'initialData'
        ));
    }

    public function update(UpdateRequest $request, Odontogram $odontogram): RedirectResponse|JsonResponse
    {
        $odontogram = $this->odontogramService->update($odontogram->id, $request->validated());

        // Check if this is an AJAX request
        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('dental_management.odontogram.edit'),
                'data' => $odontogram
            ]);
        }

        $redirectUrl = $this->determineRedirectRoute(
            $request->patient_id ?: $odontogram->patient_id,
            $request->input('return_url')
        );

        return redirect($redirectUrl)->with('success', __('dental_management.odontogram.edit'));
    }

    public function delete(Odontogram $odontogram, Request $request): View
    {
        $returnUrl = $request->input('return_url');
        $backUrl = $returnUrl ?? route('dental_management.odontogram.index');

        return view('dental_management.odontogram.delete', compact('odontogram', 'returnUrl', 'backUrl'));
    }

    public function deleteSave(DeleteRequest $request, Odontogram $odontogram): RedirectResponse
    {
        $patientId = $odontogram->patient_id;
        $returnUrl = $request->input('return_url');

        $this->odontogramService->delete($odontogram->id, $request->reason);

        $redirectUrl = $this->determineRedirectRoute($patientId, $returnUrl);

        return redirect($redirectUrl)->with('success', __('dental_management.odontogram.delete'));
    }



}
