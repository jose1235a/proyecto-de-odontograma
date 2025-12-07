<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class Consultation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'treatment_id',
        'doctor_id',
        'consultation_date',
        'consultation_time',
        'cost',
        'description',
        'consultation_reason',
        'diagnosis',
        'fever',
        'blood_pressure',
        'is_active',
        'created_by',
        'deleted_by',
        'deleted_description',
    ];

    protected $casts = [
        'consultation_date' => 'date',
        'consultation_time' => 'datetime:H:i',
        'cost' => 'float',
        'fever' => 'float',
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($consultation) {
            do {
                $slug = Str::random(22);
            } while (Consultation::where('slug', $slug)->exists());

            $consultation->slug = $slug;
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

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function getCostFormattedAttribute()
    {
        return 'S/ ' . number_format($this->cost ?? 0, 2);
    }

    public function getFeverFormattedAttribute()
    {
        return $this->fever ? $this->fever . '°C' : '-';
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

        if ($filters->filled('treatment_id')) {
            $query->where('treatment_id', $filters->treatment_id);
        }

        if ($filters->filled('doctor_id')) {
            $query->where('doctor_id', $filters->doctor_id);
        }

        if ($filters->filled('consultation_date')) {
            $query->whereDate('consultation_date', $filters->consultation_date);
        }

        if ($filters->filled('cost_min')) {
            $query->where('cost', '>=', $filters->cost_min);
        }

        if ($filters->filled('cost_max')) {
            $query->where('cost', '<=', $filters->cost_max);
        }

        $sort = $filters->get('sort', 'consultation_date');
        $direction = $filters->get('direction', 'desc');

        if (in_array($sort, ['consultation_date', 'cost', 'fever']) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }

        return $query;
    }
}