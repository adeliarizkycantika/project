<?php

namespace App\Livewire\User;

use App\Models\KategoriMakanan;
use App\Models\Makanan;
use App\Models\MealPlan;
use App\Models\MealPlanItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;

#[Layout('layouts.user')]
class MakananSaya extends Component
{
    use WithPagination;

    public string $search = '';

    public string $kategoriFilter = '';

    public string $visibilityFilter = '';

    public bool $showForm = false;

    public ?int $editingId = null;

    public ?int $kategori_makanan_id = null;

    public string $nama = '';

    public ?string $deskripsi = null;

    public $kalori = null;

    public $protein = null;

    public $karbohidrat = null;

    public $lemak = null;

    public $porsi = 1;

    public string $satuan = 'porsi';

    public bool $is_public = false;

    public bool $is_recommended = false;

    public ?string $recommended_note = null;

    /*
    |--------------------------------------------------------------------------
    | Form tambah langsung ke Meal Plan
    |--------------------------------------------------------------------------
    */

    public bool $showMealPlanForm = false;

    public ?int $mealPlanMakananId = null;

    public string $mealPlanDate = '';

    public string $mealPlanMealTime = 'sarapan';

    public $mealPlanPorsi = 1;

    public ?string $mealPlanCatatan = null;

    public array $mealTimeOptions = [
        'sarapan' => 'Sarapan',
        'makan_siang' => 'Makan Siang',
        'makan_malam' => 'Makan Malam',
        'cemilan' => 'Cemilan',
    ];

    protected string $paginationTheme = 'tailwind';

    public function mount(): void
    {
        if (! Auth::check()) {
            abort(403);
        }

        $this->mealPlanDate = Carbon::today()->toDateString();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingKategoriFilter(): void
    {
        $this->resetPage();
    }

    public function updatingVisibilityFilter(): void
    {
        $this->resetPage();
    }

    /*
    |--------------------------------------------------------------------------
    | CRUD Makanan
    |--------------------------------------------------------------------------
    */

    public function createMakanan(): void
    {
        $this->resetForm();

        $this->showForm = true;
    }

    public function editMakanan(int $id): void
    {
        $makanan = Makanan::find($id);

        if (! $makanan instanceof Makanan) {
            session()->flash(
                'makanan_error',
                'Data makanan tidak ditemukan.'
            );

            return;
        }

        if (! $this->canManageMakanan($makanan)) {
            session()->flash(
                'makanan_error',
                'Kamu tidak memiliki akses untuk mengubah makanan ini.'
            );

            return;
        }

        $table = $makanan->getTable();

        $this->editingId = $makanan->id;
        $this->showForm = true;

        $this->kategori_makanan_id = $this->getAttributeValue(
            $makanan,
            [
                'kategori_makanan_id',
                'kategori_id',
                'category_id',
            ]
        );

        $this->nama = (string) (
            $this->getAttributeValue(
                $makanan,
                [
                    'nama',
                    'name',
                    'nama_makanan',
                    'title',
                ]
            ) ?? ''
        );

        $this->deskripsi = $this->getAttributeValue(
            $makanan,
            [
                'deskripsi',
                'description',
                'catatan',
                'note',
            ]
        );

        $this->kalori = $this->getAttributeValue(
            $makanan,
            [
                'kalori',
                'calories',
                'calorie',
                'kalori_per_porsi',
                'total_calories',
            ]
        );

        $this->protein = $this->getAttributeValue(
            $makanan,
            [
                'protein',
                'protein_gram',
                'protein_g',
            ]
        );

        $this->karbohidrat = $this->getAttributeValue(
            $makanan,
            [
                'karbohidrat',
                'karbo',
                'carbohydrate',
                'carbs',
                'carb',
            ]
        );

        $this->lemak = $this->getAttributeValue(
            $makanan,
            [
                'lemak',
                'fat',
                'fat_gram',
                'fat_g',
            ]
        );

        $this->porsi = $this->getAttributeValue(
            $makanan,
            [
                'porsi',
                'portion',
                'jumlah_porsi',
                'quantity',
                'qty',
            ]
        ) ?? 1;

        $this->satuan = (string) (
            $this->getAttributeValue(
                $makanan,
                [
                    'satuan',
                    'unit',
                ]
            ) ?? 'porsi'
        );

        $this->is_public = Schema::hasColumn(
            $table,
            'is_public'
        )
            ? (bool) $makanan->is_public
            : false;

        $this->is_recommended = Schema::hasColumn(
            $table,
            'is_recommended'
        )
            ? (bool) $makanan->is_recommended
            : false;

        $this->recommended_note = Schema::hasColumn(
            $table,
            'recommended_note'
        )
            ? $makanan->recommended_note
            : null;
    }

    public function saveMakanan(): void
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            session()->flash(
                'makanan_error',
                'User tidak ditemukan. Silakan login ulang.'
            );

            return;
        }

