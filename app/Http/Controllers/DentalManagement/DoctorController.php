<?php

namespace App\Http\Controllers\DentalManagement;

use App\Http\Controllers\Controller;
use App\Services\DentalManagement\DoctorService;
use App\Models\Doctor;
use App\Http\Requests\DentalManagement\Doctor\StoreRequest;
use App\Http\Requests\DentalManagement\Doctor\UpdateRequest;
use App\Http\Requests\DentalManagement\Doctor\DeleteRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DoctorController extends Controller
{
    public function __construct(
        private DoctorService $doctorService
    ) {
        $this->middleware('permission:doctors.view')->only(['index', 'show']);
        $this->middleware('permission:doctors.create')->only(['create', 'store']);
        $this->middleware('permission:doctors.edit')->only(['edit', 'update', 'editAll', 'updateInline']);
        $this->middleware('permission:doctors.delete')->only(['delete', 'deleteSave']);
        $this->middleware('permission:doctors.export')->only(['exportExcel', 'exportPdf', 'exportWord']);
    }

    public function index(Request $request): View
    {
        $doctors = $this->doctorService->getPaginated($request);
        $specialties = $this->doctorService->getAllSpecialties();

        return view('dental_management.doctors.index', compact('doctors', 'specialties'));
    }

    public function create(): View
    {
        $specialties = $this->doctorService->getAllSpecialties();

        return view('dental_management.doctors.create', compact('specialties'));
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $this->doctorService->create($request->validated());

        return redirect()->route('dental_management.doctors.index')
            ->with('success', __('dental_management.doctors.create'));
    }

    public function show(Doctor $doctor): View
    {
        return view('dental_management.doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor): View
    {
        $specialties = $this->doctorService->getAllSpecialties();

        return view('dental_management.doctors.edit', compact('doctor', 'specialties'));
    }

    public function update(UpdateRequest $request, Doctor $doctor): RedirectResponse
    {
        $this->doctorService->update($doctor->slug, $request->validated());

        return redirect()->route('dental_management.doctors.index')
            ->with('success', __('dental_management.doctors.edit'));
    }

    public function editAll(Request $request): View
    {
        $query = Doctor::query()->with('specialties');
        $query = $query->filter($request);

        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');

        if (in_array($sort, ['id', 'name', 'last_name', 'email', 'document', 'is_active']) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }

        $doctors = $query->paginate(15)->appends($request->all());

        $doctors->getCollection()->transform(function (Doctor $doctor) {
            if (!isset($doctor->specialty_id)) {
                $doctor->specialty_id = $doctor->specialties->first()->id ?? null;
            }

            return $doctor;
        });
        $specialties = $this->doctorService->getAllSpecialties();

        return view('dental_management.doctors.edit_all', compact('doctors', 'specialties'));
    }

    public function updateInline(Request $request): JsonResponse
    {
        $request->validate([
            'id' => ['required', 'integer', 'exists:doctors,id'],
            'field' => ['required', 'string', 'in:document_type,document,name,last_name,email,phone,address,is_active,specialty_id'],
        ]);

        $doctor = Doctor::findOrFail($request->id);
        $field = $request->field;
        $value = $request->value;

        $rules = match ($field) {
            'document_type' => ['required', 'string', 'in:dni,passport,other'],
            'document' => ['required', 'string', 'max:20', Rule::unique('doctors', 'document')->ignore($doctor->id)],
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('doctors', 'email')->ignore($doctor->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'specialty_id' => ['required', 'integer', 'exists:specialties,id'],
            'is_active' => ['required', 'in:0,1'],
            default => ['nullable'],
        };

        $request->validate(['value' => $rules]);

        $normalizedValue = match ($field) {
            'document_type' => $value ? strtolower($value) : null,
            'phone', 'address' => $value !== '' ? $value : null,
            'is_active' => (int) $value,
            default => $value,
        };

        if ($field === 'specialty_id') {
            $doctor->specialties()->sync([$normalizedValue]);
            $doctor->specialty_id = $normalizedValue;
        } else {
            $doctor->{$field} = $normalizedValue;
            $doctor->save();
        }

        return response()->json(['success' => true]);
    }

    public function delete(Doctor $doctor): View
    {
        return view('dental_management.doctors.delete', compact('doctor'));
    }

    public function deleteSave(DeleteRequest $request, Doctor $doctor): RedirectResponse
    {
        $this->doctorService->delete($doctor->slug, $request->validated()['reason']);

        return redirect()->route('dental_management.doctors.index')
            ->with('success', __('dental_management.doctors.delete'));
    }

    public function exportExcel(Request $request)
    {
        return $this->doctorService->exportExcel($request);
    }

    public function exportPdf(Request $request)
    {
        return $this->doctorService->exportPdf($request);
    }

    public function exportWord(Request $request)
    {
        return $this->doctorService->exportWord($request);
    }

    public function dniLookup(Request $request)
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

            if ($response->getStatusCode() == 200) {
                $data = json_decode($response->getBody(), true);
                if (isset($data['nombres']) && isset($data['apellidoPaterno']) && isset($data['apellidoMaterno'])) {
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
}
