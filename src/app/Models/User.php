<?php

namespace App\Models;

use App\Services\CalorieCalculatorService;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use Notifiable;

    protected string $guard_name = 'web';

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'google_id',
        'google_avatar',
        'gender',
        'age',
        'height_cm',
        'weight_kg',
        'activity_level',
        'daily_calorie_target',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'age' => 'integer',
        'height_cm' => 'integer',
        'weight_kg' => 'float',
        'daily_calorie_target' => 'integer',
    ];

    public function makanans()
    {
        return $this->hasMany(Makanan::class);
    }

    public function foods()
    {
        return $this->makanans();
    }

    public function mealPlans()
    {
        return $this->hasMany(MealPlan::class);
    }

    public function itemDaftarBelanjas()
    {
        return $this->hasMany(ItemDaftarBelanja::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin();
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin')
            || $this->role === 'admin';
    }

    public function hasCompleteBodyData(): bool
    {
        return app(CalorieCalculatorService::class)
            ->isBodyDataComplete(
                gender: $this->gender,
                age: $this->age,
                heightCm: $this->height_cm,
                weightKg: $this->weight_kg,
                activityLevel: $this->activity_level
            );
    }

    public function recalculateDailyCalories(): ?int
    {
        if (! $this->hasCompleteBodyData()) {
            return null;
        }

        $calculator = app(
            CalorieCalculatorService::class
        );

        $normalizedActivityLevel = $calculator
            ->normalizeActivityLevel(
                $this->activity_level
            );

        if (! $normalizedActivityLevel) {
            return null;
        }

        $dailyCalories = $calculator
            ->calculateDailyCalories(
                gender: (string) $this->gender,
                age: (int) $this->age,
                heightCm: (int) $this->height_cm,
                weightKg: (float) $this->weight_kg,
                activityLevel: $normalizedActivityLevel
            );

        $this->forceFill([
            'activity_level' => $normalizedActivityLevel,
            'daily_calorie_target' => $dailyCalories,
        ])->save();

        return $dailyCalories;
    }

    public function getGenderLabelAttribute(): string
    {
        return match ($this->gender) {
            'male' => 'Male',
            'female' => 'Female',
            default => '-',
        };
    }

    public function getActivityLevelLabelAttribute(): string
    {
        return app(CalorieCalculatorService::class)
            ->getActivityLabel(
                $this->activity_level
            );
    }
}