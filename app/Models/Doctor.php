<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;
use App\Models\Specialty;

class Doctor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'document_type',
        'document',
        'name',
        'last_name',
        'email',
        'phone',
        'address',
        'is_active',
        'user_id',
        'created_by',
        'deleted_by',
        'deleted_description',
    ];

    protected static function booted()
    {
        static::creating(function ($doctor) {
            do {
                $slug = Str::random(22);
            } while (Doctor::where('slug', $slug)->exists());

            $doctor->slug = $slug;
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function specialties()
    {
        return $this->belongsToMany(Specialty::class, 'doctor_specialty')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
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

    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->last_name;
    }

    public function scopeNotDeleted($query)
    {
        return $query->whereNull('deleted_at');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFilter(Builder $query, Request|array $filters): Builder
    {
        if (is_array($filters)) {
            $filters = new Request($filters);
        }

        if ($filters->filled('name')) {
            $query->where('name', 'like', '%' . $filters->name . '%');
        }

        if ($filters->filled('last_name')) {
            $query->where('last_name', 'like', '%' . $filters->last_name . '%');
        }

        if ($filters->filled('email')) {
            $query->where('email', 'like', '%' . $filters->email . '%');
        }

        if ($filters->filled('document')) {
            $query->where('document', 'like', '%' . $filters->document . '%');
        }

        if ($filters->filled('specialty_id')) {
            $query->whereHas('specialties', function ($q) use ($filters) {
                $q->where('specialty_id', $filters->specialty_id);
            });
        }

        $sort = $filters->get('sort', 'id');
        $direction = $filters->get('direction', 'asc');
        $direction = in_array($direction, ['asc', 'desc']) ? $direction : 'asc';

        switch ($sort) {
            case 'document':
            case 'email':
            case 'phone':
            case 'address':
                $query->orderBy($sort, $direction);
                break;
            case 'status':
            case 'is_active':
                $query->orderBy('is_active', $direction);
                break;
            case 'name':
                $query->orderBy('name', $direction)->orderBy('last_name', $direction);
                break;
            case 'specialty':
                $query->orderBy(
                    Specialty::select('name')
                        ->join('doctor_specialty', 'specialties.id', '=', 'doctor_specialty.specialty_id')
                        ->whereColumn('doctor_specialty.doctor_id', 'doctors.id')
                        ->orderBy('specialties.name')
                        ->limit(1),
                    $direction
                );
                break;
            default:
                $query->orderBy('id', $direction);
                break;
        }

        return $query;
    }
}
