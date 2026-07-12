<?php

namespace App\Livewire\User;

use App\Models\User;
use App\Services\CalorieCalculatorService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;

class ProfileSaya extends Component
{
    public string $name = '';

    public string $email = '';

    public ?string $gender = null;

    public $age = null;

    public $height_cm = null;

    public $weight_kg = null;

    public ?string $activity_level = null;

    public ?int $daily_calorie_target = null;

    public string $current_password = '';

    public string $password = '';

    public string $password_confirmation = '';

    public array $activityOptions = [];

    public function mount(): void
    {
        if (! Auth::check()) {
            abort(403);
        }

        $this->activityOptions = CalorieCalculatorService::ACTIVITY_LABELS;

        $this->fillFromUser();
    }

    public function saveProfile(): void
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $this->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'gender' => [
                'required',
                Rule::in(['male', 'female']),
            ],
            'age' => [
                'required',
                'integer',
                'min:10',
                'max:100',
            ],
            'height_cm' => [
                'required',
                'integer',
                'min:100',
                'max:250',
            ],
            'weight_kg' => [
                'required',
                'numeric',
                'min:25',
                'max:300',
            ],
            'activity_level' => [
                'required',
                Rule::in(array_keys(CalorieCalculatorService::ACTIVITY_FACTORS)),
            ],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh akun lain.',
            'gender.required' => 'Gender wajib dipilih.',
            'age.required' => 'Usia wajib diisi.',
            'height_cm.required' => 'Tinggi badan wajib diisi.',
            'weight_kg.required' => 'Berat badan wajib diisi.',
            'activity_level.required' => 'Aktivitas wajib dipilih.',
        ]);

        $calculator = app(CalorieCalculatorService::class);

        $normalizedActivityLevel = $calculator->normalizeActivityLevel(
            (string) $validated['activity_level']
        );

        if (! $normalizedActivityLevel) {
            $this->addError('activity_level', 'Aktivitas tidak valid.');
            return;
        }

        $dailyCalories = $calculator->calculateDailyCalories(
            gender: (string) $validated['gender'],
            age: (int) $validated['age'],
            heightCm: (int) $validated['height_cm'],
            weightKg: (float) $validated['weight_kg'],
            activityLevel: $normalizedActivityLevel
        );

        $user->forceFill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'gender' => $validated['gender'],
            'age' => (int) $validated['age'],
            'height_cm' => (int) $validated['height_cm'],
            'weight_kg' => (float) $validated['weight_kg'],
            'activity_level' => $normalizedActivityLevel,
            'daily_calorie_target' => $dailyCalories,
        ])->save();

        $this->activity_level = $normalizedActivityLevel;
        $this->daily_calorie_target = $dailyCalories;

        session()->flash('profile_success', 'Profil berhasil diperbarui dan target kalori harian berhasil dihitung ulang.');
    }

    public function updatePassword(): void
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $this->validate([
            'current_password' => [
                'required',
                'string',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        if (! Hash::check($validated['current_password'], $user->password)) {
            $this->addError('current_password', 'Password saat ini tidak sesuai.');
            return;
        }

        $user->forceFill([
            'password' => Hash::make($validated['password']),
        ])->save();

        $this->current_password = '';
        $this->password = '';
        $this->password_confirmation = '';

        session()->flash('password_success', 'Password berhasil diperbarui.');
    }

    public function resetProfileForm(): void
    {
        $this->resetValidation();

        $this->fillFromUser();

        session()->flash('profile_success', 'Form profil dikembalikan ke data akun terbaru.');
    }

    private function fillFromUser(): void
    {
        /** @var User $user */
        $user = Auth::user();

        $calculator = app(CalorieCalculatorService::class);

        $normalizedActivityLevel = $calculator->normalizeActivityLevel($user->activity_level);

        $this->name = (string) $user->name;
        $this->email = (string) $user->email;
        $this->gender = $user->gender;
        $this->age = $user->age;
        $this->height_cm = $user->height_cm;
        $this->weight_kg = $user->weight_kg;
        $this->activity_level = $normalizedActivityLevel;
        $this->daily_calorie_target = $user->daily_calorie_target;
    }

    public function render(): View
    {
        return view('livewire.user.profile-saya');
    }
}