<?php

namespace App\Http\Controllers\DentalManagement;

use App\Http\Controllers\Controller;
use App\Models\TreatmentHistory;
use App\Models\OdontogramHistory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TreatmentHistoryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $treatmentHistory = TreatmentHistory::with(['doctor'])
            ->when($request->filled('odontogram_id'), fn ($query) => $query->where('odontogram_id', $request->odontogram_id))
            ->when($request->filled('patient_id'), fn ($query) => $query->where('patient_id', $request->patient_id))
            ->orderBy('treatment_date', 'desc')
            ->get()
            ->map(function (TreatmentHistory $history) {
                $registered = $history->treatment_date ?? $history->created_at;
                return [
                    'id' => $history->id,
                    'registered_at' => optional($registered)->toIso8601String(),
                    'description' => $history->notes,
                    'notes' => $history->notes,
                    'doctor' => $history->doctor ? [
                        'name' => $history->doctor->name,
                        'last_name' => $history->doctor->last_name,
                    ] : null,
                    'tooth_number' => $history->tooth_number,
                    'surface' => $history->surface,
                    'treatment_type' => $history->treatment_type,
                    'action' => $history->action,
                    'treatment_date' => optional($history->treatment_date)->toIso8601String(),
                ];
            });

        $historyRecords = OdontogramHistory::with(['doctor', 'odontogram'])
            ->when($request->filled('odontogram_id'), fn ($query) => $query->where('odontogram_id', $request->odontogram_id))
            ->when($request->filled('patient_id'), function ($query) use ($request) {
                $query->whereHas('odontogram', fn ($odontogramQuery) => $odontogramQuery->where('patient_id', $request->patient_id));
            })
            ->orderByDesc('date_procedure')
            ->get()
            ->map(function (OdontogramHistory $history) {
                $registered = $history->date_procedure ?? $history->created_at;
                return [
                    'id' => 'history-'.$history->id,
                    'registered_at' => optional($registered)->toIso8601String(),
                    'description' => $history->description,
                    'notes' => null,
                    'doctor' => $history->doctor ? [
                        'name' => $history->doctor->name,
                        'last_name' => $history->doctor->last_name,
                    ] : null,
                    'tooth_number' => null,
                    'surface' => null,
                    'treatment_type' => null,
                    'action' => null,
                    'treatment_date' => optional($registered)->toIso8601String(),
                ];
            });

        $history = $historyRecords->merge($treatmentHistory)
            ->sortByDesc('registered_at')
            ->values();

        return response()->json([
            'success' => true,
            'data' => $history,
        ]);
    }
}
