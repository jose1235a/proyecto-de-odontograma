<?php

namespace App\Traits;

trait Redirectable
{
    /**
     * Determina la ruta de redirección basada en el paciente y parámetros de retorno.
     */
    protected function determineRedirectRoute(?int $patientId, ?string $returnUrl): string
    {
        if ($returnUrl) {
            return $returnUrl;
        }

        if ($patientId) {
            $patient = \App\Models\Patient::find($patientId);
            return route('dental_management.patients.show', $patient ? $patient->slug : $patientId) . '?tab=odontograms';
        }

        return route('dental_management.odontogram.index');
    }
}