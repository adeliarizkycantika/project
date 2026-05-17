<?php

namespace App\Livewire\User;

use App\Models\BahanMakanan;
use App\Models\KategoriMakanan;
use App\Models\Makanan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class MakananSaya extends Component
{
    public ?int $selectedMakananId = null;

    public bool $isEditing = false;

    public ?int $kategori_makanan_id = null;

    public string $nama = '';

    public ?string $deskripsi = null;

    public int $kalori = 0;

    public string $protein = '0';

    public string $karbohidrat = '0';

    public string $lemak = '0';

    public ?int $bahan_makanan_target_id = null;

    public string $bahan_nama = '';

    public ?string $bahan_jumlah = null;

    public ?string $bahan_satuan = null;

    public function createMakanan(): void
    {
        $userId = $this->getUserId();

        $validated = $this->validate([
            'kategori_makanan_id' => ['required', 'integer', 'exists:kategori_makanan,id'],
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'kalori' => ['required', 'integer', 'min:0'],
            'protein' => ['required', 'numeric', 'min:0'],
            'karbohidrat' => ['required', 'numeric', 'min:0'],
            'lemak' => ['required', 'numeric', 'min:0'],
        ]);

        $makanan = Makanan::create([
            'user_id' => $userId,
            'kategori_makanan_id' => $validated['kategori_makanan_id'],
            'nama' => $validated['nama'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'kalori' => $validated['kalori'],
            'protein' => $validated['protein'],
            'karbohidrat' => $validated['karbohidrat'],
            'lemak' => $validated['lemak'],
            'gambar' => null,
        ]);

        $this->resetFormMakanan();

        $this->bahan_makanan_target_id = $makanan->id;

        session()->flash('success', 'Makanan berhasil ditambahkan. Sekarang tambahkan bahan makanannya.');
    }

    public function editMakanan(int $makananId): void
    {
        $makanan = $this->getOwnedMakanan($makananId);

        $this->selectedMakananId = $makanan->id;
        $this->isEditing = true;

        $this->kategori_makanan_id = $makanan->kategori_makanan_id;
        $this->nama = $makanan->nama;
        $this->deskripsi = $makanan->deskripsi;
        $this->kalori = (int) $makanan->kalori;
        $this->protein = (string) $makanan->protein;
        $this->karbohidrat = (string) $makanan->karbohidrat;
        $this->lemak = (string) $makanan->lemak;
    }

    public function updateMakanan(): void
    {
        if (! $this->selectedMakananId) {
            abort(404);
        }

        $makanan = $this->getOwnedMakanan($this->selectedMakananId);

        $validated = $this->validate([
            'kategori_makanan_id' => ['required', 'integer', 'exists:kategori_makanan,id'],
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'kalori' => ['required', 'integer', 'min:0'],
            'protein' => ['required', 'numeric', 'min:0'],
            'karbohidrat' => ['required', 'numeric', 'min:0'],
            'lemak' => ['required', 'numeric', 'min:0'],
        ]);

        $makanan->update([
            'kategori_makanan_id' => $validated['kategori_makanan_id'],
            'nama' => $validated['nama'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'kalori' => $validated['kalori'],
            'protein' => $validated['protein'],
            'karbohidrat' => $validated['karbohidrat'],
            'lemak' => $validated['lemak'],
        ]);

        $this->resetFormMakanan();

        session()->flash('success', 'Makanan berhasil diperbarui.');
    }

    public function deleteMakanan(int $makananId): void
    {
        $makanan = $this->getOwnedMakanan($makananId);

        if ($makanan->mealPlanItems()->exists()) {
            session()->flash('warning', 'Makanan tidak bisa dihapus karena sudah digunakan di meal plan.');

            return;
        }

        $makanan->delete();

        if ($this->selectedMakananId === $makananId) {
            $this->resetFormMakanan();
        }

        session()->flash('success', 'Makanan berhasil dihapus.');
    }

    public function cancelEdit(): void
    {
        $this->resetFormMakanan();
    }

    public function addBahanMakanan(): void
    {
        if (! $this->bahan_makanan_target_id) {
            session()->flash('warning', 'Pilih makanan terlebih dahulu.');

            return;
        }

        $makanan = $this->getOwnedMakanan($this->bahan_makanan_target_id);

        $validated = $this->validate([
            'bahan_nama' => ['required', 'string', 'max:255'],
            'bahan_jumlah' => ['nullable', 'numeric', 'min:0'],
            'bahan_satuan' => ['nullable', 'string', 'max:50'],
        ]);

        BahanMakanan::create([
            'makanan_id' => $makanan->id,
            'nama' => $validated['bahan_nama'],
            'jumlah' => $validated['bahan_jumlah'] ?? null,
            'satuan' => $validated['bahan_satuan'] ?? null,
        ]);

        $this->reset([
            'bahan_nama',
            'bahan_jumlah',
            'bahan_satuan',
        ]);

        session()->flash('success', 'Bahan makanan berhasil ditambahkan.');
    }

    public function deleteBahanMakanan(int $bahanMakananId): void
    {
        $userId = $this->getUserId();

        $bahanMakanan = BahanMakanan::query()
            ->whereHas('makanan', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where('id', $bahanMakananId)
            ->firstOrFail();

        $bahanMakanan->delete();

        session()->flash('success', 'Bahan makanan berhasil dihapus.');
    }

    public function pilihMakananUntukBahan(int $makananId): void
    {
        $makanan = $this->getOwnedMakanan($makananId);

        $this->bahan_makanan_target_id = $makanan->id;
    }

    private function resetFormMakanan(): void
    {
        $this->reset([
            'selectedMakananId',
            'isEditing',
            'kategori_makanan_id',
            'nama',
            'deskripsi',
            'kalori',
            'protein',
            'karbohidrat',
            'lemak',
        ]);

        $this->kalori = 0;
        $this->protein = '0';
        $this->karbohidrat = '0';
        $this->lemak = '0';
    }

    private function getUserId(): int
    {
        $userId = Auth::id();

        if (! $userId) {
            abort(403);
        }

        return (int) $userId;
    }

    private function getOwnedMakanan(int $makananId): Makanan
    {
        return Makanan::query()
            ->where('user_id', $this->getUserId())
            ->where('id', $makananId)
            ->firstOrFail();
    }

    #[Computed]
    public function kategoriMakanan(): Collection
    {
        return KategoriMakanan::query()
            ->orderBy('nama')
            ->get();
    }

    #[Computed]
    public function makananSaya(): Collection
    {
        return Makanan::query()
            ->with([
                'kategori',
                'bahanMakanan',
            ])
            ->where('user_id', $this->getUserId())
            ->orderByDesc('id')
            ->get();
    }

    public function render()
    {
        return view('livewire.user.makanan-saya');
    }
}