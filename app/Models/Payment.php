<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'appointment_id',
        'patient_id',
        'amount',
        'payment_date',
        'payment_method',
        'status',
        'reference_number',
        'notes',
        'created_by',
        'deleted_by',
        'deleted_description',
    ];

    protected $casts = [
        'amount' => 'float',
        'payment_date' => 'date',
    ];

    protected static function booted()
    {
        static::creating(function ($payment) {
            do {
                $slug = Str::random(22);
            } while (Payment::where('slug', $slug)->exists());

            $payment->slug = $slug;
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function getStatusHtmlAttribute()
    {
        return match ($this->status) {
            'pending' => '<span class="badge badge-warning">' . __('dental_management.payments.status.pending') . '</span>',
            'completed' => '<span class="badge badge-success">' . __('dental_management.payments.status.completed') . '</span>',
            'cancelled' => '<span class="badge badge-danger">' . __('dental_management.payments.status.cancelled') . '</span>',
            'refunded' => '<span class="badge badge-info">' . __('dental_management.payments.status.refunded') . '</span>',
            default => '<span class="badge badge-secondary">' . $this->status . '</span>',
        };
    }

    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            'pending' => __('dental_management.payments.status.pending'),
            'completed' => __('dental_management.payments.status.completed'),
            'cancelled' => __('dental_management.payments.status.cancelled'),
            'refunded' => __('dental_management.payments.status.refunded'),
            default => $this->status,
        };
    }

    public function getPaymentMethodHtmlAttribute()
    {
        return match ($this->payment_method) {
            'cash' => '<i class="fas fa-money-bill-wave text-success"></i> ' . __('dental_management.payments.methods.cash'),
            'card' => '<i class="fas fa-credit-card text-primary"></i> ' . __('dental_management.payments.methods.card'),
            'transfer' => '<i class="fas fa-university text-info"></i> ' . __('dental_management.payments.methods.transfer'),
            'check' => '<i class="fas fa-money-check text-warning"></i> ' . __('dental_management.payments.methods.check'),
            default => '<i class="fas fa-question-circle text-secondary"></i> ' . $this->payment_method,
        };
    }

    public function getAmountFormattedAttribute()
    {
        return 'S/ ' . number_format($this->amount ?? 0, 2);
    }

    public function scopeNotDeleted($query)
    {
        return $query->whereNull('deleted_at');
    }

    public function scopeFilter(Builder $query, Request|array $filters): Builder
    {
        if (is_array($filters)) {
            $filters = new Request($filters);
        }

        if ($filters->filled('patient_id')) {
            $query->where('patient_id', $filters->patient_id);
        }

        if ($filters->filled('appointment_id')) {
            $query->where('appointment_id', $filters->appointment_id);
        }

        if ($filters->filled('payment_method')) {
            $query->where('payment_method', $filters->payment_method);
        }

        if ($filters->filled('status')) {
            $query->where('status', $filters->status);
        }

        if ($filters->filled('payment_date')) {
            $query->whereDate('payment_date', $filters->payment_date);
        }

        if ($filters->filled('amount_min')) {
            $query->where('amount', '>=', $filters->amount_min);
        }

        if ($filters->filled('amount_max')) {
            $query->where('amount', '<=', $filters->amount_max);
        }

        $sort = $filters->get('sort', 'id');
        $direction = $filters->get('direction', 'desc');
        $direction = in_array($direction, ['asc', 'desc']) ? $direction : 'desc';

        switch ($sort) {
            case 'payment_date':
            case 'amount':
            case 'status':
            case 'payment_method':
            case 'reference_number':
            case 'created_at':
            case 'id':
                $query->orderBy($sort, $direction);
                break;
            case 'patient':
                $query->orderBy(
                    Patient::selectRaw("LOWER(CONCAT(name, ' ', COALESCE(last_name, '')))")
                        ->whereColumn('patients.id', 'payments.patient_id')
                        ->limit(1),
                    $direction
                );
                break;
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        return $query;
    }
}
