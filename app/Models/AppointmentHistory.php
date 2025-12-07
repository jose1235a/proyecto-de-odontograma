<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class AppointmentHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'appointment_id',
        'action',
        'old_status',
        'new_status',
        'notes',
        'changed_by',
        'created_by',
        'deleted_by',
        'deleted_description',
    ];

    protected static function booted()
    {
        static::creating(function ($appointmentHistory) {
            do {
                $slug = Str::random(22);
            } while (AppointmentHistory::where('slug', $slug)->exists());

            $appointmentHistory->slug = $slug;
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

    public function changer()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function getActionHtmlAttribute()
    {
        return match ($this->action) {
            'created' => '<span class="badge badge-success">' . __('dental_management.appointment_history.action_created') . '</span>',
            'updated' => '<span class="badge badge-info">' . __('dental_management.appointment_history.action_updated') . '</span>',
            'status_changed' => '<span class="badge badge-warning">' . __('dental_management.appointment_history.action_status_changed') . '</span>',
            'cancelled' => '<span class="badge badge-danger">' . __('dental_management.appointment_history.action_cancelled') . '</span>',
            default => '<span class="badge badge-secondary">' . $this->action . '</span>',
        };
    }

    public function getActionTextAttribute()
    {
        return match ($this->action) {
            'created' => __('dental_management.appointment_history.action_created'),
            'updated' => __('dental_management.appointment_history.action_updated'),
            'status_changed' => __('dental_management.appointment_history.action_status_changed'),
            'cancelled' => __('dental_management.appointment_history.action_cancelled'),
            default => $this->action,
        };
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

        if ($filters->filled('appointment_id')) {
            $query->where('appointment_id', $filters->appointment_id);
        }

        if ($filters->filled('action')) {
            $query->where('action', $filters->action);
        }

        if ($filters->filled('changed_by')) {
            $query->where('changed_by', $filters->changed_by);
        }

        $sort = $filters->get('sort', 'created_at');
        $direction = $filters->get('direction', 'desc');

        if (in_array($sort, ['created_at', 'action', 'appointment_id', 'changed_by']) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        }

        return $query;
    }
}