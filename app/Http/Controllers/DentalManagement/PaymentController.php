<?php

namespace App\Http\Controllers\DentalManagement;

use App\Http\Controllers\Controller;
use App\Services\DentalManagement\PaymentService;
use App\Models\Payment;
use App\Models\Patient;
use App\Http\Requests\DentalManagement\Payment\StoreRequest;
use App\Http\Requests\DentalManagement\Payment\UpdateRequest;
use App\Http\Requests\DentalManagement\Payment\DeleteRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function __construct(
        private PaymentService $paymentService
    ) {}

    public function index(Request $request): View
    {
        $payments = $this->paymentService->getPaginated($request);

        return view('dental_management.payments.index', compact('payments'));
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
            $appointments = $patient ? $patient->appointments()->notDeleted()->with(['treatment', 'doctor'])->get() : collect();

            $data['appointments'] = $appointments;

            // Debug: Ensure appointments are loaded correctly for this patient
            \Log::info('PaymentController create - Appointments loaded for patient', [
                'patient_id' => $patient ? $patient->id : null,
                'appointments_count' => $appointments->count()
            ]);
        } else {
            \Log::info('PaymentController create - No patient_id in request');
            $data['appointments'] = collect();
        }

        return view('dental_management.payments.create', $data);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $payment = $this->paymentService->create($request->validated());

        if ($request->has('patient_id') && $request->patient_id) {
            $patient = \App\Models\Patient::find($request->patient_id);
            return redirect()->route('dental_management.patients.show', $patient ? $patient->slug : $request->patient_id)
                ->with('success', __('dental_management.payments.create'));
        }

        return redirect()->route('dental_management.payments.index')
            ->with('success', __('dental_management.payments.create'));
    }

    public function show($slug, Request $request): View
    {
        $payment = Payment::where('slug', $slug)->notDeleted()->firstOrFail();
        $returnUrl = $request->input('return_url');

        return view('dental_management.payments.show', compact('payment', 'returnUrl'));
    }

    public function edit($slug, Request $request): View
    {
        $payment = Payment::where('slug', $slug)->notDeleted()->firstOrFail();
        $returnUrl = $request->input('return_url');
        $backUrl = $returnUrl ?? route('dental_management.payments.index');
        $lockedPatient = $payment->patient;

        return view('dental_management.payments.edit', compact('payment', 'returnUrl', 'backUrl', 'lockedPatient'));
    }

    public function update(UpdateRequest $request, $slug): RedirectResponse
    {
        $payment = Payment::where('slug', $slug)->notDeleted()->firstOrFail();
        $data = $request->validated();
        $data['patient_id'] = $payment->patient_id; // Prevent changing patient
        $payment = $this->paymentService->update($payment->id, $data);
        $payment->refresh(); // Refresh to get updated data

        if ($request->filled('return_url')) {
            return redirect($request->input('return_url'))
                ->with('success', __('dental_management.payments.edit'));
        }

        if ($request->has('patient_id') && $request->patient_id) {
            $patient = \App\Models\Patient::find($request->patient_id);
            return redirect(route('dental_management.patients.show', $patient ? $patient->slug : $request->patient_id) . '?tab=payments')
                ->with('success', __('dental_management.payments.edit'));
        }

        return redirect()->route('dental_management.payments.index')
            ->with('success', __('dental_management.payments.edit'));
    }

    public function delete($slug, Request $request): View
    {
        $payment = Payment::where('slug', $slug)->notDeleted()->firstOrFail();
        $returnUrl = $request->input('return_url');
        $backUrl = $returnUrl ?? route('dental_management.payments.index');
        return view('dental_management.payments.delete', compact('payment', 'returnUrl', 'backUrl'));
    }

    public function deleteSave(DeleteRequest $request, $slug): RedirectResponse
    {
        $payment = Payment::where('slug', $slug)->notDeleted()->firstOrFail();
        $patientId = $payment->patient_id;
        $returnUrl = $request->input('return_url');

        $this->paymentService->delete($payment->id, $request->validated()['reason']);

        if ($returnUrl) {
            return redirect($returnUrl)
                ->with('success', __('dental_management.payments.delete'));
        }

        if ($patientId) {
            $patient = \App\Models\Patient::find($patientId);
            return redirect(route('dental_management.patients.show', $patient ? $patient->slug : $patientId) . '?tab=payments')
                ->with('success', __('dental_management.payments.delete'));
        }

        return redirect()->route('dental_management.payments.index')
            ->with('success', __('dental_management.payments.delete'));
    }

    public function exportExcel(Request $request)
    {
        return $this->paymentService->exportExcel($request);
    }

    public function exportPdf(Request $request)
    {
        return $this->paymentService->exportPdf($request);
    }

    public function exportWord(Request $request)
    {
        return $this->paymentService->exportWord($request);
    }

    public function searchPatient(Request $request): JsonResponse
    {
        $request->validate([
            'q' => 'nullable|string|max:255',
        ]);

        $query = Patient::notDeleted();

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('document', 'like', "%{$search}%");
            });
        }

        $patients = $query->orderBy('name')->limit(20)->get();

        return response()->json([
            'results' => $patients->map(function ($patient) {
                return [
                    'id' => $patient->id,
                    'text' => trim($patient->name . ' ' . ($patient->last_name ?? '')) . ' - ' . $patient->document,
                ];
            }),
        ]);
    }

    public function searchPatientAppointments(Request $request): JsonResponse
    {
        $request->validate([
            'patient_id' => 'required|integer|exists:patients,id',
        ]);

        $appointments = \App\Models\Appointment::where('patient_id', $request->patient_id)
            ->notDeleted()
            ->with(['treatment'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        return response()->json([
            'appointments' => $appointments->map(function ($appointment) {
                return [
                    'id' => $appointment->id,
                    'appointment_date' => $appointment->appointment_date->format('Y-m-d'),
                    'appointment_time' => $appointment->appointment_time?->format('H:i:s'),
                    'treatment' => $appointment->treatment ? [
                        'name' => $appointment->treatment->name
                    ] : null,
                ];
            }),
        ]);
    }

    public function editAll(Request $request): View
    {
        $payments = $this->paymentService->getPaginated($request);

        return view('dental_management.payments.edit_all', compact('payments'));
    }

    public function updateInline(Request $request): JsonResponse
    {
        $payment = Payment::findOrFail($request->id);
        $payment->{$request->field} = $request->value;
        $payment->save();

        return response()->json(['success' => true]);
    }
}
