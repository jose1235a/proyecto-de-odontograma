<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class PatientImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'title',
        'filename',
        'description',
        'created_by',
        'deleted_by',
        'deleted_description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($patientImage) {
            do {
                $slug = Str::random(22);
            } while (PatientImage::where('slug', $slug)->exists());

            $patientImage->slug = $slug;
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

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function getImageUrlAttribute()
    {
        if (!$this->filename) {
            return $this->getPlaceholderImage();
        }

        $possiblePaths = [
            storage_path('app/public/patient_images/' . $this->filename),
            public_path('storage/patient_images/' . $this->filename),
        ];

        foreach ($possiblePaths as $imagePath) {
            if ($imagePath && file_exists($imagePath)) {
                $imageData = file_get_contents($imagePath);
                $mimeType = mime_content_type($imagePath) ?: 'image/jpeg';
                $base64 = base64_encode($imageData);
                return 'data:' . $mimeType . ';base64,' . $base64;
            }
        }

        return $this->getPlaceholderImage();
    }

    protected function getPlaceholderImage(): string
    {
        return 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDIwMCAyMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxjaXJjbGUgY3g9IjEwMCIgY3k9IjEwMCIgcj0iMTAwIiBmaWxsPSIjRDBEMEQwIi8+Cjx0ZXh0IHg9IjEwMCIgeT0iMTE1IiBmb250LWZhbWlseT0iQXJpYWwsIHNhbnMtc2VyaWYiIGZvbnQtc2l6ZT0iMTIiIGZpbGw9IiMwMDAiIHRleHQtYW5jaG9yPSJtaWRkbGUiPk5vIEltYWdlPC90ZXh0Pgo8L3N2Zz4=';
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

        if ($filters->filled('title')) {
            $query->where('title', 'like', '%' . $filters->title . '%');
        }

        if ($filters->filled('is_active')) {
            $query->where('is_active', (int) $filters->is_active);
        }

        $sort = $filters->get('sort', 'created_at');
        $direction = $filters->get('direction', 'desc');

        if (in_array($sort, ['created_at', 'title', 'is_active']) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }

        return $query;
    }
}
