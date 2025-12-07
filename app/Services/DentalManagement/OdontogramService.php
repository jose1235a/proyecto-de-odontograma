<?php

namespace App\Services\DentalManagement;

use App\Models\Odontogram;
use App\Models\OdontogramHistory;
use App\Helpers\OdontogramHelper;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class OdontogramService
{
    public function getPaginated(Request $request): LengthAwarePaginator
    {
        return Odontogram::query()
            ->with(['patient', 'latestHistory.doctor'])
            ->filter($request)
            ->notDeleted()
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    public function create(array $data): Odontogram
    {
        $payload = Arr::only($data, ['patient_id', 'is_active']);
        $payload['created_by'] = auth()->id();

        $odontogram = Odontogram::create($payload);

        if (!empty($data['doctor_id'])) {
            $this->storeHistory($odontogram, $data);
        }

        return $odontogram->fresh(['histories.details', 'latestHistory']);
    }

    public function find($id): Odontogram
    {
        return Odontogram::findOrFail($id);
    }

    public function update($id, array $data): Odontogram
    {
        $odontogram = $this->find($id);
        if (array_key_exists('is_active', $data)) {
            $odontogram->is_active = $data['is_active'];
            $odontogram->save();
        }

        if (!empty($data['doctor_id'])) {
            $this->storeHistory($odontogram, $data);
        }

        return $odontogram->fresh(['histories.details', 'latestHistory']);
    }

    public function delete($id, string $reason): void
    {
        $odontogram = $this->find($id);
        $odontogram->update([
            'deleted_description' => $reason,
            'deleted_by' => auth()->id(),
        ]);
        $odontogram->delete();
    }

    protected function storeHistory(Odontogram $odontogram, array $data): OdontogramHistory
    {
        $history = $odontogram->histories()->create([
            'doctor_id' => $data['doctor_id'],
            'description' => $this->sanitizeDescription($data['description'] ?? null),
            // Always store current app timezone when no procedure date is provided
            'date_procedure' => $data['date_procedure'] ?? now(config('app.timezone')),
            'created_by' => auth()->id(),
        ]);

        $details = $this->sanitizeAndNormalizeCanvasEntries(json_decode($data['odontogram_data'] ?? '[]', true));

        foreach ($details as $detail) {
            $history->details()->create([
                'treatment_id' => $this->extractTreatmentIdFromDetail($detail),
                'tooth_number_surfaces' => $detail,
            ]);
        }

        return $history;
    }

    public function buildHistorySnapshots(Collection $histories): array
    {
        $sorted = $histories
            ->sortBy(fn ($history) => optional($history->date_procedure ?? $history->created_at))
            ->values();

        $aggregate = [];
        $result = [];

        foreach ($sorted as $history) {
            $aggregate = $this->mergeCanvasEntries($aggregate, $history->canvas_data ?? []);
            $result[$history->id] = array_values($aggregate);
        }

        return $result;
    }

    public function resolveActiveHistory(Collection $histories, ?string $historyId): ?OdontogramHistory
    {
        if ($historyId) {
            return $histories->firstWhere('id', (int) $historyId);
        }

        return $histories
            ->sortByDesc(fn ($history) => $history->date_procedure ?? $history->created_at)
            ->first();
    }

    /**
     * Extrae el treatment_id de un detalle de odontograma.
     * Busca primero en la condición general, luego en las superficies.
     */
    protected function extractTreatmentIdFromDetail(array $detail): ?int
    {
        // 1) Condition general
        $treatmentId = OdontogramHelper::extractTreatmentId($detail['condition'] ?? null);
        if ($treatmentId) {
            return $treatmentId;
        }

        // 2) Condition en superficies (primera que encuentre)
        if (!empty($detail['surfaces']) && is_array($detail['surfaces'])) {
            foreach ($detail['surfaces'] as $surface) {
                $treatmentId = OdontogramHelper::extractTreatmentId($surface['condition'] ?? null);
                if ($treatmentId) {
                    return $treatmentId;
                }
            }
        }

        return null;
    }

    protected function mergeCanvasEntries(array $current, $items): array
    {
        foreach ($this->normalizeCanvasEntries($items) as $entry) {
            $key = $entry['tooth_number'] ?? md5(json_encode($entry));
            $current[$key] = $entry;
        }

        return $current;
    }

    protected function normalizeCanvasEntries($items): array
    {
        if (!is_array($items)) {
            return [];
        }

        return array_values(array_filter($items, 'is_array'));
    }

    public function formatHistoryData(?OdontogramHistory $history): array
    {
        if (!$history) {
            return [];
        }

        return $history->getAttribute('cumulative_canvas_data') ?? $history->canvas_data;
    }

    /**
     * Sanitiza la descripción del procedimiento.
     */
    protected function sanitizeDescription(?string $description): ?string
    {
        if (!$description) {
            return null;
        }

        // Limita la longitud y remueve caracteres peligrosos
        $sanitized = trim(strip_tags($description));
        return strlen($sanitized) > 1000 ? substr($sanitized, 0, 1000) : $sanitized;
    }

    /**
     * Sanitiza y normaliza las entradas del canvas.
     */
    protected function sanitizeAndNormalizeCanvasEntries($items): array
    {
        $normalized = $this->normalizeCanvasEntries($items);

        return array_map(function ($entry) {
            return $this->sanitizeCanvasEntry($entry);
        }, $normalized);
    }

    /**
     * Sanitiza una entrada individual del canvas.
     */
    protected function sanitizeCanvasEntry(array $entry): array
    {
        $sanitized = [];

        // Valida tooth_number (soporta piezas permanentes y temporales FDI)
        if (isset($entry['tooth_number']) && is_numeric($entry['tooth_number'])) {
            $toothNumber = (int) $entry['tooth_number'];
            if ($this->isValidToothNumber($toothNumber)) {
                $sanitized['tooth_number'] = $toothNumber;
            }
        }

        // Sanitiza condition
        if (isset($entry['condition'])) {
            $condition = trim(strip_tags($entry['condition']));
            if (strlen($condition) <= 100) {
                $sanitized['condition'] = $condition;
            }
        }

        if (isset($entry['color'])) {
            $color = $this->normalizeColorValue($entry['color']);
            if ($color) {
                $sanitized['color'] = $color;
            }
        }

        // Sanitiza surfaces
        if (isset($entry['surfaces']) && is_array($entry['surfaces'])) {
            $sanitized['surfaces'] = $this->sanitizeSurfaces($entry['surfaces']);
        }

        // Sanitiza notes
        if (isset($entry['notes'])) {
            $notes = trim(strip_tags($entry['notes']));
            if (strlen($notes) <= 500) {
                $sanitized['notes'] = $notes;
            }
        }

        return $sanitized;
    }

    /**
     * Sanitiza las superficies de un diente.
     */
    protected function sanitizeSurfaces(array $surfaces): array
    {
        $validSurfaces = ['top', 'right', 'bottom', 'left', 'center'];
        $legacyColors = ['danger', 'warning', 'info', 'none'];
        $validSymbols = ['cross', 'triangle', 'dot', 'ring', 'bar', 'none'];

        $normalized = [];

        foreach ($surfaces as $key => $surface) {
            if (!is_array($surface)) {
                continue;
            }

            $surfaceKey = is_string($key) ? $key : ($surface['surface'] ?? null);
            if (!$surfaceKey || !in_array($surfaceKey, $validSurfaces, true)) {
                continue;
            }

            $sanitized = [];

            if (isset($surface['condition'])) {
                $condition = trim(strip_tags($surface['condition']));
                if (strlen($condition) <= 100) {
                    $sanitized['condition'] = $condition;
                }
            }

            if (isset($surface['color'])) {
                $color = $this->normalizeColorValue($surface['color'], $legacyColors);
                if ($color) {
                    $sanitized['color'] = $color;
                }
            }

            if (isset($surface['symbol']) && in_array($surface['symbol'], $validSymbols, true)) {
                $sanitized['symbol'] = $surface['symbol'];
            }

            if (!empty($sanitized)) {
                $normalized[$surfaceKey] = $sanitized;
            }
        }

        return $normalized;
    }

    protected function normalizeColorValue(?string $color, array $legacyValues = []): ?string
    {
        if (!is_string($color)) {
            return null;
        }

        $color = trim($color);
        if ($color === '') {
            return null;
        }

        if (preg_match('/^#[0-9a-fA-F]{6}$/', $color)) {
            return strtolower($color);
        }

        if ($legacyValues && in_array($color, $legacyValues, true)) {
            return $color;
        }

        return null;
    }

    protected function isValidToothNumber(int $toothNumber): bool
    {
        $quadrant = (int) floor($toothNumber / 10);
        $position = $toothNumber % 10;

        if ($position < 1 || $position > 8) {
            return false;
        }

        if (in_array($quadrant, [1, 2, 3, 4], true)) {
            return $toothNumber >= 11 && $toothNumber <= 48;
        }

        if (in_array($quadrant, [5, 6, 7, 8], true)) {
            return $position <= 5;
        }

        return false;
    }
}
