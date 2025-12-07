<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Odontogram extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'slug',
        'is_active',
        'created_by',
        'deleted_by',
        'deleted_description',
    ];

    protected static function booted()
    {
        static::creating(function ($odontogram) {
            do {
                $slug = Str::random(22);
            } while (Odontogram::where('slug', $slug)->exists());

            $odontogram->slug = $slug;
        });
    }

    public function getRouteKeyName()
    {
        return $this->slug ? 'slug' : 'id';
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

    public function histories()
    {
        return $this->hasMany(OdontogramHistory::class)->orderByDesc('date_procedure');
    }

    public function latestHistory()
    {
        return $this->hasOne(OdontogramHistory::class)->latestOfMany('date_procedure');
    }

    public function doctor()
    {
        return $this->hasOneThrough(
            Doctor::class,
            OdontogramHistory::class,
            'odontogram_id',
            'id',
            'id',
            'doctor_id'
        )->latestOfMany('odontogram_histories.date_procedure');
    }

    public function getStateHtmlAttribute()
    {
        return $this->is_active
            ? '<span class="badge badge-success">' . __('global.active') . '</span>'
            : '<span class="badge badge-danger">' . __('global.inactive') . '</span>';
    }

    public function getStateTextAttribute()
    {
        return $this->is_active
            ? __('global.active')
            : __('global.inactive');
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

        if ($filters->filled('doctor_id')) {
            $query->whereHas('histories', function (Builder $sub) use ($filters) {
                $sub->where('doctor_id', $filters->doctor_id);
            });
        }

        if ($filters->filled('description')) {
            $query->whereHas('histories', function (Builder $sub) use ($filters) {
                $sub->where('description', 'like', '%' . $filters->description . '%');
            });
        }

        $sort = $filters->get('sort', 'id');
        $direction = $filters->get('direction', 'asc');

        if (in_array($sort, ['id', 'patient_id']) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }

        return $query;
    }
}
