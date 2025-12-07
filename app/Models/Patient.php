<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;
use App\Models\Consultation;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'document_type',
        'document',
        'name',
        'last_name',
        'gender',
        'email',
        'phone',
        'birth_date',
        'address',
        'emergency_contact',
        'medical_history',
        'under_medical_treatment',
        'under_medical_treatment_description',
        'prone_to_bleeding',
        'prone_to_bleeding_description',
        'allergic_to_medication',
        'allergic_to_medication_description',
        'hypertensive',
        'hypertensive_description',
        'diabetic',
        'diabetic_description',
        'pregnant',
        'pregnant_description',
        'observations',
        'created_by',
        'deleted_by',
        'deleted_description',
    ];

    protected $attributes = [
        'under_medical_treatment' => 0,
        'prone_to_bleeding' => 0,
        'allergic_to_medication' => 0,
        'hypertensive' => 0,
        'diabetic' => 0,
        'pregnant' => 0,
    ];

    protected $casts = [
        'under_medical_treatment' => 'integer',
        'prone_to_bleeding' => 'integer',
        'allergic_to_medication' => 'integer',
        'hypertensive' => 'integer',
        'diabetic' => 'integer',
        'pregnant' => 'integer',
        'gender' => 'string',
        'birth_date' => 'date',
    ];

    protected static function booted()
    {
        static::creating(function ($patient) {
            do {
                $slug = Str::random(22);
            } while (Patient::where('slug', $slug)->exists());

            $patient->slug = $slug;
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

    public function appointments()
    {
        return $this->hasMany(Appointment::class)->whereNull('deleted_at');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function odontograms()
    {
        return $this->hasMany(Odontogram::class)->whereNull('deleted_at');
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class)->whereNull('deleted_at');
    }

    public function patientImages()
    {
        return $this->hasMany(PatientImage::class);
    }

    public function getTotalDebtAttribute()
    {
        $totalCost = $this->appointments()->sum('cost');
        $totalPaid = $this->payments()->where('status', 'completed')->sum('amount');
        return max(0, $totalCost - $totalPaid);
    }

    public function getTotalDebtFormattedAttribute()
    {
        return 'S/ ' . number_format($this->total_debt, 2);
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

    public function getAgeAttribute()
    {
        return $this->birth_date ? $this->birth_date->age : null;
    }

    public function getAllergyAttribute()
    {
        return $this->allergic_to_medication ? $this->allergic_to_medication_description : '-';
    }

    public function scopeNotDeleted($query)
    {
        return $query->whereNull('deleted_at');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessor: return full URL for patient photo
    public function getPhotoUrlAttribute()
    {
        $photoPath = public_path('storage/patient_photos/' . $this->id . '.jpg');

        if (file_exists($photoPath)) {
            // Return data URL for the image
            $imageData = file_get_contents($photoPath);
            $base64 = base64_encode($imageData);
            return 'data:image/jpeg;base64,' . $base64;
        }

        // Default patient photo - return data URL
        $defaultPath = public_path('adminlte/img/user2-160x160.jpg');
        if (file_exists($defaultPath)) {
            $imageData = file_get_contents($defaultPath);
            $base64 = base64_encode($imageData);
            return 'data:image/jpeg;base64,' . $base64;
        }

        // Fallback to a simple placeholder
        return 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxjaXJjbGUgY3g9IjUwIiBjeT0iNTAiIHI9IjUwIiBmaWxsPSIjRDBEMEQwIi8+Cjx0ZXh0IHg9IjUwIiB5PSI1NSIgZm9udC1mYW1pbHk9IkFyaWFsLCBzYW5zLXNlcmlmIiBmb250LXNpemU9IjEyIiBmaWxsPSIjMDAwIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj5ObyBJbWFnZTwvdGV4dD4KPHN2Zz4=';
    }

    public function scopeFilter(Builder $query, Request|array $filters): Builder
    {
        if (is_array($filters)) {
            $filters = new Request($filters);
        }

        if ($filters->filled('name')) {
            $query->where('name', 'like', '%' . $filters->name . '%');
        }

        if ($filters->filled('email')) {
            $query->where('email', 'like', '%' . $filters->email . '%');
        }

        if ($filters->filled('document')) {
            $query->where('document', 'like', '%' . $filters->document . '%');
        }

        if ($filters->filled('is_active')) {
            $query->where('is_active', (int) $filters->is_active);
        }

        $sort = $filters->get('sort', 'id');
        $direction = $filters->get('direction', 'asc');
        $direction = in_array($direction, ['asc', 'desc']) ? $direction : 'asc';

        switch ($sort) {
            case 'document':
            case 'name':
            case 'email':
            case 'phone':
                $query->orderBy($sort, $direction);
                break;
            case 'age':
                // Younger first when ascending age
                $query->orderBy('birth_date', $direction === 'asc' ? 'desc' : 'asc');
                break;
            case 'allergy':
                $query->orderBy('allergic_to_medication_description', $direction);
                break;
            case 'status':
            case 'is_active':
                $query->orderBy('is_active', $direction);
                break;
            default:
                $query->orderBy('id', $direction);
                break;
        }

        return $query;
    }
}
