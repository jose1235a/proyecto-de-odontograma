<?php

namespace App\Services\DentalManagement;

use App\Models\Payment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class PaymentService
{
    public function getPaginated(Request $request): LengthAwarePaginator
    {
        $query = Payment::query()
            ->filter($request)
            ->notDeleted();

        if (!$request->filled('sort')) {
            $query->orderBy('id', 'desc');
        }

        return $query->paginate(10)->appends($request->all());
    }

    public function create(array $data): Payment
    {
        $data['created_by'] = auth()->id();
        return Payment::create($data);
    }

    public function find($id): Payment
    {
        return Payment::findOrFail($id);
    }

    public function update($id, array $data): Payment
    {
        $payment = $this->find($id);
        $payment->update($data);
        return $payment;
    }

    public function delete($id, string $reason): void
    {
        $payment = $this->find($id);
        $payment->update([
            'deleted_description' => $reason,
            'deleted_by' => auth()->id(),
        ]);
        $payment->delete();
    }

    public function exportExcel(Request $request)
    {
        \App\Jobs\DentalManagement\Payments\GeneratePaymentsExcelJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }

    public function exportPdf(Request $request)
    {
        \App\Jobs\DentalManagement\Payments\GeneratePaymentsPdfJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }

    public function exportWord(Request $request)
    {
        \App\Jobs\DentalManagement\Payments\GeneratePaymentsWordJob::dispatch(
            auth()->id(),
            $request->all()
        );

        return redirect()
            ->route('download_management.user_downloads.index')
            ->with('success', __('global.download_in_queue'));
    }

    public function updateInline(array $data): void
    {
        foreach ($data['payments'] ?? [] as $id => $paymentData) {
            $this->update($id, $paymentData);
        }
    }
}
