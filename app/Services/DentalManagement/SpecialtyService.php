<?php

namespace App\Services\DentalManagement;

use App\Models\Specialty;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class SpecialtyService
{
    public function getPaginated(Request $request): LengthAwarePaginator
    {
        $query = Specialty::query()
            ->filter($request)
            ->notDeleted();

        if (!$request->filled('sort')) {
            $query->orderBy('name');
        }

        return $query->paginate(10)->appends($request->all());
    }

    public function create(array $data): Specialty
    {
        $data['created_by'] = auth()->id();
        return Specialty::create($data);
    }

    public function find($id): Specialty
    {
        return Specialty::findOrFail($id);
    }

    public function update($id, array $data): Specialty
    {
        $specialty = $this->find($id);
        $specialty->update($data);
        return $specialty;
    }

    public function delete($id, string $reason): void
    {
        $specialty = $this->find($id);
        $specialty->update([
            'deleted_description' => $reason,
            'deleted_by' => auth()->id(),
        ]);
        $specialty->delete();
    }

    public function getAll(Request $request)
    {
        return Specialty::query()
            ->filter($request)
            ->notDeleted()
            ->orderBy('name')
            ->get();
    }

    public function updateInline(array $data)
    {
        foreach ($data['specialties'] ?? [] as $specialtyData) {
            $this->update($specialtyData['id'], $specialtyData);
        }
    }

    public function exportExcel(Request $request)
    {
        \App\Jobs\DentalManagement\Specialties\GenerateSpecialtiesExcelJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }

    public function exportPdf(Request $request)
    {
        \App\Jobs\DentalManagement\Specialties\GenerateSpecialtiesPdfJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }

    public function exportWord(Request $request)
    {
        \App\Jobs\DentalManagement\Specialties\GenerateSpecialtiesWordJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }
}
