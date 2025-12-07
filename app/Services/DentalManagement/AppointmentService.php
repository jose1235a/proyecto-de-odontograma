<?php

namespace App\Services\DentalManagement;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Treatment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentService
{
    public function getPaginated(Request $request): LengthAwarePaginator
    {
        $query = Appointment::query()
            ->with(['patient', 'doctor', 'treatment'])
            ->filter($request)
            ->notDeleted();

        if (!$request->filled('sort')) {
            $query->orderBy('appointment_date', 'desc')
                ->orderBy('appointment_time', 'desc');
        }

        return $query->paginate(10)->appends($request->all());
    }

    public function create(array $data): Appointment
    {
        $data['created_by'] = auth()->id();
        $data['cost'] = $data['cost'] ?? $this->resolveTreatmentCost($data['treatment_id'] ?? null);
        $data['paid'] = $data['paid'] ?? 0;

        return Appointment::create($data);
    }

    public function find($identifier): Appointment
    {
        if (is_numeric($identifier)) {
            return Appointment::with(['patient', 'doctor', 'treatment'])->findOrFail($identifier);
        }

        return Appointment::with(['patient', 'doctor', 'treatment'])
            ->where('slug', $identifier)
            ->firstOrFail();
    }

    public function update($identifier, array $data): Appointment
    {
        $appointment = $this->find($identifier);
        $data['cost'] = $data['cost'] ?? $this->resolveTreatmentCost($data['treatment_id'] ?? $appointment->treatment_id);
        $data['paid'] = $data['paid'] ?? 0;

        $appointment->update($data);

        return $appointment;
    }

    public function delete($identifier, string $reason): void
    {
        $appointment = $this->find($identifier);
        $appointment->update([
            'deleted_description' => $reason,
            'deleted_by' => auth()->id(),
        ]);
        $appointment->delete();
    }

    public function getDoctors()
    {
        return Doctor::orderBy('name')->get();
    }

    public function getTreatments()
    {
        return Treatment::orderBy('name')->get();
    }

    public function getPatients()
    {
        return \App\Models\Patient::orderBy('name')->get();
    }

    public function exportExcel(Request $request)
    {
        \App\Jobs\DentalManagement\Appointments\GenerateAppointmentsExcelJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }

    public function exportPdf(Request $request)
    {
        \App\Jobs\DentalManagement\Appointments\GenerateAppointmentsPdfJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }

    public function exportWord(Request $request)
    {
        \App\Jobs\DentalManagement\Appointments\GenerateAppointmentsWordJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }

    public function updateExpiredAppointments(): int
    {
        $now = now();
        $updated = 0;

        DB::transaction(function () use ($now, &$updated) {
            // Citas pendientes que ya pasaron su fecha/hora
            $expiredAppointments = Appointment::where('status', 'pending')
                ->where(function ($query) use ($now) {
                    $query->where('appointment_date', '<', $now->toDateString())
                          ->orWhere(function ($q) use ($now) {
                              $q->where('appointment_date', $now->toDateString())
                                ->where('appointment_time', '<=', $now->toTimeString());
                          });
                })
                ->lockForUpdate() // Prevenir race conditions
                ->get();

            foreach ($expiredAppointments as $appointment) {
                $appointment->update([
                    'status' => 'cancelled',
                    'notes' => ($appointment->notes ? $appointment->notes . ' | ' : '') .
                              'Cancelado automáticamente por expiración - ' . $now->format('d/m/Y H:i')
                ]);

                $updated++;
            }
        });

        return $updated;
    }

    protected function resolveTreatmentCost(?int $treatmentId): float
    {
        if (!$treatmentId) {
            return 0;
        }

        return (float) (Treatment::find($treatmentId)?->cost ?? 0);
    }
}
