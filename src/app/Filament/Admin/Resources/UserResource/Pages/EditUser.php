<?php

namespace App\Filament\Admin\Resources\UserResource\Pages;

use App\Filament\Admin\Resources\UserResource;
use App\Models\User;
use App\Services\CalorieCalculatorService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Hapus')
                ->visible(function (): bool {
                    /** @var User $record */
                    $record = $this->getRecord();

                    return Auth::id() !== (int) $record->getKey();
                }),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['daily_calorie_target'] = $this->calculateDailyCalories($data);

        return $data;
    }

    protected function afterSave(): void
    {
        /** @var User $record */
        $record = $this->getRecord();

        $this->syncUserRole($record);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    private function calculateDailyCalories(array $data): ?int
    {
        $calculator = app(CalorieCalculatorService::class);

        $isComplete = $calculator->isBodyDataComplete(
            gender: $data['gender'] ?? null,
            age: isset($data['age']) ? (int) $data['age'] : null,
            heightCm: isset($data['height_cm']) ? (int) $data['height_cm'] : null,
            weightKg: isset($data['weight_kg']) ? (float) $data['weight_kg'] : null,
            activityLevel: $data['activity_level'] ?? null,
        );

        if (! $isComplete) {
            return null;
        }

        return $calculator->calculateDailyCalories(
            gender: (string) $data['gender'],
            age: (int) $data['age'],
            heightCm: (int) $data['height_cm'],
            weightKg: (float) $data['weight_kg'],
            activityLevel: (string) $data['activity_level'],
        );
    }

    private function syncUserRole(User $user): void
    {
        if (! Schema::hasTable('roles') || ! Schema::hasTable('model_has_roles')) {
            return;
        }

        if (class_exists(PermissionRegistrar::class)) {
            app(PermissionRegistrar::class)->forgetCachedPermissions();
        }

        $role = $user->role ?: 'user';

        Role::firstOrCreate([
            'name' => $role,
            'guard_name' => 'web',
        ]);

        if ($role === 'admin') {
            Role::firstOrCreate([
                'name' => 'super_admin',
                'guard_name' => 'web',
            ]);

            $user->syncRoles([
                'super_admin',
                'admin',
            ]);

            return;
        }

        $user->syncRoles([
            $role,
        ]);
    }
}