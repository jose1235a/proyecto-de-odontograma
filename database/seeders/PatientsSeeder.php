<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;

class PatientsSeeder extends Seeder
{
    public function run(): void
    {
        $patients = [
            [
                'document_type' => 'DNI',
                'document' => '12345678',
                'name' => 'Juan',
                'last_name' => 'Pérez García',
                'email' => 'juan.perez@gmail.com',
                'phone' => '+51987654321',
                'birth_date' => '1990-05-15',
                'address' => 'Av. Principal 123, Lima',
                'emergency_contact' => 'María Pérez',
                'medical_history' => 'Sin antecedentes relevantes',
                'under_medical_treatment' => 0,
                'prone_to_bleeding' => 0,
                'allergic_to_medication' => 0,
                'hypertensive' => 0,
                'diabetic' => 0,
                'pregnant' => 0,
                'consultation_reason' => 'Limpieza dental',
                'diagnosis' => 'Placa bacteriana',
                'observations' => 'Paciente cooperador',
                'referred_by' => null,
                'created_by' => 1,
                'is_active' => 1,
            ],
            [
                'document_type' => 'DNI',
                'document' => '87654321',
                'name' => 'María',
                'last_name' => 'López Rodríguez',
                'email' => 'maria.lopez@gmail.com',
                'phone' => '+51912345678',
                'birth_date' => '1985-08-22',
                'address' => 'Jr. Secundaria 456, Lima',
                'emergency_contact' => 'Carlos López',
                'medical_history' => 'Hipertensión controlada',
                'under_medical_treatment' => 1,
                'prone_to_bleeding' => 0,
                'allergic_to_medication' => 1,
                'hypertensive' => 1,
                'diabetic' => 0,
                'pregnant' => 0,
                'consultation_reason' => 'Dolor molar',
                'diagnosis' => 'Caries profunda',
                'observations' => 'Alérgica a penicilina',
                'referred_by' => 'Hospital Central',
                'created_by' => 1,
                'is_active' => 1,
            ],
            [
                'document_type' => 'DNI',
                'document' => '11223344',
                'name' => 'Carlos',
                'last_name' => 'Martínez Sánchez',
                'email' => 'carlos.martinez@gmail.com',
                'phone' => '+51956789012',
                'birth_date' => '1995-03-10',
                'address' => 'Psj. Los Pinos 789, Lima',
                'emergency_contact' => 'Ana Martínez',
                'medical_history' => 'Sin antecedentes',
                'under_medical_treatment' => 0,
                'prone_to_bleeding' => 0,
                'allergic_to_medication' => 0,
                'hypertensive' => 0,
                'diabetic' => 0,
                'pregnant' => 0,
                'consultation_reason' => 'Revisión general',
                'diagnosis' => 'Dientes sanos',
                'observations' => 'Control rutinario',
                'referred_by' => null,
                'created_by' => 1,
                'is_active' => 1,
            ],
        ];

        foreach ($patients as $data) {
            Patient::firstOrCreate(
                ['document' => $data['document']],
                $data
            );
        }
    }
}
