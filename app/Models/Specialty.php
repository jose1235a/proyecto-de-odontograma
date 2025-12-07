<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;

class Specialty extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'created_by',
        'deleted_by',
        'deleted_description',
    ];

    protected static function booted()
    {
        static::creating(function ($specialty) {
            do {
                $slug = Str::random(22);
            } while (Specialty::where('slug', $slug)->exists());

            $specialty->slug = $slug;
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'doctor_specialty')->withTimestamps();
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

        if ($filters->filled('name')) {
            $query->where('name', 'like', '%' . $filters->name . '%');
        }

        if ($filters->filled('is_active')) {
            $query->where('is_active', $filters->is_active);
        }

        $sort = $filters->get('sort', 'id');
        $direction = $filters->get('direction', 'asc');

        if (in_array($sort, ['id', 'name', 'is_active']) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }

        return $query;
    }
}