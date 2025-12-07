<?php

namespace App\Http\Controllers\DentalManagement;

use App\Http\Controllers\Controller;
use App\Services\DentalManagement\AppointmentService;
use App\Models\Appointment;
use App\Models\Patient;
use App\Events\AppointmentCreated;
use App\Http\Requests\DentalManagement\Appointment\StoreRequest;
use App\Http\Requests\DentalManagement\Appointment\UpdateRequest;
use App\Http\Requests\DentalManagement\Appointment\DeleteRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function __construct(
        private AppointmentService $appointmentService
    ) {}

    public function index(Request $request): View|\Illuminate\Http\JsonResponse
    {
        $appointments = $this->appointmentService->getPaginated($request);

        // Return JSON for API requests
        if ($request->wantsJson() || $request->get('api')) {
            return response()->json([
                'success' => true,
                'data' => $appointments->items(),
                'total' => $appointments->total(),
                'current_page' => $appointments->currentPage(),
                'last_page' => $appointments->lastPage(),
            ]);
        }

        $doctors = $this->appointmentService->getDoctors();
        $treatments = $this->appointmentService->getTreatments();

        return view('dental_management.appointments.index', compact('appointments', 'doctors', 'treatments'));
    }

    public function create(): View
    {
        $data = $this->formData();
        $lockedPatient = null;

        if (request()->has('patient_id')) {
            $patientId = request()->patient_id;
            // Try to find by slug first, then by ID
            $patient = Patient::where('slug', $patientId)->first() ?? Patient::find($patientId);
            $data['patient_id'] = $patient ? $patient->id : $patientId;
            if ($patient) {
                $lockedPatient = $patient;
                $data['patients'] = collect([$patient]);
            }
        }

        $data['lockedPatient'] = $lockedPatient;

        return view('dental_management.appointments.create', $data);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $appointment = $this->appointmentService->create($request->validated());

        // Dispatch event to cancel overdue appointments
        event(new AppointmentCreated($appointment));

        if ($request->filled('return_url')) {
            return redirect($request->input('return_url'))
                ->with('success', __('dental_management.appointments.create'));
        }

        return redirect()->route('dental_management.appointments.index')
            ->with('success', __('dental_management.appointments.create'));
    }

    public function show(Appointment $appointment): View
    {
        $appointment->loadMissing(['patient', 'doctor', 'treatment', 'creator', 'deleter']);

        return view('dental_management.appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment): View
    {
        $appointment->loadMissing(['patient', 'doctor', 'treatment']);

        return view('dental_management.appointments.edit', array_merge(
            $this->formData(),
            ['appointment' => $appointment]
        ));
    }

    public function update(UpdateRequest $request, Appointment $appointment): RedirectResponse
    {
        $appointment = $this->appointmentService->update($appointment->id, $request->validated());

        if ($request->filled('return_url')) {
            return redirect($request->input('return_url'))
                ->with('success', __('dental_management.appointments.edit'));
        }

        return redirect()->route('dental_management.appointments.index')
            ->with('success', __('dental_management.appointments.edit'));
    }

    public function delete(Appointment $appointment): View
    {
        $appointment->loadMissing(['patient', 'doctor', 'treatment']);

        return view('dental_management.appointments.delete', compact('appointment'));
    }

    public function deleteSave(DeleteRequest $request, Appointment $appointment): RedirectResponse
    {
        $patientId = $appointment->patient_id;
        $returnUrl = $request->input('return_url');

        $this->appointmentService->delete($appointment->id, $request->validated()['reason']);

        if ($returnUrl) {
            return redirect($returnUrl)
                ->with('success', __('dental_management.appointments.delete'));
        }

        if ($patientId) {
            return redirect()->route('dental_management.patients.show', $patientId)
                ->with('success', __('dental_management.appointments.delete'));
        }

        return redirect()->route('dental_management.appointments.index')
            ->with('success', __('dental_management.appointments.delete'));
    }

    public function searchPatient(Request $request): JsonResponse
    {
        $request->validate([
            'document' => 'required|string',
        ]);

        $patient = Patient::where('document', $request->get('document'))->first();

        if (!$patient) {
            return response()->json([
                'message' => __('dental_management.appointments.messages.patient_not_found'),
            ], 404);
        }

        return response()->json([
            'patient' => [
                'id' => $patient->id,
                'name' => trim($patient->name . ' ' . ($patient->last_name ?? '')),
                'document' => $patient->document,
            ],
        ]);
    }

    public function editAll(Request $request): View
    {
        $appointments = $this->appointmentService->getPaginated($request);

        return view('dental_management.appointments.edit_all', array_merge(
            $this->formData(),
            ['appointments' => $appointments]
        ));
    }

    public function updateInline(Request $request): JsonResponse
    {
        $request->validate([
            'id' => ['required', 'integer', 'exists:appointments,id'],
            'field' => ['required', 'in:status,cost,paid,appointment_time'],
        ]);

        $appointment = Appointment::findOrFail($request->id);
        $field = $request->field;
        $value = $request->value;

        $rules = match ($field) {
            'status' => ['required', 'in:scheduled,completed,cancelled'],
            'cost', 'paid' => ['required', 'numeric', 'min:0'],
            'appointment_time' => ['required', 'date_format:H:i'],
        };

        $request->validate(['value' => $rules]);

        $normalizedValue = match ($field) {
            'cost', 'paid' => round((float) $value, 2),
            'appointment_time' => Carbon::createFromFormat('H:i', $value)->format('H:i:s'),
            default => $value,
        };

        $appointment->{$field} = $normalizedValue;
        $appointment->save();

        $responseValue = $field === 'appointment_time'
            ? $appointment->appointment_time?->format('H:i')
            : ($field === 'cost' || $field === 'paid' ? number_format($appointment->{$field}, 2, '.', '') : $appointment->{$field});

        return response()->json([
            'success' => true,
            'value' => $responseValue,
        ]);
    }

    public function exportExcel(Request $request)
    {
        return $this->appointmentService->exportExcel($request);
    }

    public function exportPdf(Request $request)
    {
        return $this->appointmentService->exportPdf($request);
    }

    public function exportWord(Request $request)
    {
        return $this->appointmentService->exportWord($request);
    }

    private function formData(): array
    {
        return [
            'treatments' => $this->appointmentService->getTreatments(),
            'doctors' => $this->appointmentService->getDoctors(),
            'patients' => $this->appointmentService->getPatients(),
        ];
    }
}
