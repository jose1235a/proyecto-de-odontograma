<?php

namespace App\Rules\DentalManagement;

use Illuminate\Contracts\Validation\Rule;

class ValidOdontogramData implements Rule
{
    private const LEGACY_COLORS = ['danger', 'warning', 'info', 'none'];
    private const VALID_SYMBOLS = ['cross', 'triangle', 'dot', 'ring', 'bar', 'none'];
    private const VALID_SURFACES = ['top', 'right', 'bottom', 'left', 'center'];
    private const MAX_ENTRIES = 32; // Maximum number of tooth entries
    private const MAX_SURFACES_PER_TOOTH = 5; // Maximum surfaces per tooth

    public function passes($attribute, $value): bool
    {
        $decoded = json_decode($value, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
            return false;
        }

        // Check maximum number of entries
        if (count($decoded) > self::MAX_ENTRIES) {
            return false;
        }

        foreach ($decoded as $entry) {
            if (!is_array($entry)) {
                return false;
            }

            // Validate tooth_number
            if (!array_key_exists('tooth_number', $entry) || !is_numeric($entry['tooth_number'])) {
                return false;
            }

            $toothNumber = (int) $entry['tooth_number'];
            if (!$this->isValidToothNumber($toothNumber)) {
                return false;
            }

            // Validate condition
            if (isset($entry['condition']) && !is_string($entry['condition'])) {
                return false;
            }

            // Validate surfaces
            if (isset($entry['surfaces'])) {
                if (!is_array($entry['surfaces'])) {
                    return false;
                }

                // Check maximum surfaces per tooth
                if (!$this->validateSurfaces($entry['surfaces'])) {
                    return false;
                }
            }
        }

        return true;
    }

    public function message(): string
    {
        return __('dental_management.odontogram.validation.odontogram_data_invalid');
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

    protected function validateSurfaces(array $surfaces): bool
    {
        $validCount = 0;

        foreach ($surfaces as $key => $surface) {
            if (!is_array($surface)) {
                return false;
            }

            $surfaceKey = is_string($key) ? $key : ($surface['surface'] ?? null);
            if (!is_string($surfaceKey) || !in_array($surfaceKey, self::VALID_SURFACES, true)) {
                return false;
            }

            if (isset($surface['condition']) && !is_string($surface['condition'])) {
                return false;
            }

            if (isset($surface['color']) && !$this->isValidColor($surface['color'])) {
                return false;
            }

            if (isset($surface['symbol']) && !in_array($surface['symbol'], self::VALID_SYMBOLS, true)) {
                return false;
            }

            $validCount++;
        }

        return $validCount <= self::MAX_SURFACES_PER_TOOTH;
    }
    protected function isValidColor(string $color): bool
    {
        if (in_array($color, self::LEGACY_COLORS, true)) {
            return true;
        }

        return (bool) preg_match('/^#[0-9a-fA-F]{6}$/', $color);
    }
}
