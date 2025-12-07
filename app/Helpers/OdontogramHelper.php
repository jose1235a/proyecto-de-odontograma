<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class OdontogramHelper
{
    /**
     * Extrae el ID del tratamiento de una condición de odontograma.
     */
    public static function extractTreatmentId(?string $condition): ?int
    {
        if (!is_string($condition)) {
            return null;
        }

        if (Str::startsWith($condition, 'treatment_')) {
            return (int) Str::after($condition, 'treatment_');
        }

        return null;
    }
}