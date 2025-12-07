<?php

namespace App\Services\DentalManagement;

use App\Models\Consultation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class ConsultationService
{
    public function getPaginated(Request $request): LengthAwarePaginator
    {
        return Consultation::query()
            ->with(['patient', 'treatment', 'doctor'])
            ->filter($request)
            ->notDeleted()
            ->orderBy('consultation_date', 'desc')
            ->orderBy('consultation_time', 'desc')
            ->paginate(15);
    }

    public function create(array $data): Consultation
    {
        // Get cost from selected treatment
        if (isset($data['treatment_id'])) {
            $treatment = \App\Models\Treatment::find($data['treatment_id']);
            if ($treatment) {
                $data['cost'] = $treatment->cost;
            }
        }

        $data['created_by'] = auth()->id();
        return Consultation::create($data);
    }

    public function find($id): Consultation
    {
        return Consultation::findOrFail($id);
    }

    public function update($id, array $data): Consultation
    {
        // Get cost from selected treatment if treatment_id is being updated
        if (isset($data['treatment_id'])) {
            $treatment = \App\Models\Treatment::find($data['treatment_id']);
            if ($treatment) {
                $data['cost'] = $treatment->cost;
            }
        }

        $consultation = $this->find($id);
        $consultation->update($data);
        return $consultation;
    }

    public function delete($id, string $reason): void
    {
        $consultation = $this->find($id);
        $consultation->update([
            'deleted_description' => $reason,
            'deleted_by' => auth()->id(),
        ]);
        $consultation->delete();
    }

    public function getAllTreatments()
    {
        return \App\Models\Treatment::all();
    }

    public function getAllDoctors()
    {
        return \App\Models\Doctor::all();
    }
}