        $makananModel = new Makanan();
        $table = $makananModel->getTable();

        if (! Schema::hasTable($table)) {
            session()->flash(
                'makanan_error',
                'Tabel makanan belum tersedia.'
            );

            return;
        }

        $validated = $this->validate([
            'kategori_makanan_id' => [
                'nullable',
                'integer',
            ],
            'nama' => [
                'required',
                'string',
                'max:255',
            ],
            'deskripsi' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'kalori' => [
                'required',
                'numeric',
                'min:0',
                'max:10000',
            ],
            'protein' => [
                'nullable',
                'numeric',
                'min:0',
                'max:1000',
            ],
            'karbohidrat' => [
                'nullable',
                'numeric',
                'min:0',
                'max:1000',
            ],
            'lemak' => [
                'nullable',
                'numeric',
                'min:0',
                'max:1000',
            ],
            'porsi' => [
                'required',
                'numeric',
                'min:0.1',
                'max:100',
            ],
            'satuan' => [
                'required',
                'string',
                'max:50',
            ],
            'is_public' => [
                'boolean',
            ],
            'is_recommended' => [
                'boolean',
            ],
            'recommended_note' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ], [
            'nama.required' => 'Nama makanan wajib diisi.',
            'kalori.required' => 'Kalori wajib diisi.',
            'porsi.required' => 'Porsi wajib diisi.',
            'satuan.required' => 'Satuan wajib diisi.',
        ]);

        if ($this->editingId) {
            $makanan = Makanan::find($this->editingId);

            if (! $makanan instanceof Makanan) {
                session()->flash(
                    'makanan_error',
                    'Data makanan tidak ditemukan.'
                );

                return;
            }

            if (! $this->canManageMakanan($makanan)) {
                session()->flash(
                    'makanan_error',
                    'Kamu tidak memiliki akses untuk mengubah makanan ini.'
                );

                return;
            }
        } else {
            $makanan = new Makanan();

            if (Schema::hasColumn($table, 'user_id')) {
                $makanan->user_id = $user->id;
            }
        }

        $this->fillMakananData(
            $makanan,
            $validated
        );

        $makanan->save();

        session()->flash(
            'makanan_success',
            $this->editingId
                ? 'Data makanan berhasil diperbarui.'
                : 'Data makanan berhasil ditambahkan.'
        );

