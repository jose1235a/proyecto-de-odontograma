<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Patient;
use App\Models\Odontogram;
use App\Models\Doctor;
use App\Models\User;

class CreateDefaultOdontogramsForPatients extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'odontograms:create-default {--user=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create default odontograms for existing patients who don\'t have one';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to create default odontograms for existing patients...');

        $userIdOption = $this->option('user');
        $createdBy = $userIdOption ? (int) $userIdOption : User::query()->orderBy('id')->value('id');

        if (!$createdBy || !User::find($createdBy)) {
            $this->error('A valid user id is required. Provide one via --user option.');
            return;
        }

        // Get patients who don't have any odontograms
        $patientsWithoutOdontograms = Patient::whereDoesntHave('odontograms')->get();

        if ($patientsWithoutOdontograms->isEmpty()) {
            $this->info('All patients already have at least one odontogram.');
            return;
        }

        // Get the first doctor as default
        $defaultDoctor = Doctor::first();
        if (!$defaultDoctor) {
            $this->error('No doctors found. Please create at least one doctor first.');
            return;
        }

        $createdCount = 0;
        foreach ($patientsWithoutOdontograms as $patient) {
            $odontogram = Odontogram::create([
                'patient_id' => $patient->id,
                'is_active' => true,
                'created_by' => $createdBy,
            ]);

            $odontogram->histories()->create([
                'doctor_id' => $defaultDoctor->id,
                'description' => 'Default odontogram created for existing patients',
                'date_procedure' => now(),
                'created_by' => $createdBy,
            ]);

            $createdCount++;
        }

        $this->info("Created {$createdCount} default odontograms for existing patients.");
    }
}
