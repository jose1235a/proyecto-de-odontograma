<?php

namespace App\Jobs\DentalManagement\Patients;

use App\Models\Download;
use App\Models\Patient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Exports\DentalManagement\Patients\PatientsWord;

class GeneratePatientsWordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $userId;
    protected array $filters;
    protected string $locale;
    protected ?Download $download = null;

    public function __construct(int $userId, array $filters = [])
    {
        $this->userId  = $userId;
        $this->filters = $filters;
        $this->locale  = app()->getLocale(); // Capture locale at dispatch time
    }

    public function handle(): void
    {
        // Force translations with the locale captured at dispatch time
        app()->setLocale($this->locale);

        // Create download record
        $this->download = Download::create([
            'slug'       => Str::random(22),
            'user_id'    => $this->userId,
            'type'       => 'word',
            'filename'   => $this->generateFilename(),
            'path'       => '',
            'disk'       => 'local',
            'status'     => 'processing',
            'expires_at' => now()->addDay(),
        ]);

        try {
            // Get filtered data
            $patients = Patient::filter($this->filters)
                ->with('creator')
                ->get();

            // Generate Word file into temp
            $tempFile = tempnam(sys_get_temp_dir(), 'patients_export') . '.docx';
            $wordExport = new PatientsWord();
            $wordExport->generate($patients, $tempFile);

            // Read content and save to storage
            $content = file_get_contents($tempFile);
            $path = 'downloads/' . $this->download->filename;
            Storage::disk($this->download->disk)->put($path, $content);

            // Clean up temp file
            unlink($tempFile);

            // Update record
            $this->download->update([
                'path'   => $path,
                'status' => 'ready',
            ]);

        } catch (\Exception $e) {
            $this->download->update([
                'status'        => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            \Log::error('GeneratePatientsWordJob failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    protected function generateFilename(): string
    {
        return __('dental_management.patients.export_filename') . '_' . now()->format('Y-m-d_H-i-s') . '.docx';
    }
}