<?php

namespace App\Services\DentalManagement;

use App\Models\Patient;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PatientService
{
    public function getPaginated(Request $request): LengthAwarePaginator
    {
        $query = Patient::query()
            ->filter($request)
            ->notDeleted();

        if (!$request->filled('sort')) {
            $query->orderBy('name');
        }

        return $query->paginate(10)->appends($request->all());
    }

    public function create(array $data): Patient
    {
        $data['created_by'] = auth()->id();
        return Patient::create($data);
    }

    public function find($id): Patient
    {
        return Patient::findOrFail($id);
    }

    public function update($id, array $data): Patient
    {
        $patient = $this->find($id);
        $patient->update($data);
        return $patient;
    }

    public function delete($id, string $reason): void
    {
        $patient = $this->find($id);
        $patient->update([
            'deleted_description' => $reason,
            'deleted_by' => auth()->id(),
        ]);
        $patient->delete();
    }

    public function getAll()
    {
        return Patient::notDeleted()->get();
    }

    public function updateInline(array $data): void
    {
        foreach ($data['patients'] ?? [] as $id => $patientData) {
            $this->update($id, $patientData);
        }
    }

    public function exportExcel(Request $request)
    {
        \App\Jobs\DentalManagement\Patients\GeneratePatientsExcelJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }

    public function exportPdf(Request $request)
    {
        \App\Jobs\DentalManagement\Patients\GeneratePatientsPdfJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }

    public function exportWord(Request $request)
    {
        \App\Jobs\DentalManagement\Patients\GeneratePatientsWordJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }

    private function uploadPhoto($file): string
    {
        $slug = Str::slug(auth()->user()->name) . '-' . time();
        $filename = time() . '_' . $file->getClientOriginalName();

        // Store in storage/app/public/patients/{slug}/
        $path = $file->storeAs("patients/{$slug}", $filename, 'public');

        return $path;
    }
}
