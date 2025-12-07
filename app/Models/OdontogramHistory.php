<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OdontogramHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'odontogram_id',
        'doctor_id',
        'created_by',
        'date_procedure',
        'description',
    ];

    protected $casts = [
        'date_procedure' => 'datetime',
    ];

    protected static function booted()
    {
        static::created(function ($odontogramHistory) {
            \App\Events\OdontogramHistoryCreated::dispatch($odontogramHistory);
        });
    }

    public function odontogram()
    {
        return $this->belongsTo(Odontogram::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function details()
    {
        return $this->hasMany(OdontogramDetail::class);
    }

    public function getCanvasDataAttribute(): array
    {
        return $this->details->map(fn ($detail) => $detail->toCanvasData())->values()->all();
    }
}
