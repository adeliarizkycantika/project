<?php

namespace App\Livewire\User;

use App\Models\ItemDaftarBelanja;
use App\Models\KategoriMakanan;
use App\Models\Makanan;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;

#[Layout('layouts.user')]
class DaftarBelanjaSaya extends Component
{
    use WithPagination;

    public string $search = '';

    public string $statusFilter = '';

    public bool $showForm = false;

    public ?int $editingId = null;

    /*
    |--------------------------------------------------------------------------
    | Data belanja
    |--------------------------------------------------------------------------
    */

    public string $nama_item = '';

    public $jumlah = 1;

    public string $satuan = 'pcs';

    public ?string $kategori = null;

    public ?string $catatan = null;

    public bool $sudah_dibeli = false;

    /*
    |--------------------------------------------------------------------------
    | Data nutrisi makanan
    |--------------------------------------------------------------------------
    */

    public ?int $kategori_makanan_id = null;

    public $kalori = null;

    public $protein = null;

    public $karbohidrat = null;

    public $lemak = null;

    protected string $paginationTheme = 'tailwind';

    public function mount(): void
    {
        if (! Auth::check()) {
            abort(403);
        }
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function createItem(): void
    {
        $this->resetForm();

        $this->showForm = true;
    }

    public function editItem(int $id): void
    {
        $item = ItemDaftarBelanja::find($id);

        if (! $item instanceof ItemDaftarBelanja) {
            session()->flash(
                'belanja_error',
                'Item belanja tidak ditemukan.'
            );

            return;
        }

        if (! $this->canManageItem($item)) {
            session()->flash(
                'belanja_error',
                'Kamu tidak memiliki akses untuk mengubah item ini.'
            );

            return;
        }

        $this->editingId = $item->id;
        $this->showForm = true;

        $this->nama_item = (string) (
            $this->getAttributeValue($item, [
                'nama_item',
                'nama_bahan',
                'nama',
                'item',
                'bahan',
            ]) ?? ''
        );

        $this->jumlah =
            $this->getAttributeValue($item, [
                'jumlah',
                'qty',
                'quantity',
                'kuantitas',
            ]) ?? 1;

        $this->satuan = (string) (
            $this->getAttributeValue($item, [
                'satuan',
                'unit',
            ]) ?? 'pcs'
        );

        $this->kategori =
            $this->getAttributeValue($item, [
                'kategori',
                'kategori_belanja',
                'category',
            ]);

        $this->catatan =
            $this->getAttributeValue($item, [
                'catatan',
                'keterangan',
                'notes',
                'note',
            ]);

        $this->sudah_dibeli = $this->isPurchased(
            $this->getAttributeValue($item, [
                'sudah_dibeli',
                'is_completed',
                'is_checked',
                'is_bought',
                'dibeli',
                'completed',
                'status',
            ])
        );

        $makanan = $this->resolveMakananForItem(
            $item,
            $this->nama_item
        );

        if ($makanan instanceof Makanan) {
            $this->kategori_makanan_id =
                $makanan->kategori_makanan_id
                    ? (int) $makanan->kategori_makanan_id
                    : null;

            $this->kalori =
                $makanan->kalori;

            $this->protein =
                $makanan->protein;

            $this->karbohidrat =
                $makanan->karbohidrat;

            $this->lemak =
                $makanan->lemak;
        } else {
            $this->kategori_makanan_id = null;
            $this->kalori = null;
            $this->protein = null;
            $this->karbohidrat = null;
            $this->lemak = null;
        }
    }

    public function saveItem(): void
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            session()->flash(
                'belanja_error',
                'User tidak ditemukan. Silakan login ulang.'
            );

            return;
        }

        $itemModel = new ItemDaftarBelanja();
        $table = $itemModel->getTable();

        if (! Schema::hasTable($table)) {
            session()->flash(
                'belanja_error',
                'Tabel daftar belanja belum tersedia.'
            );

            return;
        }

        if (! Schema::hasColumn($table, 'makanan_id')) {
            session()->flash(
                'belanja_error',
                'Kolom makanan_id belum tersedia. Jalankan migration terlebih dahulu.'
            );

            return;
        }

