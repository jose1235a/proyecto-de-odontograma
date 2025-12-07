<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'treatment_id',
        'appointment_date',
        'appointment_time',
        'duration',
        'status',
        'disease',
        'cost',
        'paid',
        'notes',
        'created_by',
        'deleted_by',
        'deleted_description',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i',
        'duration' => 'integer',
        'cost' => 'decimal:2',
        'paid' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::creating(function ($appointment) {
            do {
                $slug = Str::random(22);
            } while (Appointment::where('slug', $slug)->exists());

            $appointment->slug = $slug;
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
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
            'scheduled' => '<span class="badge badge-info">' . __('dental_management.appointments.status_assigned') . '</span>',
            'completed' => '<span class="badge badge-success">' . __('dental_management.appointments.status_attended') . '</span>',
            'cancelled' => '<span class="badge badge-danger">' . __('dental_management.appointments.status_cancelled') . '</span>',
            default => '<span class="badge badge-secondary">' . $this->status . '</span>',
        };
    }

    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            'scheduled' => __('dental_management.appointments.status_assigned'),
            'completed' => __('dental_management.appointments.status_attended'),
            'cancelled' => __('dental_management.appointments.status_cancelled'),
            default => $this->status,
        };
    }

    public function getAppointmentDateTimeAttribute()
    {
        return $this->appointment_date->format('d/m/Y') . ' ' . $this->appointment_time->format('H:i');
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

        if ($filters->filled('patient')) {
            $query->whereHas('patient', function ($q) use ($filters) {
                $term = '%' . $filters->patient . '%';
                $q->where(function ($sub) use ($term) {
                    $sub->where('name', 'like', $term)
                        ->orWhere('last_name', 'like', $term)
                        ->orWhere('document', 'like', $term);
                });
            });
        }

        if ($filters->filled('patient_id')) {
            $query->where('patient_id', $filters->patient_id);
        }

        if ($filters->filled('doctor_id')) {
            $query->where('doctor_id', $filters->doctor_id);
        }

        if ($filters->filled('treatment_id')) {
            $query->where('treatment_id', $filters->treatment_id);
        }

        if ($filters->filled('status')) {
            $query->where('status', $filters->status);
        }

        $sort = $filters->get('sort', 'appointment_date');
        $direction = $filters->get('direction', 'desc');
        $direction = in_array($direction, ['asc', 'desc']) ? $direction : 'desc';

        switch ($sort) {
            case 'appointment_date':
            case 'appointment_time':
            case 'status':
                $query->orderBy($sort, $direction);
                break;
            case 'patient':
                $query->orderBy(
                    Patient::selectRaw("LOWER(CONCAT(name, ' ', COALESCE(last_name, '')))")
                        ->whereColumn('patients.id', 'appointments.patient_id')
                        ->limit(1),
                    $direction
                );
                break;
            case 'doctor':
                $query->orderBy(
                    Doctor::selectRaw("LOWER(CONCAT(name, ' ', COALESCE(last_name, '')))")
                        ->whereColumn('doctors.id', 'appointments.doctor_id')
                        ->limit(1),
                    $direction
                );
                break;
            case 'treatment':
                $query->orderBy(
                    Treatment::select('name')
                        ->whereColumn('treatments.id', 'appointments.treatment_id')
                        ->limit(1),
                    $direction
                );
                break;
            default:
                $query->orderBy('appointment_date', 'desc')->orderBy('appointment_time', 'desc');
                break;
        }

        return $query;
    }
}