        $this->resetForm();
        $this->resetPage();
    }

    public function deleteMakanan(int $id): void
    {
        $makanan = Makanan::find($id);

        if (! $makanan instanceof Makanan) {
            session()->flash(
                'makanan_error',
                'Data makanan tidak ditemukan.'
            );

            return;
        }

        if (! $this->canManageMakanan($makanan)) {
            session()->flash(
                'makanan_error',
                'Kamu tidak memiliki akses untuk menghapus makanan ini.'
            );

            return;
        }

        try {
            $makanan->delete();

            session()->flash(
                'makanan_success',
                'Data makanan berhasil dihapus.'
            );
        } catch (Throwable $exception) {
            report($exception);

            session()->flash(
                'makanan_error',
                'Data makanan tidak bisa dihapus karena masih digunakan pada meal plan atau data lain.'
            );
        }

        $this->resetPage();
    }

    public function cancelForm(): void
    {
        $this->resetForm();
    }

    /*
    |--------------------------------------------------------------------------
    | Tambah makanan langsung ke Meal Plan
    |--------------------------------------------------------------------------
    */

    public function openMealPlanForm(int $makananId): void
    {
        $makanan = Makanan::find($makananId);

        if (! $makanan instanceof Makanan) {
            session()->flash(
                'makanan_error',
                'Makanan yang dipilih tidak ditemukan.'
            );

            return;
        }

        if (! $this->canAccessMakanan($makanan)) {
            session()->flash(
                'makanan_error',
                'Kamu tidak memiliki akses ke makanan tersebut.'
            );

            return;
        }

        $this->resetValidation([
            'mealPlanMakananId',
            'mealPlanDate',
            'mealPlanMealTime',
            'mealPlanPorsi',
            'mealPlanCatatan',
        ]);

        $this->mealPlanMakananId = $makanan->id;
        $this->mealPlanDate = Carbon::today()->toDateString();
        $this->mealPlanMealTime = 'sarapan';
        $this->mealPlanPorsi = 1;
        $this->mealPlanCatatan = null;
        $this->showMealPlanForm = true;
    }

    public function closeMealPlanForm(): void
    {
        $this->resetValidation([
            'mealPlanMakananId',
            'mealPlanDate',
            'mealPlanMealTime',
            'mealPlanPorsi',
            'mealPlanCatatan',
        ]);

        $this->showMealPlanForm = false;
        $this->mealPlanMakananId = null;
        $this->mealPlanDate = Carbon::today()->toDateString();
        $this->mealPlanMealTime = 'sarapan';
        $this->mealPlanPorsi = 1;
        $this->mealPlanCatatan = null;
    }

    public function addMakananToMealPlan(): void
    {
        $validated = $this->validate([
            'mealPlanMakananId' => [
                'required',
                'integer',
            ],
            'mealPlanDate' => [
                'required',
                'date',
            ],
            'mealPlanMealTime' => [
                'required',
                'in:sarapan,makan_siang,makan_malam,cemilan',
            ],
            'mealPlanPorsi' => [
                'required',
                'numeric',
                'min:0.1',
                'max:100',
            ],
            'mealPlanCatatan' => [
                'nullable',
                'string',
                'max:500',
            ],
        ], [
            'mealPlanMakananId.required' => 'Makanan wajib dipilih.',
            'mealPlanDate.required' => 'Tanggal Meal Plan wajib dipilih.',
            'mealPlanDate.date' => 'Tanggal Meal Plan tidak valid.',
            'mealPlanMealTime.required' => 'Waktu makan wajib dipilih.',
            'mealPlanMealTime.in' => 'Waktu makan tidak valid.',
            'mealPlanPorsi.required' => 'Jumlah porsi wajib diisi.',
            'mealPlanPorsi.min' => 'Jumlah porsi minimal 0,1.',
            'mealPlanPorsi.max' => 'Jumlah porsi maksimal 100.',
            'mealPlanCatatan.max' => 'Catatan maksimal 500 karakter.',
        ]);

        $user = Auth::user();

        if (! $user instanceof User) {
            session()->flash(
                'makanan_error',
                'User tidak ditemukan. Silakan login ulang.'
            );

            return;
        }

        $makanan = Makanan::find(
            (int) $validated['mealPlanMakananId']
        );

        if (! $makanan instanceof Makanan) {
            session()->flash(
                'makanan_error',
                'Makanan yang dipilih tidak ditemukan.'
            );

            return;
        }

        if (! $this->canAccessMakanan($makanan)) {
            session()->flash(
                'makanan_error',
                'Kamu tidak memiliki akses ke makanan tersebut.'
            );

            return;
        }

        try {
            $mealPlan = $this->createOrGetMealPlan(
                user: $user,
                selectedDate: (string) $validated['mealPlanDate']
            );

            if (! $mealPlan instanceof MealPlan) {
                return;
            }

            $mealPlanItem = new MealPlanItem();
            $itemTable = $mealPlanItem->getTable();

            if (! Schema::hasTable($itemTable)) {
                session()->flash(
                    'makanan_error',
                    'Tabel item Meal Plan belum tersedia.'
                );

                return;
            }

            $mealPlanColumn = $this->firstExistingColumn(
                $itemTable,
                [
                    'meal_plan_id',
                ]
            );

            $makananColumn = $this->firstExistingColumn(
                $itemTable,
                [
                    'makanan_id',
                    'food_id',
                ]
            );

            if (! $mealPlanColumn || ! $makananColumn) {
                session()->flash(
                    'makanan_error',
                    'Kolom relasi Meal Plan belum sesuai.'
                );

                return;
            }

            $item = new MealPlanItem();

            $item->{$mealPlanColumn} = $mealPlan->id;
            $item->{$makananColumn} = $makanan->id;

            $mealTimeColumn = $this->firstExistingColumn(
                $itemTable,
                [
                    'waktu_makan',
                    'meal_time',
                    'jenis_waktu_makan',
                ]
            );

            if ($mealTimeColumn) {
                $item->{$mealTimeColumn} = $this->mealTimeValueForDatabase(
                    selectedMealTime: (string) $validated['mealPlanMealTime'],
                    column: $mealTimeColumn
                );
            }

            $portionColumn = $this->firstExistingColumn(
                $itemTable,
                [
                    'porsi',
                    'portion',
                    'jumlah_porsi',
                    'quantity',
                    'qty',
                ]
            );

            if ($portionColumn) {
                $item->{$portionColumn} = (float) $validated['mealPlanPorsi'];
            }

            if (Schema::hasColumn($itemTable, 'sudah_dikonsumsi')) {
                $item->sudah_dikonsumsi = false;
            }

            if (Schema::hasColumn($itemTable, 'dikonsumsi_pada')) {
                $item->dikonsumsi_pada = null;
            }

            if (Schema::hasColumn($itemTable, 'is_consumed')) {
                $item->is_consumed = false;
            }

            if (Schema::hasColumn($itemTable, 'consumed')) {
                $item->consumed = false;
            }

            if (Schema::hasColumn($itemTable, 'sudah_dimakan')) {
                $item->sudah_dimakan = false;
            }

            if (Schema::hasColumn($itemTable, 'status')) {
                $item->status = 'planned';
            }

            foreach ([
                'catatan',
                'notes',
                'note',
            ] as $noteColumn) {
                if (Schema::hasColumn($itemTable, $noteColumn)) {
                    $item->{$noteColumn} = $validated['mealPlanCatatan'] ?? null;
                }
            }

            $item->save();

            $mealTimeLabel = $this->mealTimeOptions[
                $validated['mealPlanMealTime']
            ] ?? 'Waktu makan';

            session()->flash(
                'makanan_success',
                sprintf(
                    '%s berhasil ditambahkan ke Meal Plan %s pada %s.',
                    $this->getMakananName($makanan),
                    Carbon::parse($validated['mealPlanDate'])
                        ->translatedFormat('d F Y'),
                    $mealTimeLabel
                )
            );

            $this->closeMealPlanForm();
        } catch (Throwable $exception) {
            report($exception);

            session()->flash(
                'makanan_error',
                'Makanan gagal ditambahkan ke Meal Plan. Periksa kembali data yang dipilih.'
            );
        }
    }

    private function createOrGetMealPlan(
        User $user,
        string $selectedDate
    ): ?MealPlan {
        $mealPlanModel = new MealPlan();
        $table = $mealPlanModel->getTable();

        if (! Schema::hasTable($table)) {
            session()->flash(
                'makanan_error',
                'Tabel Meal Plan belum tersedia.'
            );

            return null;
        }

        $userColumn = $this->firstExistingColumn(
            $table,
            [
                'user_id',
            ]
        );

        $dateColumn = $this->firstExistingColumn(
            $table,
            [
                'tanggal_rencana',
                'tanggal',
                'date',
                'plan_date',
                'meal_date',
            ]
        );

        if (! $userColumn || ! $dateColumn) {
            session()->flash(
                'makanan_error',
                'Kolom user atau tanggal Meal Plan belum sesuai.'
            );

            return null;
        }

        $date = Carbon::parse($selectedDate)->toDateString();

        $existingPlan = MealPlan::query()
            ->where($userColumn, $user->id)
            ->whereDate($dateColumn, $date)
            ->first();

        if ($existingPlan instanceof MealPlan) {
            return $existingPlan;
        }

        $mealPlan = new MealPlan();

        $mealPlan->{$userColumn} = $user->id;
        $mealPlan->{$dateColumn} = $date;

        $title = 'Meal Plan '
            . Carbon::parse($date)->translatedFormat('d F Y');

        foreach ([
            'judul',
            'title',
            'nama',
        ] as $titleColumn) {
            if (Schema::hasColumn($table, $titleColumn)) {
                $mealPlan->{$titleColumn} = $title;
            }
        }

        if (Schema::hasColumn($table, 'catatan')) {
            $mealPlan->catatan = 'Meal Plan dibuat dari koleksi makanan.';
        }

        if (Schema::hasColumn($table, 'notes')) {
            $mealPlan->notes = 'Meal Plan dibuat dari koleksi makanan.';
        }

        if (Schema::hasColumn($table, 'status')) {
            $mealPlan->status = 'aktif';
        }

        $mealPlan->save();

        return $mealPlan;
    }

    private function mealTimeValueForDatabase(
        string $selectedMealTime,
        string $column
    ): string {
        if ($column === 'meal_time') {
            return match ($selectedMealTime) {
                'sarapan' => 'breakfast',
                'makan_siang' => 'lunch',
                'makan_malam' => 'dinner',
                'cemilan' => 'snack',
                default => 'breakfast',
            };
        }

        return $selectedMealTime;
    }

    /*
    |--------------------------------------------------------------------------
    | Reset dan pengisian data makanan
    |--------------------------------------------------------------------------
    */

    private function resetForm(): void
    {
        $this->resetValidation();

        $this->editingId = null;
        $this->showForm = false;
        $this->kategori_makanan_id = null;
        $this->nama = '';
        $this->deskripsi = null;
        $this->kalori = null;
        $this->protein = null;
        $this->karbohidrat = null;
        $this->lemak = null;
        $this->porsi = 1;
        $this->satuan = 'porsi';
        $this->is_public = false;
        $this->is_recommended = false;
        $this->recommended_note = null;
    }

    private function fillMakananData(
        Makanan $makanan,
        array $validated
    ): void {
        $table = $makanan->getTable();

        $categoryColumn = $this->firstExistingColumn(
            $table,
            [
                'kategori_makanan_id',
                'kategori_id',
                'category_id',
            ]
        );

        if ($categoryColumn) {
            $makanan->{$categoryColumn} =
                $validated['kategori_makanan_id'] ?: null;
        }

        $nameColumn = $this->firstExistingColumn(
            $table,
            [
                'nama',
                'name',
                'nama_makanan',
                'title',
            ]
        );

        if ($nameColumn) {
            $makanan->{$nameColumn} = $validated['nama'];
        }

        $descriptionColumn = $this->firstExistingColumn(
            $table,
            [
                'deskripsi',
                'description',
                'catatan',
                'note',
            ]
        );

        if ($descriptionColumn) {
            $makanan->{$descriptionColumn} =
                $validated['deskripsi'] ?? null;
        }

        $calorieColumn = $this->firstExistingColumn(
            $table,
            [
                'kalori',
                'calories',
                'calorie',
                'kalori_per_porsi',
                'total_calories',
            ]
        );

        if ($calorieColumn) {
            $makanan->{$calorieColumn} = (int) round(
                (float) $validated['kalori']
            );
        }

        $proteinColumn = $this->firstExistingColumn(
            $table,
            [
                'protein',
                'protein_gram',
                'protein_g',
            ]
        );

        if ($proteinColumn) {
            $makanan->{$proteinColumn} =
                (float) ($validated['protein'] ?? 0);
        }

        $carbColumn = $this->firstExistingColumn(
            $table,
            [
                'karbohidrat',
                'karbo',
                'carbohydrate',
                'carbs',
                'carb',
            ]
        );

        if ($carbColumn) {
            $makanan->{$carbColumn} =
                (float) ($validated['karbohidrat'] ?? 0);
        }

        $fatColumn = $this->firstExistingColumn(
            $table,
            [
                'lemak',
                'fat',
                'fat_gram',
                'fat_g',
            ]
        );

        if ($fatColumn) {
            $makanan->{$fatColumn} =
                (float) ($validated['lemak'] ?? 0);
        }

        $portionColumn = $this->firstExistingColumn(
            $table,
            [
                'porsi',
                'portion',
                'jumlah_porsi',
                'quantity',
                'qty',
            ]
        );

        if ($portionColumn) {
            $makanan->{$portionColumn} =
                (float) $validated['porsi'];
        }

        $unitColumn = $this->firstExistingColumn(
            $table,
            [
                'satuan',
                'unit',
            ]
        );

        if ($unitColumn) {
            $makanan->{$unitColumn} = $validated['satuan'];
        }

        if (Schema::hasColumn($table, 'is_public')) {
            $makanan->is_public =
                (bool) $validated['is_public'];
        }

        if (Schema::hasColumn($table, 'is_recommended')) {
            $makanan->is_recommended =
                (bool) $validated['is_recommended'];
        }

        if (Schema::hasColumn($table, 'recommended_note')) {
            $makanan->recommended_note =
                $validated['recommended_note'] ?? null;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Query dan formatter
    |--------------------------------------------------------------------------
    */

    private function getMakananPaginator(): LengthAwarePaginator
    {
        $makananModel = new Makanan();
        $table = $makananModel->getTable();

        if (! Schema::hasTable($table)) {
            return new LengthAwarePaginator(
                [],
                0,
                6
            );
        }

        $query = Makanan::query();

        $userId = Auth::id();

        if (Schema::hasColumn($table, 'user_id')) {
            $query->where(function ($subQuery) use (
                $table,
                $userId
            ) {
                $subQuery->where(
                    'user_id',
                    $userId
                );

                if (Schema::hasColumn($table, 'is_public')) {
                    $subQuery->orWhere(
                        'is_public',
                        true
                    );
                }
            });
        }

        if (trim($this->search) !== '') {
            $search = '%' . trim($this->search) . '%';

            $query->where(function ($subQuery) use (
                $table,
                $search
            ) {
                foreach ([
                    'nama',
                    'name',
                    'nama_makanan',
                    'title',
                    'deskripsi',
                    'description',
                    'catatan',
                    'note',
                    'recommended_note',
                ] as $column) {
                    if (Schema::hasColumn($table, $column)) {
                        $subQuery->orWhere(
                            $column,
                            'like',
                            $search
                        );
                    }
                }
            });
        }

        $categoryColumn = $this->firstExistingColumn(
            $table,
            [
                'kategori_makanan_id',
                'kategori_id',
                'category_id',
            ]
        );

        if (
            $categoryColumn
            && $this->kategoriFilter !== ''
        ) {
            $query->where(
                $categoryColumn,
                $this->kategoriFilter
            );
        }

        if (
            $this->visibilityFilter === 'mine'
            && Schema::hasColumn($table, 'user_id')
        ) {
            $query->where(
                'user_id',
                $userId
            );
        }

        if (
            $this->visibilityFilter === 'public'
            && Schema::hasColumn($table, 'is_public')
        ) {
            $query->where(
                'is_public',
                true
            );
        }

        if (
            $this->visibilityFilter === 'recommended'
            && Schema::hasColumn($table, 'is_recommended')
        ) {
            $query->where(
                'is_recommended',
                true
            );
        }

        if (Schema::hasColumn($table, 'created_at')) {
            $query->latest();
        } else {
            $query->orderByDesc('id');
        }

        return $query
            ->paginate(6)
            ->through(
                fn (Makanan $makanan): array =>
                    $this->formatMakanan($makanan)
            );
    }

    private function getKategoriOptions(): array
    {
        if (! class_exists(KategoriMakanan::class)) {
            return [];
        }

        $kategoriModel = new KategoriMakanan();
        $table = $kategoriModel->getTable();

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
                ) use ($nameColumn) {
                    $label = $nameColumn
                        ? $kategori->getAttribute($nameColumn)
                        : 'Kategori #' . $kategori->id;

                    return [
                        $kategori->id => $label,
                    ];
                }
            )
            ->toArray();
    }

    private function formatMakanan(Makanan $makanan): array
    {
        $table = $makanan->getTable();

        $categoryId = $this->getAttributeValue(
            $makanan,
            [
                'kategori_makanan_id',
                'kategori_id',
                'category_id',
            ]
        );

        $categoryLabel = $categoryId
            ? $this->resolveKategoriLabel(
                (int) $categoryId
            )
            : 'Tanpa kategori';

        $name = $this->getMakananName($makanan);

        $description = (string) (
            $this->getAttributeValue(
                $makanan,
                [
                    'deskripsi',
                    'description',
                    'catatan',
                    'note',
                ]
            ) ?? ''
        );

        $kalori = (int) round(
            (float) (
                $this->getAttributeValue(
                    $makanan,
                    [
                        'kalori',
                        'calories',
                        'calorie',
                        'kalori_per_porsi',
                        'total_calories',
                    ]
                ) ?? 0
            )
        );

        $protein = (float) (
            $this->getAttributeValue(
                $makanan,
                [
                    'protein',
                    'protein_gram',
                    'protein_g',
                ]
            ) ?? 0
        );

        $karbohidrat = (float) (
            $this->getAttributeValue(
                $makanan,
                [
                    'karbohidrat',
                    'karbo',
                    'carbohydrate',
                    'carbs',
                    'carb',
                ]
            ) ?? 0
        );

        $lemak = (float) (
            $this->getAttributeValue(
                $makanan,
                [
                    'lemak',
                    'fat',
                    'fat_gram',
                    'fat_g',
                ]
            ) ?? 0
        );

        $porsi = (float) (
            $this->getAttributeValue(
                $makanan,
                [
                    'porsi',
                    'portion',
                    'jumlah_porsi',
                    'quantity',
                    'qty',
                ]
            ) ?? 1
        );

        $satuan = (string) (
            $this->getAttributeValue(
                $makanan,
                [
                    'satuan',
                    'unit',
                ]
            ) ?? 'porsi'
        );

        $ownerId = Schema::hasColumn(
            $table,
            'user_id'
        )
            ? (int) ($makanan->user_id ?? 0)
            : (int) Auth::id();

        return [
            'id' => $makanan->id,
            'nama' => $name,
            'deskripsi' => $description,
            'kategori' => $categoryLabel,
            'kalori' => $kalori,
            'protein' => $protein,
            'karbohidrat' => $karbohidrat,
            'lemak' => $lemak,
            'porsi' => $porsi,
            'satuan' => $satuan,
            'is_public' => Schema::hasColumn(
                $table,
                'is_public'
            )
                ? (bool) $makanan->is_public
                : false,
            'is_recommended' => Schema::hasColumn(
                $table,
                'is_recommended'
            )
                ? (bool) $makanan->is_recommended
                : false,
            'recommended_note' => Schema::hasColumn(
                $table,
                'recommended_note'
            )
                ? $makanan->recommended_note
                : null,
            'is_owner' =>
                $ownerId === (int) Auth::id(),
        ];
    }

    private function getSelectedMealPlanMakanan(): ?array
    {
        if (! $this->mealPlanMakananId) {
            return null;
        }

        $makanan = Makanan::find(
            $this->mealPlanMakananId
        );

        if (! $makanan instanceof Makanan) {
            return null;
        }

        return $this->formatMakanan($makanan);
    }

    private function getMakananName(
        Makanan $makanan
    ): string {
        return (string) (
            $this->getAttributeValue(
                $makanan,
                [
                    'nama',
                    'name',
                    'nama_makanan',
                    'title',
                ]
            ) ?? 'Makanan tanpa nama'
        );
    }

    private function resolveKategoriLabel(
        int $categoryId
    ): string {
        if (! class_exists(KategoriMakanan::class)) {
            return 'Kategori #' . $categoryId;
        }

        $kategoriModel = new KategoriMakanan();
        $table = $kategoriModel->getTable();

        if (! Schema::hasTable($table)) {
            return 'Kategori #' . $categoryId;
        }

        $kategori = KategoriMakanan::find(
            $categoryId
        );

        if (! $kategori instanceof KategoriMakanan) {
            return 'Tanpa kategori';
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

        if (! $nameColumn) {
            return 'Kategori #' . $categoryId;
        }

        return (string) $kategori->getAttribute(
            $nameColumn
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Akses dan helper
    |--------------------------------------------------------------------------
    */

    private function canManageMakanan(
        Makanan $makanan
    ): bool {
        $table = $makanan->getTable();

        if (! Schema::hasColumn($table, 'user_id')) {
            return true;
        }

        return (int) $makanan->user_id
            === (int) Auth::id();
    }

    private function canAccessMakanan(
        Makanan $makanan
    ): bool {
        $table = $makanan->getTable();

        if (! Schema::hasColumn($table, 'user_id')) {
            return true;
        }

        if (
            (int) $makanan->user_id
            === (int) Auth::id()
        ) {
            return true;
        }

        if (Schema::hasColumn($table, 'is_public')) {
            return (bool) $makanan->is_public;
        }

        return false;
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
            if (Schema::hasColumn($table, $column)) {
                return $column;
            }
        }

        return null;
    }

    public function render(): View
    {
        return view(
            'livewire.user.makanan-saya',
            [
                'makanans' =>
                    $this->getMakananPaginator(),
                'kategoriOptions' =>
                    $this->getKategoriOptions(),
                'selectedMealPlanMakanan' =>
                    $this->getSelectedMealPlanMakanan(),
            ]
        );
    }
}