        $validated = $this->validate([
            'nama_item' => [
                'required',
                'string',
                'max:255',
            ],
            'jumlah' => [
                'required',
                'numeric',
                'min:0.1',
                'max:100000',
            ],
            'satuan' => [
                'required',
                'string',
                'max:50',
            ],
            'kategori' => [
                'nullable',
                'string',
                'max:100',
            ],
            'catatan' => [
                'nullable',
                'string',
                'max:500',
            ],
            'sudah_dibeli' => [
                'boolean',
            ],
            'kategori_makanan_id' => [
                'required',
                'integer',
            ],
            'kalori' => [
                'required',
                'numeric',
                'min:0',
                'max:10000',
            ],
            'protein' => [
                'required',
                'numeric',
                'min:0',
                'max:1000',
            ],
            'karbohidrat' => [
                'required',
                'numeric',
                'min:0',
                'max:1000',
            ],
            'lemak' => [
                'required',
                'numeric',
                'min:0',
                'max:1000',
            ],
        ], [
            'nama_item.required' =>
                'Nama item wajib diisi.',

            'jumlah.required' =>
                'Jumlah wajib diisi.',

            'jumlah.min' =>
                'Jumlah minimal 0,1.',

            'satuan.required' =>
                'Satuan wajib diisi.',

            'kategori_makanan_id.required' =>
                'Kategori makanan wajib dipilih.',

            'kalori.required' =>
                'Kalori per porsi wajib diisi.',

            'protein.required' =>
                'Protein per porsi wajib diisi.',

            'karbohidrat.required' =>
                'Karbohidrat per porsi wajib diisi.',

            'lemak.required' =>
                'Lemak per porsi wajib diisi.',
        ]);

        $kategoriMakanan = KategoriMakanan::find(
            (int) $validated['kategori_makanan_id']
        );

        if (! $kategoriMakanan instanceof KategoriMakanan) {
            session()->flash(
                'belanja_error',
                'Kategori makanan yang dipilih tidak ditemukan.'
            );

            return;
        }

        if ($this->editingId) {
            $item = ItemDaftarBelanja::find(
                $this->editingId
            );

            if (! $item instanceof ItemDaftarBelanja) {
                session()->flash(
                    'belanja_error',
                    'Item belanja tidak ditemukan.'
                );

                return;
            }

            if (! $this->canManageItem($item)) {
                session()->flash(
                    'belanja_error',
                    'Kamu tidak memiliki akses untuk mengubah item ini.'
                );

                return;
            }
        } else {
            $item = new ItemDaftarBelanja();

            if (Schema::hasColumn($table, 'user_id')) {
                $item->user_id = $user->id;
            }
        }

        try {
            DB::transaction(function () use (
                $item,
                $user,
                $validated
            ): void {
                $makanan = $this->createOrUpdateMakanan(
                    item: $item,
                    user: $user,
                    validated: $validated
                );

                $this->fillItemData(
                    $item,
                    $validated
                );

                $item->makanan_id = $makanan->id;

                $item->save();
            });
        } catch (Throwable $exception) {
            report($exception);

            session()->flash(
                'belanja_error',
                'Item belanja gagal disimpan. Periksa kembali data belanja dan nutrisi.'
            );

            return;
        }

        session()->flash(
            'belanja_success',
            $validated['sudah_dibeli']
                ? 'Item berhasil disimpan dan langsung tersedia di Meal Plan.'
                : 'Item berhasil disimpan. Makanan akan tersedia di Meal Plan setelah ditandai sudah dibeli.'
        );

