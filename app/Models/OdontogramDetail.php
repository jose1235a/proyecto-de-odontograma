<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OdontogramDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'odontogram_history_id',
        'treatment_id',
        'tooth_number_surfaces',
    ];

    protected $casts = [
        'tooth_number_surfaces' => 'array',
    ];

    public function history()
    {
        return $this->belongsTo(OdontogramHistory::class, 'odontogram_history_id');
    }

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }

    public function toCanvasData(): array
    {
        $data = $this->tooth_number_surfaces ?? [];

        if ($this->treatment_id && empty($data['condition'])) {
            $data['condition'] = 'treatment_' . $this->treatment_id;
        }

        return $data;
    }
}
