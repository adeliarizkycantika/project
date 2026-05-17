<div>
    <div class="page-header">
        <div>
            <h1 class="page-title">Profile Saya</h1>
            <p class="page-subtitle">
                Kelola data akun dan target kalori harian kamu.
            </p>
        </div>
    </div>

    <div class="card" style="padding: 24px;">
        <form wire:submit.prevent="updateProfile">
            <div style="margin-bottom: 16px;">
                <label>Nama</label>
                <input type="text" wire:model="name" style="width: 100%; height: 46px;">
                @error('name') <p style="color: red;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 16px;">
                <label>Email</label>
                <input type="email" wire:model="email" style="width: 100%; height: 46px;">
                @error('email') <p style="color: red;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 16px;">
                <label>Target Kalori Harian</label>
                <input type="number" wire:model="daily_calorie_target" style="width: 100%; height: 46px;">
                @error('daily_calorie_target') <p style="color: red;">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                Simpan Profile
            </button>
        </form>
    </div>
</div>