        $this->resetForm();
        $this->resetPage();
    }

    public function togglePurchased(int $id): void
    {
        $item = ItemDaftarBelanja::find($id);

        if (! $item instanceof ItemDaftarBelanja) {
            session()->flash(
                'belanja_error',
                'Item belanja tidak ditemukan.'
            );

            return;
        }

        if (! $this->canManageItem($item)) {
            session()->flash(
                'belanja_error',
                'Kamu tidak memiliki akses untuk mengubah item ini.'
            );

            return;
        }

        $table = $item->getTable();

        $currentStatus = $this->getAttributeValue(
            $item,
            [
                'sudah_dibeli',
                'is_completed',
                'is_checked',
                'is_bought',
                'dibeli',
                'completed',
                'status',
            ]
        );

        $isPurchased =
            $this->isPurchased($currentStatus);

        $newStatus = ! $isPurchased;

        if (Schema::hasColumn($table, 'sudah_dibeli')) {
            $item->sudah_dibeli = $newStatus;
        }

        if (Schema::hasColumn($table, 'is_completed')) {
            $item->is_completed = $newStatus;
        }

        if (Schema::hasColumn($table, 'is_checked')) {
            $item->is_checked = $newStatus;
        }

        if (Schema::hasColumn($table, 'is_bought')) {
            $item->is_bought = $newStatus;
        }

        if (Schema::hasColumn($table, 'dibeli')) {
            $item->dibeli = $newStatus;
        }

        if (Schema::hasColumn($table, 'completed')) {
            $item->completed = $newStatus;
        }

        if (Schema::hasColumn($table, 'status')) {
            $item->status = $newStatus
                ? 'sudah_dibeli'
                : 'belum_dibeli';
        }

        $item->save();

        session()->flash(
            'belanja_success',
            $newStatus
                ? 'Item ditandai sudah dibeli dan makanan sekarang tersedia di Meal Plan.'
                : 'Item ditandai belum dibeli dan makanan disembunyikan dari pilihan Meal Plan.'
        );
    }

    public function deleteItem(int $id): void
    {
        $item = ItemDaftarBelanja::find($id);

        if (! $item instanceof ItemDaftarBelanja) {
            session()->flash(
                'belanja_error',
                'Item belanja tidak ditemukan.'
            );

            return;
        }

        if (! $this->canManageItem($item)) {
            session()->flash(
                'belanja_error',
                'Kamu tidak memiliki akses untuk menghapus item ini.'
            );

            return;
        }

        try {
            $item->delete();

            session()->flash(
                'belanja_success',
                'Item belanja berhasil dihapus.'
            );
        } catch (Throwable $exception) {
            report($exception);

            session()->flash(
                'belanja_error',
                'Item belanja tidak bisa dihapus.'
            );
        }

        $this->resetPage();
    }

    public function clearPurchasedItems(): void
    {
        $items = $this->getBaseQuery()->get();

        $deleted = 0;

        foreach ($items as $item) {
            if (! $item instanceof ItemDaftarBelanja) {
                continue;
            }

            $status = $this->getAttributeValue(
                $item,
                [
                    'sudah_dibeli',
                    'is_completed',
                    'is_checked',
                    'is_bought',
                    'dibeli',
                    'completed',
                    'status',
                ]
            );

            if (! $this->isPurchased($status)) {
                continue;
            }

            try {
                $item->delete();
                $deleted++;
            } catch (Throwable) {
                continue;
            }
        }

        session()->flash(
            'belanja_success',
            $deleted > 0
                ? $deleted . ' item yang sudah dibeli berhasil dibersihkan.'
                : 'Tidak ada item yang sudah dibeli untuk dibersihkan.'
        );

        $this->resetPage();
    }

    public function cancelForm(): void
    {
        $this->resetForm();
    }

    private function createOrUpdateMakanan(
        ItemDaftarBelanja $item,
        User $user,
        array $validated
    ): Makanan {
        $makanan = null;

        if (
            $item->exists
            && Schema::hasColumn(
                $item->getTable(),
                'makanan_id'
            )
            && $item->makanan_id
        ) {
            $linkedMakanan = Makanan::find(
                (int) $item->makanan_id
            );

            if (
                $linkedMakanan instanceof Makanan
                && (int) $linkedMakanan->user_id
                    === (int) $user->id
            ) {
                $makanan = $linkedMakanan;
            }
        }

        $foodName = trim(
            (string) $validated['nama_item']
        );

        if (! $makanan instanceof Makanan) {
            $makanan = Makanan::query()
                ->where('user_id', $user->id)
                ->whereRaw(
                    'LOWER(TRIM(nama)) = ?',
                    [mb_strtolower($foodName)]
                )
                ->first();
        }

        $isNewFood =
            ! $makanan instanceof Makanan;

        if ($isNewFood) {
            $makanan = new Makanan();
            $makanan->user_id = $user->id;
            $makanan->is_public = false;
            $makanan->is_recommended = false;
            $makanan->recommended_note = null;
        }

        $makanan->kategori_makanan_id =
            (int) $validated['kategori_makanan_id'];

        $makanan->nama = $foodName;

        if (
            filled($validated['catatan'] ?? null)
        ) {
            $makanan->deskripsi =
                $validated['catatan'];
        } elseif (
            $isNewFood
            && blank($makanan->deskripsi)
        ) {
            $makanan->deskripsi =
                'Disimpan otomatis dari Daftar Belanja.';
        }

        $makanan->kalori =
            (float) $validated['kalori'];

        $makanan->protein =
            (float) $validated['protein'];

        $makanan->karbohidrat =
            (float) $validated['karbohidrat'];

        $makanan->lemak =
            (float) $validated['lemak'];

        $makanan->save();

        return $makanan;
    }

    private function resolveMakananForItem(
        ItemDaftarBelanja $item,
        string $itemName
    ): ?Makanan {
        if (
            Schema::hasColumn(
                $item->getTable(),
                'makanan_id'
            )
            && $item->makanan_id
        ) {
            $makanan = Makanan::find(
                (int) $item->makanan_id
            );

            if ($makanan instanceof Makanan) {
                return $makanan;
            }
        }

        $userId = Auth::id();

        if (! $userId || trim($itemName) === '') {
            return null;
        }

        $makanan = Makanan::query()
            ->where('user_id', $userId)
            ->whereRaw(
                'LOWER(TRIM(nama)) = ?',
                [mb_strtolower(trim($itemName))]
            )
            ->first();

        return $makanan instanceof Makanan
            ? $makanan
            : null;
    }

    private function resetForm(): void
    {
        $this->resetValidation();

        $this->editingId = null;
        $this->showForm = false;

        $this->nama_item = '';
        $this->jumlah = 1;
        $this->satuan = 'pcs';
        $this->kategori = null;
        $this->catatan = null;
        $this->sudah_dibeli = false;

        $this->kategori_makanan_id = null;
        $this->kalori = null;
        $this->protein = null;
        $this->karbohidrat = null;
        $this->lemak = null;
    }

    private function fillItemData(
        ItemDaftarBelanja $item,
        array $validated
    ): void {
        $table = $item->getTable();

        $nameColumn = $this->firstExistingColumn(
            $table,
            [
                'nama_item',
                'nama_bahan',
                'nama',
                'item',
                'bahan',
            ]
        );

        if ($nameColumn) {
            $item->{$nameColumn} =
                trim($validated['nama_item']);
        }

        $quantityColumn = $this->firstExistingColumn(
            $table,
            [
                'jumlah',
                'qty',
                'quantity',
                'kuantitas',
            ]
        );

        if ($quantityColumn) {
            $item->{$quantityColumn} =
                (float) $validated['jumlah'];
        }

        $unitColumn = $this->firstExistingColumn(
            $table,
            [
                'satuan',
                'unit',
            ]
        );

        if ($unitColumn) {
            $item->{$unitColumn} =
                $validated['satuan'];
        }

        $categoryColumn = $this->firstExistingColumn(
            $table,
            [
                'kategori',
                'kategori_belanja',
                'category',
            ]
        );

        if ($categoryColumn) {
            $item->{$categoryColumn} =
                $validated['kategori'] ?? null;
        }

        $noteColumn = $this->firstExistingColumn(
            $table,
            [
                'catatan',
                'keterangan',
                'notes',
                'note',
            ]
        );

        if ($noteColumn) {
            $item->{$noteColumn} =
                $validated['catatan'] ?? null;
        }

        $status =
            (bool) $validated['sudah_dibeli'];

        if (Schema::hasColumn($table, 'sudah_dibeli')) {
            $item->sudah_dibeli = $status;
        }

        if (Schema::hasColumn($table, 'is_completed')) {
            $item->is_completed = $status;
        }

        if (Schema::hasColumn($table, 'is_checked')) {
            $item->is_checked = $status;
        }

        if (Schema::hasColumn($table, 'is_bought')) {
            $item->is_bought = $status;
        }

        if (Schema::hasColumn($table, 'dibeli')) {
            $item->dibeli = $status;
        }

        if (Schema::hasColumn($table, 'completed')) {
            $item->completed = $status;
        }

        if (Schema::hasColumn($table, 'status')) {
            $item->status = $status
                ? 'sudah_dibeli'
                : 'belum_dibeli';
        }
    }

    private function getBaseQuery()
    {
        $itemModel = new ItemDaftarBelanja();
        $table = $itemModel->getTable();

        $query = ItemDaftarBelanja::query();

        if (Schema::hasColumn($table, 'user_id')) {
            $query->where(
                'user_id',
                Auth::id()
            );
        }

        return $query;
    }

    private function getItemsPaginator(): LengthAwarePaginator
    {
        $itemModel = new ItemDaftarBelanja();
        $table = $itemModel->getTable();

        if (! Schema::hasTable($table)) {
            return new LengthAwarePaginator(
                [],
                0,
                8
            );
        }

        $query = $this->getBaseQuery();

        if (trim($this->search) !== '') {
            $search =
                '%' . trim($this->search) . '%';

            $query->where(
                function ($subQuery) use (
                    $table,
                    $search
                ): void {
                    foreach ([
                        'nama_item',
                        'nama_bahan',
                        'nama',
                        'item',
                        'bahan',
                        'kategori',
                        'kategori_belanja',
                        'category',
                        'catatan',
                        'keterangan',
                        'notes',
                        'note',
                    ] as $column) {
                        if (
                            Schema::hasColumn(
                                $table,
                                $column
                            )
                        ) {
                            $subQuery->orWhere(
                                $column,
                                'like',
                                $search
                            );
                        }
                    }
                }
            );
        }

        if ($this->statusFilter !== '') {
            $query->where(
                function ($subQuery) use (
                    $table
                ): void {
                    $targetPurchased =
                        $this->statusFilter
                        === 'sudah_dibeli';

                    if (
                        Schema::hasColumn(
                            $table,
                            'sudah_dibeli'
                        )
                    ) {
                        $subQuery->where(
                            'sudah_dibeli',
                            $targetPurchased
                        );

                        return;
                    }

                    if (
                        Schema::hasColumn(
                            $table,
                            'status'
                        )
                    ) {
                        if ($targetPurchased) {
                            $subQuery->whereIn(
                                'status',
                                [
                                    'sudah_dibeli',
                                    'dibeli',
                                    'completed',
                                    'selesai',
                                    'done',
                                ]
                            );
                        } else {
                            $subQuery
                                ->whereIn(
                                    'status',
                                    [
                                        'belum_dibeli',
                                        'pending',
                                        'aktif',
                                        'active',
                                        'todo',
                                    ]
                                )
                                ->orWhereNull('status');
                        }
                    }
                }
            );
        }

        if (Schema::hasColumn($table, 'created_at')) {
            $query->latest();
        } else {
            $query->orderByDesc('id');
        }

        return $query
            ->paginate(8)
            ->through(
                fn (ItemDaftarBelanja $item): array =>
                    $this->formatItem($item)
            );
    }

    private function getSummary(): array
    {
        $items = $this->getBaseQuery()->get();

        $total = 0;
        $purchased = 0;
        $pending = 0;

        foreach ($items as $item) {
            if (
                ! $item instanceof ItemDaftarBelanja
            ) {
                continue;
            }

            $total++;

            $status = $this->getAttributeValue(
                $item,
                [
                    'sudah_dibeli',
                    'is_completed',
                    'is_checked',
                    'is_bought',
                    'dibeli',
                    'completed',
                    'status',
                ]
            );

            if ($this->isPurchased($status)) {
                $purchased++;
            } else {
                $pending++;
            }
        }

        $percentage = $total > 0
            ? (int) round(
                ($purchased / $total) * 100
            )
            : 0;

        return [
            'total' => $total,
            'purchased' => $purchased,
            'pending' => $pending,
            'percentage' => $percentage,
        ];
    }

    private function formatItem(
        ItemDaftarBelanja $item
    ): array {
        $name = (string) (
            $this->getAttributeValue($item, [
                'nama_item',
                'nama_bahan',
                'nama',
                'item',
                'bahan',
            ]) ?? 'Item tanpa nama'
        );

        $quantity = (float) (
            $this->getAttributeValue($item, [
                'jumlah',
                'qty',
                'quantity',
                'kuantitas',
            ]) ?? 1
        );

        $unit = (string) (
            $this->getAttributeValue($item, [
                'satuan',
                'unit',
            ]) ?? 'pcs'
        );

        $category = (string) (
            $this->getAttributeValue($item, [
                'kategori',
                'kategori_belanja',
                'category',
            ]) ?? 'Umum'
        );

        $note = $this->getAttributeValue(
            $item,
            [
                'catatan',
                'keterangan',
                'notes',
                'note',
            ]
        );

        $status = $this->getAttributeValue(
            $item,
            [
                'sudah_dibeli',
                'is_completed',
                'is_checked',
                'is_bought',
                'dibeli',
                'completed',
                'status',
            ]
        );

        $makanan = $this->resolveMakananForItem(
            $item,
            $name
        );

        return [
            'id' => $item->id,
            'makanan_id' =>
                $makanan?->id,

            'nama_item' => $name,
            'jumlah' => $quantity,
            'satuan' => $unit,
            'kategori' => $category,
            'catatan' => $note,

            'sudah_dibeli' =>
                $this->isPurchased($status),

            'kalori' =>
                (float) ($makanan?->kalori ?? 0),

            'protein' =>
                (float) ($makanan?->protein ?? 0),

            'karbohidrat' =>
                (float) (
                    $makanan?->karbohidrat ?? 0
                ),

            'lemak' =>
                (float) ($makanan?->lemak ?? 0),

            'nutrisi_lengkap' =>
                $makanan instanceof Makanan,
        ];
    }

    private function getKategoriOptions(): array
    {
        $model = new KategoriMakanan();
        $table = $model->getTable();

        if (! Schema::hasTable($table)) {
            return [];
        }

        $nameColumn = $this->firstExistingColumn(
            $table,
            [
                'nama',
                'name',
                'title',
                'kategori',
            ]
        );

        $query = KategoriMakanan::query();

        if ($nameColumn) {
            $query->orderBy($nameColumn);
        } else {
            $query->orderBy('id');
        }

        return $query
            ->get()
            ->mapWithKeys(
                function (
                    KategoriMakanan $kategori
                ) use ($nameColumn): array {
                    $label = $nameColumn
                        ? $kategori->getAttribute(
                            $nameColumn
                        )
                        : 'Kategori #' . $kategori->id;

                    return [
                        $kategori->id =>
                            (string) $label,
                    ];
                }
            )
            ->toArray();
    }

    private function canManageItem(
        ItemDaftarBelanja $item
    ): bool {
        $table = $item->getTable();

        if (! Schema::hasColumn($table, 'user_id')) {
            return true;
        }

        return (int) $item->user_id
            === (int) Auth::id();
    }

    private function isPurchased(
        mixed $status
    ): bool {
        if (is_bool($status)) {
            return $status;
        }

        if (is_numeric($status)) {
            return (int) $status === 1;
        }

        return in_array(
            (string) $status,
            [
                'sudah_dibeli',
                'dibeli',
                'completed',
                'selesai',
                'done',
                'checked',
                'bought',
            ],
            true
        );
    }

    private function getAttributeValue(
        Model $model,
        array $columns
    ): mixed {
        foreach ($columns as $column) {
            $attributes = $model->getAttributes();

            if (! array_key_exists(
                $column,
                $attributes
            )) {
                continue;
            }

            return $model->getAttribute($column);
        }

        return null;
    }

    private function firstExistingColumn(
        string $table,
        array $columns
    ): ?string {
        foreach ($columns as $column) {
            if (
                Schema::hasColumn(
                    $table,
                    $column
                )
            ) {
                return $column;
            }
        }

        return null;
    }

    public function render(): View
    {
        return view(
            'livewire.user.daftar-belanja-saya',
            [
                'items' =>
                    $this->getItemsPaginator(),

                'summary' =>
                    $this->getSummary(),

                'kategoriOptions' =>
                    $this->getKategoriOptions(),
            ]
        );
    }
}
