<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class ProfileSaya extends Component
{
    public string $name = '';

    public string $email = '';

    public int $daily_calorie_target = 2000;

    public ?string $current_password = null;

    public ?string $password = null;

    public ?string $password_confirmation = null;

    public function mount(): void
    {
        $user = $this->getAuthenticatedUser();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->daily_calorie_target = (int) ($user->daily_calorie_target ?? 2000);
    }

    public function updateProfile(): void
    {
        $user = $this->getAuthenticatedUser();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'daily_calorie_target' => ['required', 'integer', 'min:1', 'max:10000'],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'daily_calorie_target' => $validated['daily_calorie_target'],
        ]);

        session()->flash('success', 'Profile berhasil diperbarui.');
    }

    public function updatePassword(): void
    {
        $user = $this->getAuthenticatedUser();

        $validated = $this->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (! Hash::check($validated['current_password'], $user->password)) {
            $this->addError('current_password', 'Password lama tidak sesuai.');

            return;
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset([
            'current_password',
            'password',
            'password_confirmation',
        ]);

        session()->flash('success', 'Password berhasil diperbarui.');
    }

    private function getAuthenticatedUser(): User
    {
        $userId = Auth::id();

        if (! $userId) {
            abort(403);
        }

        return User::query()->findOrFail($userId);
    }

    public function render()
    {
        return view('livewire.user.profile-saya');
    }
}