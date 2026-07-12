<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Services\CalorieCalculatorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
                'string',
            ],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()
                ->withErrors([
                    'email' => 'Email atau password tidak sesuai.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user && method_exists($user, 'isAdmin') && $user->isAdmin()) {
            return redirect()->intended('/admin');
        }

        return redirect()->intended(route('user.dashboard'));
    }

    public function showRegisterForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }

        return view('auth.register');
    }

    public function register(Request $request, CalorieCalculatorService $calculator): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
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
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'gender.required' => 'Gender wajib dipilih.',
            'age.required' => 'Usia wajib diisi.',
            'height_cm.required' => 'Tinggi badan wajib diisi.',
            'weight_kg.required' => 'Berat badan wajib diisi.',
            'activity_level.required' => 'Aktivitas wajib dipilih.',
        ]);

        $dailyCalories = $calculator->calculateDailyCalories(
            gender: (string) $validated['gender'],
            age: (int) $validated['age'],
            heightCm: (int) $validated['height_cm'],
            weightKg: (float) $validated['weight_kg'],
            activityLevel: (string) $validated['activity_level']
        );

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'gender' => $validated['gender'],
            'age' => (int) $validated['age'],
            'height_cm' => (int) $validated['height_cm'],
            'weight_kg' => (float) $validated['weight_kg'],
            'activity_level' => $validated['activity_level'],
            'daily_calorie_target' => $dailyCalories,
            'role' => 'user',
        ]);

        if (method_exists($user, 'assignRole')) {
            $user->assignRole('user');
        }

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('user.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}