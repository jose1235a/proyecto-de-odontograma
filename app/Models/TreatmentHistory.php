<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TreatmentHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'treatment_history';

    protected $fillable = [
        'odontogram_id',
        'patient_id',
        'doctor_id',
        'tooth_number',
        'surface',
        'treatment_type',
        'action',
        'treatment_data',
        'treatment_date',
        'notes',
    ];

    protected $casts = [
        'treatment_data' => 'json',
        'treatment_date' => 'datetime',
    ];

    public function odontogram()
    {
        return $this->belongsTo(Odontogram::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function scopeFilter($query, $filters)
    {
        if (!empty($filters['odontogram_id'])) {
            $query->where('odontogram_id', $filters['odontogram_id']);
        }

        if (!empty($filters['patient_id'])) {
            $query->where('patient_id', $filters['patient_id']);
        }

        if (!empty($filters['doctor_id'])) {
            $query->where('doctor_id', $filters['doctor_id']);
        }

        if (!empty($filters['tooth_number'])) {
            $query->where('tooth_number', $filters['tooth_number']);
        }

        if (!empty($filters['surface'])) {
            $query->where('surface', $filters['surface']);
        }

        if (!empty($filters['treatment_type'])) {
            $query->where('treatment_type', $filters['treatment_type']);
        }

        if (!empty($filters['action'])) {
            $query->where('action', $filters['action']);
        }

        if (!empty($filters['date_from'])) {
            $query->where('treatment_date', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('treatment_date', '<=', $filters['date_to']);
        }

        return $query;
    }
}