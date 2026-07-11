<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\CalorieCalculatorService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\AbstractProvider;
use Throwable;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request)
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

        /** @var User $user */
        $user = Auth::user();

        if (
            $user->hasCompleteBodyData()
            && empty($user->daily_calorie_target)
        ) {
            $user->recalculateDailyCalories();
        }

        if ($user->isAdmin()) {
            return redirect('/admin');
        }

        return redirect()->route('user.dashboard');
    }

    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $googleRegister = session('google_register');
        $isGoogleRegister = is_array($googleRegister);

        if ($isGoogleRegister) {
            $request->merge([
                'name' => $request->input('name')
                    ?: ($googleRegister['name'] ?? null),

                'email' => $googleRegister['email']
                    ?? $request->input('email'),
            ]);
        }

        $existingUserId = $isGoogleRegister
            ? ($googleRegister['existing_user_id'] ?? null)
            : null;

        $passwordRules = $isGoogleRegister
            ? [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ]
            : [
                'required',
                'string',
                'min:8',
                'confirmed',
            ];

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
                Rule::unique('users', 'email')->ignore($existingUserId),
            ],

            'password' => $passwordRules,

            'gender' => [
                'required',
                Rule::in([
                    'male',
                    'female',
                ]),
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
                Rule::in(
                    array_keys(
                        CalorieCalculatorService::ACTIVITY_FACTORS
                    )
                ),
            ],
        ], [
            'name.required' => 'Nama wajib diisi.',
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

        $calculator = app(CalorieCalculatorService::class);

        $normalizedActivityLevel = $calculator->normalizeActivityLevel(
            (string) $validated['activity_level']
        );

        if (! $normalizedActivityLevel) {
            return back()
                ->withErrors([
                    'activity_level' => 'Aktivitas tidak valid.',
                ])
                ->withInput();
        }

        $dailyCalories = $calculator->calculateDailyCalories(
            gender: (string) $validated['gender'],
            age: (int) $validated['age'],
            heightCm: (int) $validated['height_cm'],
            weightKg: (float) $validated['weight_kg'],
            activityLevel: $normalizedActivityLevel
        );

        $plainPassword = $validated['password'] ?? null;

        $user = $existingUserId
            ? User::query()->find($existingUserId)
            : null;

        if ($user instanceof User) {
            $user->forceFill([
                'name' => $validated['name'],
                'email' => $validated['email'],

                'email_verified_at' => $user->email_verified_at
                    ?? now(),

                'google_id' => $googleRegister['google_id']
                    ?? $user->google_id,

                'google_avatar' => $googleRegister['google_avatar']
                    ?? $user->google_avatar,

                'gender' => $validated['gender'],
                'age' => (int) $validated['age'],
                'height_cm' => (int) $validated['height_cm'],
                'weight_kg' => (float) $validated['weight_kg'],
                'activity_level' => $normalizedActivityLevel,
                'daily_calorie_target' => $dailyCalories,
                'role' => $user->role ?: 'user',
            ]);

            if ($plainPassword) {
                $user->password = Hash::make($plainPassword);
            }

            $user->save();
        } else {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],

                'email_verified_at' => $isGoogleRegister
                    ? now()
                    : null,

                'password' => Hash::make(
                    $plainPassword ?: Str::random(40)
                ),

                'google_id' => $isGoogleRegister
                    ? ($googleRegister['google_id'] ?? null)
                    : null,

                'google_avatar' => $isGoogleRegister
                    ? ($googleRegister['google_avatar'] ?? null)
                    : null,

                'gender' => $validated['gender'],
                'age' => (int) $validated['age'],
                'height_cm' => (int) $validated['height_cm'],
                'weight_kg' => (float) $validated['weight_kg'],
                'activity_level' => $normalizedActivityLevel,
                'daily_calorie_target' => $dailyCalories,
                'role' => 'user',
            ]);
        }

        try {
            if (
                method_exists($user, 'assignRole')
                && ! $user->hasRole('user')
                && ! $user->isAdmin()
            ) {
                $user->assignRole('user');
            }
        } catch (Throwable $exception) {
            report($exception);
        }

        $request->session()->forget('google_register');

        Auth::login($user);

        $request->session()->regenerate();

        if ($user->isAdmin()) {
            return redirect('/admin');
        }

        return redirect()->route('user.dashboard');
    }

    public function redirectToGoogle(Request $request)
    {
        $flow = $request->query('flow') === 'register'
            ? 'register'
            : 'login';

        $request->session()->put('google_oauth_flow', $flow);

        /** @var AbstractProvider $provider */
        $provider = Socialite::driver('google');

        return $provider
            ->stateless()
            ->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            /** @var AbstractProvider $provider */
            $provider = Socialite::driver('google');

            $googleUser = $provider
                ->stateless()
                ->user();

            $googleId = (string) $googleUser->getId();
            $googleEmail = $googleUser->getEmail();

            $googleName = $googleUser->getName()
                ?: $googleUser->getNickname()
                ?: 'Google User';

            $googleAvatar = $googleUser->getAvatar();

            if (! $googleEmail) {
                return redirect()
                    ->route('login')
                    ->withErrors([
                        'google' => 'Akun Google tidak memberikan email.',
                    ]);
            }

            $flow = $request->session()->pull(
                'google_oauth_flow',
                'login'
            );

            if ($flow === 'register') {
                return $this->handleGoogleRegisterFlow(
                    request: $request,
                    googleId: $googleId,
                    googleEmail: $googleEmail,
                    googleName: $googleName,
                    googleAvatar: $googleAvatar
                );
            }

            return $this->handleGoogleLoginFlow(
                request: $request,
                googleId: $googleId,
                googleEmail: $googleEmail,
                googleName: $googleName,
                googleAvatar: $googleAvatar
            );
        } catch (Throwable $exception) {
            report($exception);

            return redirect()
                ->route('login')
                ->withErrors([
                    'google' => 'Login Google gagal. Periksa konfigurasi Google OAuth.',
                ]);
        }
    }

    private function handleGoogleRegisterFlow(
        Request $request,
        string $googleId,
        string $googleEmail,
        string $googleName,
        ?string $googleAvatar
    ) {
        $existingUser = User::query()
            ->where('google_id', $googleId)
            ->orWhere('email', $googleEmail)
            ->first();

        $request->session()->put('google_register', [
            'existing_user_id' => $existingUser?->id,
            'google_id' => $googleId,
            'name' => $googleName,
            'email' => $googleEmail,
            'google_avatar' => $googleAvatar,
        ]);

        return redirect()
            ->route('register')
            ->with(
                'google_register_success',
                'Akun Google berhasil terhubung. Lengkapi data tubuh lalu klik Daftar Sekarang.'
            );
    }

    private function handleGoogleLoginFlow(
        Request $request,
        string $googleId,
        string $googleEmail,
        string $googleName,
        ?string $googleAvatar
    ) {
        $user = DB::transaction(
            function () use (
                $googleId,
                $googleEmail,
                $googleName,
                $googleAvatar
            ) {
                $existingUser = User::query()
                    ->where('google_id', $googleId)
                    ->first();

                if ($existingUser instanceof User) {
                    $existingUser->forceFill([
                        'name' => $existingUser->name ?: $googleName,
                        'google_avatar' => $googleAvatar,
                        'email_verified_at' => $existingUser->email_verified_at
                            ?? now(),
                    ])->save();

                    return $existingUser;
                }

                $userByEmail = User::query()
                    ->where('email', $googleEmail)
                    ->first();

                if ($userByEmail instanceof User) {
                    $userByEmail->forceFill([
                        'google_id' => $googleId,
                        'google_avatar' => $googleAvatar,
                        'email_verified_at' => $userByEmail->email_verified_at
                            ?? now(),
                    ])->save();

                    return $userByEmail;
                }

                $newUser = new User();

                $newUser->forceFill([
                    'name' => $googleName,
                    'email' => $googleEmail,
                    'email_verified_at' => now(),
                    'password' => Hash::make(Str::random(40)),
                    'google_id' => $googleId,
                    'google_avatar' => $googleAvatar,
                    'role' => 'user',
                ])->save();

                try {
                    if (method_exists($newUser, 'assignRole')) {
                        $newUser->assignRole('user');
                    }
                } catch (Throwable $exception) {
                    report($exception);
                }

                return $newUser;
            }
        );

        if (! $user instanceof User) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'google' => 'Data user Google tidak valid.',
                ]);
        }

        Auth::login($user, true);

        $request->session()->regenerate();

        if (
            $user->hasCompleteBodyData()
            && empty($user->daily_calorie_target)
        ) {
            $user->recalculateDailyCalories();

            $freshUser = $user->fresh();

            if ($freshUser instanceof User) {
                $user = $freshUser;
            }
        }

        if ($user->isAdmin()) {
            return redirect('/admin');
        }

        if (! $user->hasCompleteBodyData()) {
            session()->flash(
                'profile_success',
                'Login Google berhasil. Lengkapi data tubuh terlebih dahulu.'
            );

            return redirect()->route('user.profil');
        }

        return redirect()->route('user.dashboard');
    }

    /*
    |--------------------------------------------------------------------------
    | Forgot Password
    |--------------------------------------------------------------------------
    */

    public function showForgotPasswordForm(): View
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => [
                'required',
                'email',
            ],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        try {
            $status = Password::sendResetLink([
                'email' => $validated['email'],
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withErrors([
                    'email' => 'Email belum dapat dikirim. Periksa API key dan konfigurasi Resend.',
                ])
                ->onlyInput('email');
        }

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with(
                'status',
                'Link reset password berhasil dikirim. Periksa inbox atau folder spam.'
            );
        }

        return back()
            ->withErrors([
                'email' => 'Email tidak ditemukan atau link reset belum dapat dikirim.',
            ])
            ->onlyInput('email');
    }

    public function showResetPasswordForm(
        Request $request,
        string $token
    ): View {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'token' => [
                'required',
            ],

            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $status = Password::reset(
            [
                'email' => $validated['email'],
                'password' => $validated['password'],
                'password_confirmation' => $request->input(
                    'password_confirmation'
                ),
                'token' => $validated['token'],
            ],
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()
                ->route('login')
                ->with(
                    'status',
                    'Password berhasil diganti. Silakan login menggunakan password baru.'
                );
        }

        return back()
            ->withErrors([
                'email' => 'Token reset tidak valid atau sudah kedaluwarsa.',
            ])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}