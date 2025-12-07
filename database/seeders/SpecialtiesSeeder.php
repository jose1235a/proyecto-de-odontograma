<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Specialty;

class SpecialtiesSeeder extends Seeder
{
    public function run(): void
    {
        $specialties = [
            [
                'name' => 'Odontología General',
                'description' => 'Tratamientos generales y preventivos de dientes',
                'is_active' => 1,
                'created_by' => 1,
            ],
            [
                'name' => 'Ortodoncia',
                'description' => 'Corrección de la alineación de dientes y mandíbula',
                'is_active' => 1,
                'created_by' => 1,
            ],
            [
                'name' => 'Endodoncia',
                'description' => 'Tratamientos de conductos radiculares',
                'is_active' => 1,
                'created_by' => 1,
            ],
            [
                'name' => 'Periodoncia',
                'description' => 'Tratamiento de enfermedades de las encías',
                'is_active' => 1,
                'created_by' => 1,
            ],
            [
                'name' => 'Implantología',
                'description' => 'Colocación e integración de implantes dentales',
                'is_active' => 1,
                'created_by' => 1,
            ],
        ];

        foreach ($specialties as $data) {
            Specialty::firstOrCreate(
                ['name' => $data['name']],
                $data
            );
        }
    }
}
