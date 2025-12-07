<?php

namespace App\Http\Controllers\DentalManagement;

use App\Http\Controllers\Controller;
use App\Models\OdontogramHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OdontogramHistoryController extends Controller
{
    public function update(Request $request, OdontogramHistory $odontogramHistory): JsonResponse
    {
        $validated = $request->validate([
            'doctor_id' => ['nullable', 'exists:doctors,id'],
            'description' => ['required', 'string', 'max:1000'],
        ]);

        $odontogramHistory->update([
            'doctor_id' => $validated['doctor_id'] ?? null,
            'description' => $validated['description'],
        ]);

        $odontogramHistory->load('doctor');
        $doctorName = trim(($odontogramHistory->doctor->name ?? '') . ' ' . ($odontogramHistory->doctor->last_name ?? '')) ?: '-';

        return response()->json([
            'success' => true,
            'message' => __('dental_management.odontogram.history_updated'),
            'data' => [
                'id' => $odontogramHistory->id,
                'description' => $odontogramHistory->description,
                'description_short' => Str::limit($odontogramHistory->description, 40),
                'doctor' => $odontogramHistory->doctor ? [
                    'id' => $odontogramHistory->doctor->id,
                    'name' => $odontogramHistory->doctor->name,
                    'last_name' => $odontogramHistory->doctor->last_name,
                ] : null,
                'doctor_name' => $doctorName,
            ],
        ]);
    }

    public function destroy(Request $request, OdontogramHistory $odontogramHistory)
    {
        $odontogramHistory->details()->delete();
        $odontogramHistory->delete();

        // If the request expects JSON (AJAX), return payload, otherwise redirect back.
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('dental_management.odontogram.history_deleted'),
                'data' => ['id' => $odontogramHistory->id],
            ]);
        }

        return back()->with('status', __('dental_management.odontogram.history_deleted'));
    }
}
