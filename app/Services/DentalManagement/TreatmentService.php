<?php

namespace App\Services\DentalManagement;

use App\Models\Treatment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class TreatmentService
{
    public function getPaginated(Request $request): LengthAwarePaginator
    {
        $query = Treatment::query()
            ->filter($request)
            ->notDeleted();

        if (!$request->filled('sort')) {
            $query->orderBy('name');
        }

        return $query->paginate(10)->appends($request->all());
    }

    public function create(array $data): Treatment
    {
        $data['created_by'] = auth()->id();
        $data['is_active'] = true;
        $data['description'] = $data['description'] ?? null;
        $data['coverage'] = $data['coverage'] ?? 'partial';

        return Treatment::create($data);
    }

    public function find($identifier): Treatment
    {
        if (is_numeric($identifier)) {
            return Treatment::findOrFail($identifier);
        }

        return Treatment::where('slug', $identifier)->firstOrFail();
    }

    public function update($identifier, array $data): Treatment
    {
        $treatment = $this->find($identifier);
        $data['description'] = $data['description'] ?? null;
        $data['coverage'] = $data['coverage'] ?? $treatment->coverage ?? 'partial';
        $treatment->update($data);
        return $treatment;
    }

    public function delete($identifier, string $reason): void
    {
        $treatment = $this->find($identifier);
        $treatment->update([
            'deleted_description' => $reason,
            'deleted_by' => auth()->id(),
        ]);
        $treatment->delete();
    }

    public function exportExcel(Request $request)
    {
        \App\Jobs\DentalManagement\Treatments\GenerateTreatmentsExcelJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }

    public function exportPdf(Request $request)
    {
        \App\Jobs\DentalManagement\Treatments\GenerateTreatmentsPdfJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }

    public function exportWord(Request $request)
    {
        \App\Jobs\DentalManagement\Treatments\GenerateTreatmentsWordJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }
}
