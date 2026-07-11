<?php

namespace App\Services;

class CalorieCalculatorService
{
    public const ACTIVITY_FACTORS = [
        'hampir_tidak_pernah_berolahraga' => 1.2,
        'jarang_berolahraga' => 1.3,
        'sering_berolahraga_atau_aktivitas_fisik_berat' => 1.4,
    ];

    public const ACTIVITY_LABELS = [
        'hampir_tidak_pernah_berolahraga' => 'Hampir tidak pernah berolahraga',
        'jarang_berolahraga' => 'Jarang berolahraga',
        'sering_berolahraga_atau_aktivitas_fisik_berat' => 'Sering berolahraga atau aktivitas fisik berat',
    ];

    public function calculateBmr(string $gender, int $age, int $heightCm, float $weightKg): float
    {
        if ($gender === 'male') {
            return 66.5 + (13.7 * $weightKg) + (5 * $heightCm) - (6.8 * $age);
        }

        return 655 + (9.6 * $weightKg) + (1.8 * $heightCm) - (4.7 * $age);
    }

    public function calculateDailyCalories(
        string $gender,
        int $age,
        int $heightCm,
        float $weightKg,
        string $activityLevel
    ): int {
        $normalizedActivityLevel = $this->normalizeActivityLevel($activityLevel);

        $bmr = $this->calculateBmr(
            gender: $gender,
            age: $age,
            heightCm: $heightCm,
            weightKg: $weightKg
        );

        $activityFactor = self::ACTIVITY_FACTORS[$normalizedActivityLevel]
            ?? self::ACTIVITY_FACTORS['hampir_tidak_pernah_berolahraga'];

        return (int) round($bmr * $activityFactor);
    }

    public function isBodyDataComplete(
        ?string $gender,
        ?int $age,
        ?int $heightCm,
        mixed $weightKg,
        ?string $activityLevel
    ): bool {
        $normalizedActivityLevel = $activityLevel
            ? $this->normalizeActivityLevel($activityLevel)
            : null;

        return filled($gender)
            && filled($age)
            && filled($heightCm)
            && filled($weightKg)
            && filled($normalizedActivityLevel)
            && in_array($gender, ['male', 'female'], true)
            && array_key_exists((string) $normalizedActivityLevel, self::ACTIVITY_FACTORS)
            && (int) $age > 0
            && (int) $heightCm > 0
            && (float) $weightKg > 0;
    }

    public function normalizeActivityLevel(?string $activityLevel): ?string
    {
        return match ($activityLevel) {
            'sangat_ringan' => 'hampir_tidak_pernah_berolahraga',
            'ringan' => 'jarang_berolahraga',
            'sedang', 'berat' => 'sering_berolahraga_atau_aktivitas_fisik_berat',

            'hampir_tidak_pernah_berolahraga',
            'jarang_berolahraga',
            'sering_berolahraga_atau_aktivitas_fisik_berat' => $activityLevel,

            default => null,
        };
    }

    public function getActivityLabel(?string $activityLevel): string
    {
        $normalizedActivityLevel = $this->normalizeActivityLevel($activityLevel);

        if (! $normalizedActivityLevel) {
            return '-';
        }

        return self::ACTIVITY_LABELS[$normalizedActivityLevel] ?? '-';
    }
}