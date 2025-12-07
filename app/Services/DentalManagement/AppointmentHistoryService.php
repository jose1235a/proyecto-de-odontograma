<?php

namespace App\Services\DentalManagement;

use App\Models\AppointmentHistory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class AppointmentHistoryService
{
    public function getPaginated(Request $request): LengthAwarePaginator
    {
        return AppointmentHistory::query()
            ->filter($request)
            ->notDeleted()
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    public function find($id): AppointmentHistory
    {
        return AppointmentHistory::findOrFail($id);
    }
}