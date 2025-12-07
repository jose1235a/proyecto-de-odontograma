<?php

namespace App\Http\Controllers\DentalManagement;

use App\Http\Controllers\Controller;
use App\Services\DentalManagement\ConsultationService;
use App\Models\Consultation;
use App\Http\Requests\DentalManagement\Consultation\StoreRequest;
use App\Http\Requests\DentalManagement\Consultation\UpdateRequest;
use App\Http\Requests\DentalManagement\Consultation\DeleteRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ConsultationController extends Controller
{
    public function __construct(
        private ConsultationService $consultationService
    ) {
        $this->middleware('permission:consultations.view')->only(['index', 'show']);
        $this->middleware('permission:consultations.create')->only(['create', 'store']);
        $this->middleware('permission:consultations.edit')->only(['edit', 'update', 'editAll']);
        $this->middleware('permission:consultations.delete')->only(['delete', 'deleteSave']);
        $this->middleware('permission:consultations.export')->only(['exportExcel', 'exportPdf', 'exportWord']);
    }

    public function index(Request $request): View
    {
        $consultations = $this->consultationService->getPaginated($request);

        return view('dental_management.consultations.index', compact('consultations'));
    }

    public function create(): View
    {
        $data = [];

        if (request()->has('patient_id')) {
            $patientId = request()->patient_id;
            // Try to find by slug first, then by ID
            $patient = \App\Models\Patient::where('slug', $patientId)->first() ?? \App\Models\Patient::find($patientId);
            $data['patient_id'] = $patient ? $patient->id : $patientId;
            $data['patient'] = $patient;
            $data['return_url'] = route('dental_management.patients.show', [
                $patient ? $patient->slug : $patientId,
                'tab' => 'consultations'
            ]);
        }

        $data['treatments'] = $this->consultationService->getAllTreatments();
        $data['doctors'] = $this->consultationService->getAllDoctors();

        return view('dental_management.consultations.create', $data);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $consultation = $this->consultationService->create($request->validated());

        if ($request->has('patient_id') && $request->patient_id) {
            $patient = \App\Models\Patient::find($request->patient_id);
            return redirect()->route('dental_management.patients.show', [
                $patient ? $patient->slug : $request->patient_id,
                'tab' => 'consultations'
            ])->with('success', __('dental_management.consultations.create'));
        }

        return redirect()->route('dental_management.consultations.index')
            ->with('success', __('dental_management.consultations.create'));
    }

    public function show($consultation): View
    {
        $consultation = $this->consultationService->find($consultation);

        return view('dental_management.consultations.show', compact('consultation'));
    }

    public function edit(Consultation $consultation, Request $request): View
    {
        $returnUrl = $request->input('return_url');
        $isPatientLocked = $request->filled('return_url');

        // If no return_url but consultation has patient, create return URL to patient view
        if (!$returnUrl && $consultation->patient_id) {
            $patient = $consultation->patient;
            $returnUrl = route('dental_management.patients.show', [
                $patient ? $patient->slug : $consultation->patient_id,
                'tab' => 'consultations'
            ]);
        }

        $backUrl = $returnUrl ?? route('dental_management.consultations.index');

        $treatments = $this->consultationService->getAllTreatments();
        $doctors = $this->consultationService->getAllDoctors();

        return view('dental_management.consultations.edit', compact('consultation', 'returnUrl', 'backUrl', 'treatments', 'doctors', 'isPatientLocked'));
    }

    public function update(UpdateRequest $request, Consultation $consultation): RedirectResponse
    {
        $consultation = $this->consultationService->update($consultation->id, $request->validated());

        if ($request->filled('return_url')) {
            return redirect($request->input('return_url'))
                ->with('success', __('dental_management.consultations.edit'));
        }

        if ($request->has('patient_id') && $request->patient_id) {
            $patient = \App\Models\Patient::find($request->patient_id);
            return redirect(route('dental_management.patients.show', $patient ? $patient->slug : $request->patient_id) . '?tab=consultations')
                ->with('success', __('dental_management.consultations.edit'));
        }

        return redirect()->route('dental_management.consultations.index')
            ->with('success', __('dental_management.consultations.edit'));
    }

    public function editAll(Request $request): View
    {
        $query = Consultation::query()->with(['patient', 'treatment', 'doctor']);
        $query = $query->filter($request);

        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');

        if (in_array($sort, ['id', 'consultation_date', 'cost', 'fever']) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }

        $consultations = $query->paginate(15)->appends($request->all());

        $treatments = $this->consultationService->getAllTreatments();
        $doctors = $this->consultationService->getAllDoctors();

        return view('dental_management.consultations.edit_all', compact('consultations', 'treatments', 'doctors'));
    }


    public function delete(Consultation $consultation): View
    {
        return view('dental_management.consultations.delete', compact('consultation'));
    }

    public function deleteSave(DeleteRequest $request, Consultation $consultation): RedirectResponse
    {
        $patientId = $consultation->patient_id;
        $returnUrl = $request->input('return_url');

        $this->consultationService->delete($consultation->id, $request->validated()['reason']);

        if ($returnUrl) {
            return redirect($returnUrl)
                ->with('success', __('dental_management.consultations.delete'));
        }

        if ($patientId) {
            $patient = \App\Models\Patient::find($patientId);
            return redirect(route('dental_management.patients.show', $patient ? $patient->slug : $patientId) . '?tab=consultations')
                ->with('success', __('dental_management.consultations.delete'));
        }

        return redirect()->route('dental_management.consultations.index')
            ->with('success', __('dental_management.consultations.delete'));
    }

    public function exportExcel(Request $request)
    {
        \App\Jobs\DentalManagement\Consultations\GenerateConsultationsExcelJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }

    public function exportPdf(Request $request)
    {
        \App\Jobs\DentalManagement\Consultations\GenerateConsultationsPdfJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }

    public function exportWord(Request $request)
    {
        \App\Jobs\DentalManagement\Consultations\GenerateConsultationsWordJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }
}
