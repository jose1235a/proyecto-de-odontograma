<?php

namespace App\Http\Controllers\DentalManagement;

use App\Http\Controllers\Controller;
use App\Services\DentalManagement\PatientImageService;
use App\Models\PatientImage;
use App\Models\Patient;
use App\Http\Requests\DentalManagement\PatientImage\StoreRequest;
use App\Http\Requests\DentalManagement\PatientImage\UpdateRequest;
use App\Http\Requests\DentalManagement\PatientImage\DeleteRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PatientImageController extends Controller
{
    public function __construct(
        private PatientImageService $patientImageService
    ) {
        // Solo aplicar middleware de permisos cuando NO se accede desde el contexto del paciente
        if (!request()->has('from_patient') || request()->get('from_patient') !== 'true') {
            $this->middleware('permission:patient_images.view')->only(['index', 'show']);
            $this->middleware('permission:patient_images.create')->only(['create', 'store']);
            $this->middleware('permission:patient_images.edit')->only(['edit', 'update', 'editAll']);
            $this->middleware('permission:patient_images.delete')->only(['delete', 'deleteSave']);
            $this->middleware('permission:patient_images.export')->only(['exportExcel', 'exportPdf', 'exportWord']);
        }
    }

    public function index(Request $request): View
    {
        $patientImages = $this->patientImageService->getPaginated($request);

        return view('dental_management.patient_images.index', compact('patientImages'));
    }

    public function create(Request $request): View
    {
        $patientId = $request->get('patient_id');
        $patient = null;

        if ($patientId) {
            $patient = Patient::find($patientId);
        }

        return view('dental_management.patient_images.create', compact('patient'));
    }

    public function store(StoreRequest $request)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                // Crear registro directamente con los datos validados
                $patientImagesPath = storage_path('app/public/patient_images');

                // Crear directorio si no existe
                if (!file_exists($patientImagesPath)) {
                    mkdir($patientImagesPath, 0755, true);
                }

                // Generar nombre único para el archivo
                $extension = $request->file('image')->getClientOriginalExtension();
                $filename = 'patient_' . $data['patient_id'] . '_img_' . time() . '_' . uniqid() . '.' . $extension;

                // Mover archivo
                $request->file('image')->move($patientImagesPath, $filename);

                // Crear registro en BD
                $patientImageData = [
                    'patient_id' => $data['patient_id'],
                    'title' => $data['title'],
                    'filename' => $filename,
                    'description' => $data['description'] ?? null,
                    'created_by' => auth()->id(),
                ];

                $patientImage = PatientImage::create($patientImageData);

            } elseif ($request->filled('photo')) {
                // Procesar foto tomada con webcam
                $patientImagesPath = storage_path('app/public/patient_images');

                // Crear directorio si no existe
                if (!file_exists($patientImagesPath)) {
                    mkdir($patientImagesPath, 0755, true);
                }

                // Procesar imagen base64
                $imageData = $request->input('photo');
                $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
                $imageData = str_replace('data:image/png;base64,', '', $imageData);
                $imageData = str_replace('data:image/jpg;base64,', '', $imageData);
                $imageData = str_replace('data:image/gif;base64,', '', $imageData);
                $imageData = str_replace(' ', '+', $imageData);

                $imageBinary = base64_decode($imageData);

                // Generar nombre único
                $filename = 'patient_' . $data['patient_id'] . '_photo_' . time() . '_' . uniqid() . '.jpg';

                // Guardar archivo
                file_put_contents($patientImagesPath . '/' . $filename, $imageBinary);

                // Crear registro en BD
                $patientImageData = [
                    'patient_id' => $data['patient_id'],
                    'title' => $data['title'],
                    'filename' => $filename,
                    'description' => $data['description'] ?? null,
                    'created_by' => auth()->id(),
                ];

                $patientImage = PatientImage::create($patientImageData);
            } else {
                $error = ['image' => 'Debe proporcionar una imagen o tomar una foto.'];

                if ($request->ajax()) {
                    return response()->json(['success' => false, 'errors' => $error], 422);
                }
                return back()->withErrors($error);
            }

            // Respuesta según el tipo de petición
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => __('dental_management.patient_images.create'),
                    'data' => $patientImage
                ]);
            }

            $patient = Patient::find($data['patient_id']);
            return redirect()->route('dental_management.patients.show', [
                $patient ? $patient->slug : $data['patient_id'],
                'tab' => 'images'
            ])->with('success', __('dental_management.patient_images.create'));

        } catch (\Exception $e) {
            $error = ['error' => 'Error al guardar la imagen: ' . $e->getMessage()];

            if ($request->ajax()) {
                return response()->json(['success' => false, 'errors' => $error], 500);
            }
            return back()->withErrors($error);
        }
    }

    public function show(PatientImage $patientImage): View
    {
        return view('dental_management.patient_images.show', compact('patientImage'));
    }

    public function edit(PatientImage $patientImage, Request $request): View
    {
        $returnUrl = $request->input('return_url');

        // If no return_url but patient exists, create return URL to patient view
        if (!$returnUrl && $patientImage->patient_id) {
            $patient = $patientImage->patient;
            $returnUrl = route('dental_management.patients.show', [
                $patient ? $patient->slug : $patientImage->patient_id,
                'tab' => 'images'
            ]);
        }

        $backUrl = $returnUrl ?? route('dental_management.patient_images.index');

        return view('dental_management.patient_images.edit', compact('patientImage', 'returnUrl', 'backUrl'));
    }

    public function update(UpdateRequest $request, PatientImage $patientImage)
    {
        try {
            $updateData = $request->validated();

            // Manejar nueva imagen si se proporciona
            if ($request->hasFile('image')) {
                // Eliminar imagen anterior si existe
                $oldImagePath = storage_path('app/public/patient_images/' . $patientImage->filename);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }

                // Procesar nueva imagen
                $patientImagesPath = storage_path('app/public/patient_images');
                if (!file_exists($patientImagesPath)) {
                    mkdir($patientImagesPath, 0755, true);
                }

                $extension = $request->file('image')->getClientOriginalExtension();
                $filename = 'patient_' . $patientImage->patient_id . '_img_' . time() . '_' . uniqid() . '.' . $extension;
                $request->file('image')->move($patientImagesPath, $filename);

                $updateData['filename'] = $filename;
            } elseif ($request->filled('photo')) {
                // Eliminar imagen anterior si existe
                $oldImagePath = storage_path('app/public/patient_images/' . $patientImage->filename);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }

                // Procesar foto tomada
                $patientImagesPath = storage_path('app/public/patient_images');
                if (!file_exists($patientImagesPath)) {
                    mkdir($patientImagesPath, 0755, true);
                }

                $imageData = $request->input('photo');
                $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
                $imageData = str_replace('data:image/png;base64,', '', $imageData);
                $imageData = str_replace('data:image/jpg;base64,', '', $imageData);
                $imageData = str_replace('data:image/gif;base64,', '', $imageData);
                $imageData = str_replace(' ', '+', $imageData);

                $imageBinary = base64_decode($imageData);
                $filename = 'patient_' . $patientImage->patient_id . '_photo_' . time() . '_' . uniqid() . '.jpg';
                file_put_contents($patientImagesPath . '/' . $filename, $imageBinary);

                $updateData['filename'] = $filename;
            }

            $patientImage = $this->patientImageService->update($patientImage->id, $updateData);

            // Si es una petición AJAX, devolver JSON
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => __('dental_management.patient_images.edit'),
                    'data' => $patientImage
                ]);
            }

            // Para peticiones normales, hacer redirect
            if ($request->filled('return_url')) {
                return redirect($request->input('return_url'))
                    ->with('success', __('dental_management.patient_images.edit'));
            }

            if ($patientImage->patient_id) {
                $patient = $patientImage->patient;
                return redirect(route('dental_management.patients.show', [
                    $patient ? $patient->slug : $patientImage->patient_id,
                    'tab' => 'images'
                ]))->with('success', __('dental_management.patient_images.edit'));
            }

            return redirect()->route('dental_management.patient_images.index')
                ->with('success', __('dental_management.patient_images.edit'));

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Imagen no encontrada
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'La imagen ya no existe o fue eliminada anteriormente.'
                ], 404);
            }

            return redirect()->back()
                ->with('error', 'La imagen ya no existe o fue eliminada anteriormente.');
        }
    }

    public function editAll(Request $request): View
    {
        $query = PatientImage::query()->with(['patient']);
        $query = $query->filter($request);

        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');

        if (in_array($sort, ['id', 'title', 'created_at']) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }

        $patientImages = $query->paginate(15)->appends($request->all());

        return view('dental_management.patient_images.edit_all', compact('patientImages'));
    }

    public function delete(PatientImage $patientImage): View
    {
        return view('dental_management.patient_images.delete', compact('patientImage'));
    }

    public function destroy(DeleteRequest $request, PatientImage $patientImage)
    {
        try {
            $patientId = $patientImage->patient_id;

            $this->patientImageService->delete($patientImage->id, $request->validated()['reason']);

            // Si es una petición AJAX, devolver JSON
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => __('dental_management.patient_images.delete')
                ]);
            }

            // Para peticiones normales, hacer redirect
            if ($patientId) {
                $patient = Patient::find($patientId);
                return redirect(route('dental_management.patients.show', [
                    $patient ? $patient->slug : $patientId,
                    'tab' => 'images'
                ]))->with('success', __('dental_management.patient_images.delete'));
            }

            return redirect()->route('dental_management.patient_images.index')
                ->with('success', __('dental_management.patient_images.delete'));

        } catch (\Exception $e) {
            // Cualquier otro error
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar la imagen: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Error al eliminar la imagen: ' . $e->getMessage());
        }
    }

    public function exportExcel(Request $request)
    {
        \App\Jobs\DentalManagement\PatientImages\GeneratePatientImagesExcelJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }

    public function exportPdf(Request $request)
    {
        \App\Jobs\DentalManagement\PatientImages\GeneratePatientImagesPdfJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }

    public function exportWord(Request $request)
    {
        \App\Jobs\DentalManagement\PatientImages\GeneratePatientImagesWordJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }
}
