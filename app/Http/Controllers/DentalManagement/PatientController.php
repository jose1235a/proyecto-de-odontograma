<?php

namespace App\Http\Controllers\DentalManagement;

use App\Http\Controllers\Controller;
use App\Services\DentalManagement\PatientService;
use App\Models\Patient;
use App\Models\Consultation;
use App\Models\Odontogram;
use App\Models\OdontogramHistory;
use App\Models\TreatmentHistory;
use App\Models\Treatment;
use Illuminate\Support\Str;
use App\Http\Requests\DentalManagement\Patient\StoreRequest;
use App\Http\Requests\DentalManagement\Patient\UpdateRequest;
use App\Http\Requests\DentalManagement\Patient\DeleteRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public function __construct(
        private PatientService $patientService
    ) {}

    public function index(Request $request): View
    {
        $patients = $this->patientService->getPaginated($request);

        return view('dental_management.patients.index', compact('patients'));
    }

    public function create(): View
    {
        return view('dental_management.patients.create');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Set defaults for medical conditions
        $data['under_medical_treatment'] = $data['under_medical_treatment'] ?? 0;
        $data['prone_to_bleeding'] = $data['prone_to_bleeding'] ?? 0;
        $data['allergic_to_medication'] = $data['allergic_to_medication'] ?? 0;
        $data['hypertensive'] = $data['hypertensive'] ?? 0;
        $data['diabetic'] = $data['diabetic'] ?? 0;

        if (isset($data['gender']) && $data['gender'] === 'M') {
            $data['pregnant'] = null;
            $data['pregnant_description'] = null;
        } else {
            $data['pregnant'] = $data['pregnant'] ?? 0;
        }

        $patient = null;

        DB::transaction(function () use ($data, $request, &$patient) {
            // Create patient
            $patient = $this->patientService->create($data);

            // Handle photo upload
            if ($request->hasFile('photo')) {
                $this->handlePhotoUpload($request->file('photo'), $patient->id);
            }

            // Create first consultation
            $consultationData = [
                'patient_id' => $patient->id,
                'treatment_id' => $data['treatment_id'],
                'doctor_id' => $data['doctor_id'],
                'consultation_date' => $data['consultation_date'],
                'consultation_time' => $data['consultation_time'] ?? null,
                'cost' => $data['consultation_cost'],
                'description' => $data['consultation_description'] ?? null,
                'consultation_reason' => $data['consultation_reason'] ?? null,
                'diagnosis' => $data['diagnosis'] ?? null,
                'fever' => $data['fever'] ?? null,
                'blood_pressure' => $data['blood_pressure'] ?? null,
                'created_by' => auth()->id(),
            ];

            Consultation::create($consultationData);

            // Create default odontogram
            $odontogram = Odontogram::create([
                'patient_id' => $patient->id,
                'is_active' => true,
                'created_by' => auth()->id(),
            ]);
        });

        return redirect()->route('dental_management.patients.show', $patient)
            ->with('success', __('dental_management.patients.create'));
    }

    public function show(Patient $patient, Request $request): View
    {
        $patient->load([
            'appointments.treatment',
            'appointments.doctor',
            'odontograms.latestHistory.doctor',
            'consultations.treatment',
            'consultations.doctor',
            'patientImages'
        ]);

        // Get filtered payments
        $paymentsQuery = $patient->payments();

        // Apply filters
        if ($request->filled('status')) {
            $paymentsQuery->where('status', $request->status);
        }

        if ($request->filled('payment_method')) {
            $paymentsQuery->where('payment_method', $request->payment_method);
        }

        if ($request->filled('start_date')) {
            $paymentsQuery->whereDate('payment_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $paymentsQuery->whereDate('payment_date', '<=', $request->end_date);
        }

        $payments = $paymentsQuery->orderBy('id', 'desc')->paginate(15)->appends($request->all());

        $treatmentHistory = $patient->odontograms()
            ->with(['histories.doctor'])
            ->get()
            ->flatMap(function ($odontogram) {
                return $odontogram->histories;
            })
            ->sortByDesc(function ($history) {
                return $history->date_procedure ?? $history->created_at;
            })
            ->map(function ($history) {
                $registeredAt = optional($history->date_procedure ?? $history->created_at)
                    ->timezone(config('app.timezone'));

                return [
                    'registered_at' => $registeredAt ? $registeredAt->format('d/m/Y H:i') : null,
                    'registered_timestamp' => $registeredAt ? $registeredAt->timestamp : null,
                    'description' => $history->description,
                    'doctor' => $history->doctor ? [
                        'name' => $history->doctor->name,
                        'last_name' => $history->doctor->last_name
                    ] : null,
                ];
            })
            ->values()
            ->all();

        return view('dental_management.patients.show', compact('patient', 'payments', 'treatmentHistory'));
    }

    public function edit(Patient $patient): View
    {
        return view('dental_management.patients.edit', compact('patient'));
    }

    public function update(UpdateRequest $request, Patient $patient): RedirectResponse
    {
        $data = $request->validated();

        if (isset($data['gender']) && $data['gender'] === 'M') {
            $data['pregnant'] = null;
            $data['pregnant_description'] = null;
        }

        $this->patientService->update($patient->id, $data);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $this->handlePhotoUpload($request->file('photo'), $patient->id);
        }

        return redirect()->route('dental_management.patients.show', $patient->slug)
            ->with('success', __('dental_management.patients.edit'));
    }

    public function delete(Patient $patient): View
    {
        return view('dental_management.patients.delete', compact('patient'));
    }

    public function deleteSave(DeleteRequest $request, Patient $patient): RedirectResponse
    {
        $this->patientService->delete($patient->id, $request->validated()['reason']);

        return redirect()->route('dental_management.patients.index')
            ->with('success', __('dental_management.patients.delete'));
    }

    public function editAll(Request $request): View
    {
        $query = Patient::query()->filter($request);

        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');

        if (in_array($sort, ['id', 'name', 'is_active']) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }

        $patients = $query->paginate(15)->appends($request->all());

        return view('dental_management.patients.edit_all', compact('patients'));
    }

    public function updateInline(Request $request): JsonResponse
    {
        $patient = Patient::findOrFail($request->id);
        $patient->{$request->field} = $request->value;
        $patient->save();

        return response()->json(['success' => true]);
    }

    public function exportExcel(Request $request)
    {
        return $this->patientService->exportExcel($request);
    }

    public function exportPdf(Request $request)
    {
        return $this->patientService->exportPdf($request);
    }

    public function exportWord(Request $request)
    {
        return $this->patientService->exportWord($request);
    }

    public function dniLookup(Request $request): JsonResponse
    {
        $request->validate([
            'dni' => 'required|string|size:8|regex:/^[0-9]+$/',
        ]);

        try {
            $dni = $request->input('dni');
            $apiKey = config('services.sunat_api_token');
            $client = new \GuzzleHttp\Client();
            $response = $client->get("https://api.apis.net.pe/v1/dni?numero={$dni}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                ]
            ]);

            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody(), true);
                if (isset($data['nombres'], $data['apellidoPaterno'], $data['apellidoMaterno'])) {
                    return response()->json([
                        'success' => true,
                        'name' => $data['nombres'],
                        'last_name' => $data['apellidoPaterno'] . ' ' . $data['apellidoMaterno'],
                    ]);
                }
            }

            return response()->json(['success' => false, 'message' => 'No se encontraron datos para este DNI']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al consultar el DNI']);
        }
    }

    public function uploadImage(Request $request, Patient $patient): JsonResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        try {
            $patientImagesPath = storage_path('app/public/patient_images');

            if (!file_exists($patientImagesPath)) {
                mkdir($patientImagesPath, 0755, true);
            }

            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = 'patient_' . $patient->id . '_img_' . time() . '_' . uniqid() . '.' . $extension;

            $request->file('image')->move($patientImagesPath, $filename);

            return response()->json([
                'success' => true,
                'message' => 'Imagen subida correctamente',
                'filename' => $filename,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al subir la imagen: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function deleteImage(Request $request, Patient $patient): JsonResponse
    {
        try {
            $imageName = $request->input('image');

            if (!$imageName) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nombre de imagen requerido',
                ], 400);
            }

            if (strpos($imageName, 'patient_' . $patient->id . '_') !== 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'La imagen no pertenece a este paciente',
                ], 403);
            }

            $imagePath = storage_path('app/public/patient_images/' . $imageName);

            if (!file_exists($imagePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'La imagen no existe en el servidor',
                ], 404);
            }

            unlink($imagePath);

            return response()->json([
                'success' => true,
                'message' => 'Imagen eliminada correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la imagen: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle photo upload for patients
     */
    private function handlePhotoUpload($file, $patientId)
    {
        try {
            $patientPhotosPath = public_path('storage/patient_photos');

            // Create directory if it doesn't exist
            if (!file_exists($patientPhotosPath)) {
                mkdir($patientPhotosPath, 0755, true);
            }

            // Delete existing photo if it exists
            $existingPhotoPath = $patientPhotosPath . '/' . $patientId . '.jpg';
            if (file_exists($existingPhotoPath)) {
                unlink($existingPhotoPath);
            }

            // Save new photo with patient ID as filename
            $filename = $patientId . '.jpg';
            $file->move($patientPhotosPath, $filename);

        } catch (\Exception $e) {
            // Log error but don't stop the process
            \Log::error('Error uploading patient photo: ' . $e->getMessage());
        }
    }
}
