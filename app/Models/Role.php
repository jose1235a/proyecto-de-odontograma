<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use SoftDeletes;

    protected static function booted(): void
    {
        static::creating(function ($role) {
            do {
                $slug = Str::random(22);
            } while (static::where('slug', $slug)->exists());

            $role->slug = $slug;
        });
    }

    public function getRouteKeyName(): string
    {
        return 'id';
    }
}
