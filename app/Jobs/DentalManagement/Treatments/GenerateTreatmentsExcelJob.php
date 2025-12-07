<?php

namespace App\Jobs\DentalManagement\Treatments;

use App\Models\Download;
use App\Models\Treatment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DentalManagement\Treatments\TreatmentsExport;
use Maatwebsite\Excel\Excel as ExcelFormat;

class GenerateTreatmentsExcelJob implements ShouldQueue
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
        $this->locale  = app()->getLocale();
    }

    public function handle(): void
    {
        app()->setLocale($this->locale);

        $this->download = Download::create([
            'slug'       => Str::random(22),
            'user_id'    => $this->userId,
            'type'       => 'excel',
            'filename'   => $this->generateFilename(),
            'path'       => '',
            'disk'       => 'local',
            'status'     => 'processing',
            'expires_at' => now()->addDay(),
        ]);

        try {
            $treatments = Treatment::filter($this->filters)
                ->with('creator')
                ->get();

            $content = Excel::raw(new TreatmentsExport($treatments), ExcelFormat::XLSX);

            $path = 'downloads/' . $this->download->filename;
            Storage::disk($this->download->disk)->put($path, $content);

            $this->download->update([
                'path'   => $path,
                'status' => 'ready',
            ]);
        } catch (\Exception $e) {
            $this->download?->update([
                'status'        => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            \Log::error('GenerateTreatmentsExcelJob failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    protected function generateFilename(): string
    {
        return __('dental_management.treatments.export_filename') . '_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
    }
}
