<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\CalorieCalculatorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Menampilkan halaman registrasi.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Menyimpan akun pengguna baru, data tubuh,
     * dan menghitung kebutuhan kalori harian otomatis.
     */
    public function store(Request $request, CalorieCalculatorService $calorieCalculator): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
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
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak sesuai.',
            'gender.required' => 'Gender wajib dipilih.',
            'age.required' => 'Usia wajib diisi.',
            'height_cm.required' => 'Tinggi badan wajib diisi.',
            'weight_kg.required' => 'Berat badan wajib diisi.',
            'activity_level.required' => 'Tingkat aktivitas wajib dipilih.',
        ]);

        $dailyCalories = $calorieCalculator->calculateDailyCalories(
            gender: $validated['gender'],
            age: (int) $validated['age'],
            heightCm: (int) $validated['height_cm'],
            weightKg: (float) $validated['weight_kg'],
            activityLevel: $validated['activity_level']
        );

        User::create([
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

        return redirect()
            ->route('login')
            ->with('success', 'Registrasi berhasil. Silakan masuk untuk melihat kebutuhan kalori harian kamu.');
    }
}