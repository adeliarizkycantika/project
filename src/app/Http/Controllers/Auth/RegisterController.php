<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\CalorieCalculatorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register', [
            'activityOptions' => CalorieCalculatorService::ACTIVITY_LABELS,
        ]);
    }

    public function store(Request $request, CalorieCalculatorService $calculator): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],

            'password' => ['required', 'string', 'min:8', 'confirmed'],

            'gender' => ['required', Rule::in(['male', 'female'])],

            'age' => ['required', 'integer', 'min:10', 'max:100'],

            'height_cm' => ['required', 'integer', 'min:100', 'max:250'],

            'weight_kg' => ['required', 'numeric', 'min:25', 'max:300'],

            'activity_level' => ['required', Rule::in(array_keys(CalorieCalculatorService::ACTIVITY_FACTORS))],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'gender.required' => 'Gender wajib dipilih.',
            'age.required' => 'Usia wajib diisi.',
            'age.min' => 'Usia minimal 10 tahun.',
            'age.max' => 'Usia maksimal 100 tahun.',
            'height_cm.required' => 'Tinggi badan wajib diisi.',
            'height_cm.min' => 'Tinggi badan minimal 100 cm.',
            'height_cm.max' => 'Tinggi badan maksimal 250 cm.',
            'weight_kg.required' => 'Berat badan wajib diisi.',
            'weight_kg.min' => 'Berat badan minimal 25 kg.',
            'weight_kg.max' => 'Berat badan maksimal 300 kg.',
            'activity_level.required' => 'Tingkat aktivitas wajib dipilih.',
        ]);

        $dailyCalories = $calculator->calculateDailyCalories(
            gender: (string) $validated['gender'],
            age: (int) $validated['age'],
            heightCm: (int) $validated['height_cm'],
            weightKg: (float) $validated['weight_kg'],
            activityLevel: (string) $validated['activity_level'],
        );

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'gender' => $validated['gender'],
            'age' => $validated['age'],
            'height_cm' => $validated['height_cm'],
            'weight_kg' => $validated['weight_kg'],
            'activity_level' => $validated['activity_level'],
            'daily_calorie_target' => $dailyCalories,
            'role' => 'user',
        ]);

        $this->syncDefaultUserRole($user);

        Auth::login($user);

        $request->session()->regenerate();

        if (Route::has('user.beranda')) {
            return redirect()->route('user.beranda');
        }

        if (Route::has('dashboard')) {
            return redirect()->route('dashboard');
        }

        return redirect('/');
    }

    private function syncDefaultUserRole(User $user): void
    {
        if (! Schema::hasTable('roles') || ! Schema::hasTable('model_has_roles')) {
            return;
        }

        if (class_exists(PermissionRegistrar::class)) {
            app(PermissionRegistrar::class)->forgetCachedPermissions();
        }

        Role::firstOrCreate([
            'name' => 'user',
            'guard_name' => 'web',
        ]);

        if (method_exists($user, 'syncRoles')) {
            $user->syncRoles(['user']);
        }
    }
}