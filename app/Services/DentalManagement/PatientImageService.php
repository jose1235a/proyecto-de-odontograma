<?php

namespace App\Services\DentalManagement;

use App\Models\PatientImage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class PatientImageService
{
    public function getPaginated(Request $request): LengthAwarePaginator
    {
        return PatientImage::query()
            ->with(['patient'])
            ->filter($request)
            ->notDeleted()
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    public function create(array $data): PatientImage
    {
        $data['created_by'] = auth()->id();
        return PatientImage::create($data);
    }

    public function find($id): PatientImage
    {
        return PatientImage::findOrFail($id);
    }

    public function update($id, array $data): PatientImage
    {
        $patientImage = $this->find($id);
        $patientImage->update($data);
        return $patientImage;
    }

    public function delete($id, string $reason): void
    {
        $patientImage = $this->find($id);

        // Eliminar archivo físico si existe
        $imagePath = storage_path('app/public/patient_images/' . $patientImage->filename);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $patientImage->update([
            'deleted_description' => $reason,
            'deleted_by' => auth()->id(),
        ]);
        $patientImage->delete();
    }

    public function getAllForPatient($patientId)
    {
        return PatientImage::query()
            ->where('patient_id', $patientId)
            ->notDeleted()
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function uploadImage(Request $request, $patientId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'description' => 'nullable|string|max:1000',
        ]);

        $patientImagesPath = storage_path('app/public/patient_images');

        // Crear directorio si no existe
        if (!file_exists($patientImagesPath)) {
            mkdir($patientImagesPath, 0755, true);
        }

        // Generar nombre único para el archivo
        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = 'patient_' . $patientId . '_img_' . time() . '_' . uniqid() . '.' . $extension;

        // Mover archivo
        $request->file('image')->move($patientImagesPath, $filename);

        // Crear registro en BD
        $data = [
            'patient_id' => $patientId,
            'title' => $request->input('title'),
            'filename' => $filename,
            'description' => $request->input('description'),
        ];

        return $this->create($data);
    }

    public function takePhoto(Request $request, $patientId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'photo' => 'required|string', // Base64 image data
            'description' => 'nullable|string|max:1000',
        ]);

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
        $filename = 'patient_' . $patientId . '_photo_' . time() . '_' . uniqid() . '.jpg';

        // Guardar archivo
        file_put_contents($patientImagesPath . '/' . $filename, $imageBinary);

        // Crear registro en BD
        $data = [
            'patient_id' => $patientId,
            'title' => $request->input('title'),
            'filename' => $filename,
            'description' => $request->input('description'),
        ];

        return $this->create($data);
    }
}