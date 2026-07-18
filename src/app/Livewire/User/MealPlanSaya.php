<?php

namespace App\Livewire\User;

use App\Models\Makanan;
use App\Models\MealPlan;
use App\Models\MealPlanItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Throwable;

#[Layout('layouts.user')]
class MealPlanSaya extends Component
{
    public string $selectedDate = '';

    public string $selectedMealTime = 'sarapan';

    public $selectedMakananId = '';

    public $selectedPorsi = 1;

    public ?string $selectedCatatan = null;

    public string $makananSearch = '';

    public array $mealTimeOptions = [
        'sarapan' => 'Sarapan',
        'makan_siang' => 'Makan Siang',
        'makan_malam' => 'Makan Malam',
        'snack' => 'Cemilan',
    ];

    public function mount(): void
    {
        if (! Auth::check()) {
            abort(403);
        }

        $this->selectedDate = Carbon::today()->toDateString();
    }

    public function previousDate(): void
    {
        $this->selectedDate = Carbon::parse($this->selectedDate)
            ->subDay()
            ->toDateString();
    }

    public function nextDate(): void
    {
        $this->selectedDate = Carbon::parse($this->selectedDate)
            ->addDay()
            ->toDateString();
    }

    public function todayDate(): void
    {
        $this->selectedDate = Carbon::today()->toDateString();
    }

    public function createMealPlan(): void
    {
        $mealPlan = $this->createOrGetMealPlan();

        if (! $mealPlan instanceof MealPlan) {
            return;
        }

        session()->flash('meal_plan_success', 'Meal plan untuk tanggal ini berhasil disiapkan.');
    }

    public function addMealPlanItem(): void
    {

        // snack-normalization
        $this->selectedMealTime = match (
            (string) $this->selectedMealTime
        ) {
            'snack',
            'camilan',
            'cemilan' => 'snack',

            default => (string) $this->selectedMealTime,
        };


        $validated = $this->validate(
            [
                'selectedMakananId' => [
                    'required',
                ],

                'selectedMealTime' => [
                    'required',
                    'in:sarapan,makan_siang,makan_malam,snack',
                ],

                'selectedPorsi' => [
                    'required',
                    'numeric',
                    'min:0.1',
                ],

                'selectedCatatan' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],
            ],
            [
                'selectedMakananId.required' =>
                    'Pilih makanan terlebih dahulu.',

                'selectedMealTime.required' =>
                    'Pilih waktu makan terlebih dahulu.',

                'selectedMealTime.in' =>
                    'Waktu makan yang dipilih tidak valid.',

                'selectedPorsi.required' =>
                    'Jumlah porsi wajib diisi.',

                'selectedPorsi.numeric' =>
                    'Jumlah porsi harus berupa angka.',

                'selectedPorsi.min' =>
                    'Jumlah porsi minimal 0,1.',
            ]
        );

        $user = Auth::user();

        if (! $user instanceof User) {
            session()->flash('meal_plan_error', 'User tidak ditemukan. Silakan login ulang.');
            return;
        }

        $makanan = Makanan::find((int) $validated['selectedMakananId']);

        if (! $makanan instanceof Makanan) {
            session()->flash('meal_plan_error', 'Makanan tidak ditemukan.');
            return;
        }

        if (! $this->canAccessMakanan($makanan)) {
            session()->flash('meal_plan_error', 'Kamu tidak memiliki akses ke makanan ini.');
            return;
        }

        $mealPlan = $this->createOrGetMealPlan();

        if (! $mealPlan instanceof MealPlan) {
            return;
        }

        $mealPlanItem = new MealPlanItem();
        $mealPlanItemTable = $mealPlanItem->getTable();

        if (! Schema::hasTable($mealPlanItemTable)) {
            session()->flash('meal_plan_error', 'Tabel item meal plan belum tersedia.');
            return;
        }

        $mealPlanItemForeignKey = $this->firstExistingColumn($mealPlanItemTable, [
            'meal_plan_id',
        ]);

        $makananForeignKey = $this->firstExistingColumn($mealPlanItemTable, [
            'makanan_id',
            'food_id',
        ]);

        if (! $mealPlanItemForeignKey || ! $makananForeignKey) {
            session()->flash('meal_plan_error', 'Kolom relasi meal plan item belum sesuai.');
            return;
        }

        $item = new MealPlanItem();
        $item->{$mealPlanItemForeignKey} = $mealPlan->id;
        $item->{$makananForeignKey} = $makanan->id;

        $mealTimeColumn = $this->firstExistingColumn($mealPlanItemTable, [
            'waktu_makan',
            'meal_time',
            'jenis_waktu_makan',
        ]);

        if ($mealTimeColumn) {
            $item->{$mealTimeColumn} = $this->mealTimeValueForDatabase(
                selectedMealTime: (string) $validated['selectedMealTime'],
                mealTimeColumn: $mealTimeColumn
            );
        }

        $portionColumn = $this->firstExistingColumn($mealPlanItemTable, [
            'porsi',
            'portion',
            'jumlah_porsi',
            'quantity',
            'qty',
        ]);

        if ($portionColumn) {
            $item->{$portionColumn} = (float) $validated['selectedPorsi'];
        }

        if (Schema::hasColumn($mealPlanItemTable, 'is_consumed')) {
            $item->is_consumed = false;
        }

        if (Schema::hasColumn($mealPlanItemTable, 'consumed')) {
            $item->consumed = false;
        }

        if (Schema::hasColumn($mealPlanItemTable, 'sudah_dimakan')) {
            $item->sudah_dimakan = false;
        }

        if (Schema::hasColumn($mealPlanItemTable, 'sudah_dikonsumsi')) {
            $item->sudah_dikonsumsi = false;
        }

        if (Schema::hasColumn($mealPlanItemTable, 'dikonsumsi_pada')) {
            $item->dikonsumsi_pada = null;
        }

        if (Schema::hasColumn($mealPlanItemTable, 'dikonsumsi')) {
            $item->dikonsumsi = false;
        }

        if (Schema::hasColumn($mealPlanItemTable, 'status')) {
            $item->status = 'planned';
        }

        if (Schema::hasColumn($mealPlanItemTable, 'catatan')) {
            $item->catatan = $validated['selectedCatatan'] ?? null;
        }

        if (Schema::hasColumn($mealPlanItemTable, 'notes')) {
            $item->notes = $validated['selectedCatatan'] ?? null;
        }

        if (Schema::hasColumn($mealPlanItemTable, 'note')) {
            $item->note = $validated['selectedCatatan'] ?? null;
        }

        $item->save();

        $this->selectedMakananId = '';
        $this->selectedPorsi = 1;
        $this->selectedCatatan = null;

        session()->flash('meal_plan_success', 'Makanan berhasil ditambahkan ke meal plan.');
    }

    public function toggleConsumed(int $itemId): void
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            session()->flash('meal_plan_error', 'User tidak ditemukan. Silakan login ulang.');
            return;
        }

        $item = MealPlanItem::find($itemId);

        if (! $item instanceof MealPlanItem) {
            session()->flash('meal_plan_error', 'Item meal plan tidak ditemukan.');
            return;
        }

        if (! $this->canManageMealPlanItem($item)) {
            session()->flash('meal_plan_error', 'Kamu tidak memiliki akses ke item meal plan ini.');
            return;
        }

        $table = $item->getTable();

        $currentStatus = $this->getAttributeValue($item, [
            'sudah_dikonsumsi',
            'is_consumed',
            'consumed',
            'sudah_dimakan',
            'dikonsumsi',
            'status',
        ]);

        $isConsumed = $this->isMealPlanItemConsumed($currentStatus);

        if (Schema::hasColumn($table, 'is_consumed')) {
            $item->is_consumed = ! $isConsumed;
        }

        if (Schema::hasColumn($table, 'consumed')) {
            $item->consumed = ! $isConsumed;
        }

        if (Schema::hasColumn($table, 'sudah_dimakan')) {
            $item->sudah_dimakan = ! $isConsumed;
        }

        if (Schema::hasColumn($table, 'sudah_dikonsumsi')) {
            $item->sudah_dikonsumsi = ! $isConsumed;
        }

        if (Schema::hasColumn($table, 'dikonsumsi_pada')) {
            $item->dikonsumsi_pada = (! $isConsumed) ? now() : null;
        }

        if (Schema::hasColumn($table, 'dikonsumsi')) {
            $item->dikonsumsi = ! $isConsumed;
        }

        if (Schema::hasColumn($table, 'status')) {
            $item->status = $isConsumed ? 'planned' : 'consumed';
        }

        $item->save();

        session()->flash(
            'meal_plan_success',
            $isConsumed
                ? 'Menu berhasil ditandai belum dikonsumsi.'
                : 'Menu berhasil ditandai sudah dikonsumsi.'
        );
    }

    public function deleteItem(int $itemId): void
    {
        $item = MealPlanItem::find($itemId);

        if (! $item instanceof MealPlanItem) {
            session()->flash('meal_plan_error', 'Item meal plan tidak ditemukan.');
            return;
        }

        if (! $this->canManageMealPlanItem($item)) {
            session()->flash('meal_plan_error', 'Kamu tidak memiliki akses untuk menghapus item ini.');
            return;
        }

        try {
            $item->delete();

            session()->flash('meal_plan_success', 'Item meal plan berhasil dihapus.');
        } catch (Throwable) {
            session()->flash('meal_plan_error', 'Item meal plan tidak bisa dihapus.');
        }
    }

    public function deleteMealPlan(): void
    {
        $plans = $this->getMealPlansForSelectedDate();

        if ($plans->isEmpty()) {
            session()->flash('meal_plan_error', 'Meal plan pada tanggal ini belum ada.');
            return;
        }

        $mealPlanItem = new MealPlanItem();
        $mealPlanItemTable = $mealPlanItem->getTable();

        $foreignKey = Schema::hasTable($mealPlanItemTable)
            ? $this->firstExistingColumn($mealPlanItemTable, ['meal_plan_id'])
            : null;

        try {
            if ($foreignKey) {
                MealPlanItem::query()
                    ->whereIn($foreignKey, $plans->pluck('id')->toArray())
                    ->delete();
            }

            foreach ($plans as $plan) {
                if ($plan instanceof MealPlan) {
                    $plan->delete();
                }
            }

            session()->flash('meal_plan_success', 'Meal plan tanggal ini berhasil dihapus.');
        } catch (Throwable) {
            session()->flash('meal_plan_error', 'Meal plan tidak bisa dihapus.');
        }
    }

    private function createOrGetMealPlan(): ?MealPlan
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            session()->flash('meal_plan_error', 'User tidak ditemukan. Silakan login ulang.');
            return null;
        }

        $mealPlan = new MealPlan();
        $mealPlanTable = $mealPlan->getTable();

        if (! Schema::hasTable($mealPlanTable)) {
            session()->flash('meal_plan_error', 'Tabel meal plan belum tersedia.');
            return null;
        }

        $userColumn = $this->firstExistingColumn($mealPlanTable, [
            'user_id',
        ]);

        $dateColumn = $this->firstExistingColumn($mealPlanTable, [
            'tanggal_rencana',
            'tanggal',
            'date',
            'plan_date',
            'meal_date',
        ]);

        if (! $userColumn || ! $dateColumn) {
            session()->flash('meal_plan_error', 'Kolom user atau tanggal pada tabel meal plan belum sesuai.');
            return null;
        }

        $selectedDate = Carbon::parse($this->selectedDate)->toDateString();

        $existingPlan = MealPlan::query()
            ->where($userColumn, $user->id)
            ->whereDate($dateColumn, $selectedDate)
            ->first();

        if ($existingPlan instanceof MealPlan) {
            return $existingPlan;
        }

        $newPlan = new MealPlan();
        $newPlan->{$userColumn} = $user->id;
        $newPlan->{$dateColumn} = $selectedDate;

        if (Schema::hasColumn($mealPlanTable, 'judul')) {
            $newPlan->judul = 'Meal Plan ' . Carbon::parse($selectedDate)->translatedFormat('d F Y');
        }

        if (Schema::hasColumn($mealPlanTable, 'title')) {
            $newPlan->title = 'Meal Plan ' . Carbon::parse($selectedDate)->translatedFormat('d F Y');
        }

        if (Schema::hasColumn($mealPlanTable, 'nama')) {
            $newPlan->nama = 'Meal Plan ' . Carbon::parse($selectedDate)->translatedFormat('d F Y');
        }

        if (Schema::hasColumn($mealPlanTable, 'catatan')) {
            $newPlan->catatan = 'Meal plan dibuat dari halaman user.';
        }

        if (Schema::hasColumn($mealPlanTable, 'notes')) {
            $newPlan->notes = 'Meal plan dibuat dari halaman user.';
        }

        if (Schema::hasColumn($mealPlanTable, 'status')) {
            $newPlan->status = 'aktif';
        }

        $newPlan->save();

        return $newPlan;
    }

    private function getMealPlansForSelectedDate(): Collection
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            return collect();
        }

        $mealPlan = new MealPlan();
        $table = $mealPlan->getTable();

        if (! Schema::hasTable($table)) {
            return collect();
        }

        $userColumn = $this->firstExistingColumn($table, [
            'user_id',
        ]);

        $dateColumn = $this->firstExistingColumn($table, [
            'tanggal_rencana',
            'tanggal',
            'date',
            'plan_date',
            'meal_date',
        ]);

        if (! $userColumn || ! $dateColumn) {
            return collect();
        }

        return MealPlan::query()
            ->where($userColumn, $user->id)
            ->whereDate($dateColumn, Carbon::parse($this->selectedDate)->toDateString())
            ->get();
    }

    private function getMealPlanItemsForSelectedDate(): Collection
    {
        $plans = $this->getMealPlansForSelectedDate();

        if ($plans->isEmpty()) {
            return collect();
        }

        $mealPlanItem = new MealPlanItem();
        $table = $mealPlanItem->getTable();

        if (! Schema::hasTable($table)) {
            return collect();
        }

        $foreignKey = $this->firstExistingColumn($table, [
            'meal_plan_id',
        ]);

        if (! $foreignKey) {
            return collect();
        }

        return MealPlanItem::query()
            ->whereIn($foreignKey, $plans->pluck('id')->toArray())
            ->get();
    }

    private function getFormattedMealPlanItems(): array
    {
        $items = $this->getMealPlanItemsForSelectedDate();

        $formattedItems = [];

        foreach ($items as $item) {
            if (! $item instanceof MealPlanItem) {
                continue;
            }

            $makanan = $this->resolveMakananFromMealPlanItem($item);

            if (! $makanan instanceof Makanan) {
                continue;
            }

            $porsi = (float) ($this->getAttributeValue($item, [
                'porsi',
                'portion',
                'jumlah_porsi',
                'quantity',
                'qty',
            ]) ?? 1);

            if ($porsi <= 0) {
                $porsi = 1;
            }

            $kalori = (float) ($this->getAttributeValue($makanan, [
                'kalori',
                'calories',
                'calorie',
                'kalori_per_porsi',
                'total_calories',
            ]) ?? 0);

            $protein = (float) ($this->getAttributeValue($makanan, [
                'protein',
                'protein_gram',
                'protein_g',
            ]) ?? 0);

            $karbohidrat = (float) ($this->getAttributeValue($makanan, [
                'karbohidrat',
                'karbo',
                'carbohydrate',
                'carbs',
                'carb',
            ]) ?? 0);

            $lemak = (float) ($this->getAttributeValue($makanan, [
                'lemak',
                'fat',
                'fat_gram',
                'fat_g',
            ]) ?? 0);

            $mealTimeRaw = (string) ($this->getAttributeValue($item, [
                'waktu_makan',
                'meal_time',
                'jenis_waktu_makan',
            ]) ?? 'sarapan');

            $mealTimeKey = $this->normalizeMealTimeKey($mealTimeRaw);

            $status = $this->getAttributeValue($item, [
                'sudah_dikonsumsi',
                'is_consumed',
                'consumed',
                'sudah_dimakan',
                'dikonsumsi',
                'status',
            ]);

            $catatan = $this->getAttributeValue($item, [
                'catatan',
                'notes',
                'note',
            ]);

            $namaMakanan = (string) ($this->getAttributeValue($makanan, [
                'nama',
                'name',
                'nama_makanan',
                'title',
            ]) ?? 'Menu tanpa nama');

            $formattedItems[] = [
                'id' => $item->id,
                'meal_time_key' => $mealTimeKey,
                'meal_time_label' => $this->formatMealTime($mealTimeKey),
                'nama' => $namaMakanan,
                'porsi' => $porsi,
                'kalori' => $kalori,
                'protein' => $protein,
                'karbohidrat' => $karbohidrat,
                'lemak' => $lemak,
                'total_kalori' => (int) round($kalori * $porsi),
                'total_protein' => $protein * $porsi,
                'total_karbohidrat' => $karbohidrat * $porsi,
                'total_lemak' => $lemak * $porsi,
                'is_consumed' => $this->isMealPlanItemConsumed($status),
                'catatan' => $catatan,
            ];
        }

        return $formattedItems;
    }

    private function getGroupedItems(array $items): array
    {
        $groups = [];

        foreach ($this->mealTimeOptions as $key => $label) {
            $groups[$key] = [
                'key' => $key,
                'label' => $label,
                'icon' => $this->mealTimeIcon($key),
                'items' => [],
                'total_kalori' => 0,
            ];
        }

        foreach ($items as $item) {
            $key = $item['meal_time_key'] ?? 'sarapan';

            if (! isset($groups[$key])) {
                $key = 'sarapan';
            }

            $groups[$key]['items'][] = $item;
            $groups[$key]['total_kalori'] += (int) ($item['total_kalori'] ?? 0);
        }

        return $groups;
    }

    private function getTargetKaloriHarian(): int
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            return 0;
        }

        /*
         * Gunakan nilai target yang telah tersimpan apabila
         * tersedia pada data pengguna.
         */
        $storedTarget = (float) (
            $this->getAttributeValue(
                $user,
                [
                    'kebutuhan_kalori_harian',
                    'kebutuhan_kalori',
                    'target_kalori',
                    'kalori_harian',
                    'daily_calorie_target',
                    'daily_calories',
                ]
            ) ?? 0
        );

        if ($storedTarget > 0) {
            return (int) round($storedTarget);
        }

        /*
         * Apabila target belum tersimpan, hitung menggunakan
         * rumus Harris-Benedict berdasarkan data tubuh.
         */
        $gender = mb_strtolower(
            trim(
                (string) (
                    $this->getAttributeValue(
                        $user,
                        [
                            'gender',
                            'jenis_kelamin',
                            'sex',
                        ]
                    ) ?? ''
                )
            )
        );

        $usia = (float) (
            $this->getAttributeValue(
                $user,
                [
                    'usia',
                    'umur',
                    'age',
                ]
            ) ?? 0
        );

        $tinggi = (float) (
            $this->getAttributeValue(
                $user,
                [
                    'tinggi_badan',
                    'tinggi',
                    'height',
                ]
            ) ?? 0
        );

        $berat = (float) (
            $this->getAttributeValue(
                $user,
                [
                    'berat_badan',
                    'berat',
                    'weight',
                ]
            ) ?? 0
        );

        $aktivitasRaw = $this->getAttributeValue(
            $user,
            [
                'tingkat_aktivitas',
                'aktivitas',
                'activity_level',
                'activity',
            ]
        );

        if (
            $gender === ''
            || $usia <= 0
            || $tinggi <= 0
            || $berat <= 0
        ) {
            return 0;
        }

        $isFemale = in_array(
            $gender,
            [
                'female',
                'perempuan',
                'wanita',
                'p',
            ],
            true
        );

        $bmr = $isFemale
            ? 447.6
                + (9.25 * $berat)
                + (3.10 * $tinggi)
                - (4.33 * $usia)
            : 88.4
                + (13.4 * $berat)
                + (4.8 * $tinggi)
                - (5.68 * $usia);

        $faktorAktivitas =
            $this->resolveFaktorAktivitas(
                $aktivitasRaw
            );

        return (int) round(
            max(
                0,
                $bmr * $faktorAktivitas
            )
        );
    }

    private function resolveFaktorAktivitas(
        mixed $aktivitas
    ): float {
        if (
            is_numeric($aktivitas)
            && (float) $aktivitas >= 1
        ) {
            return (float) $aktivitas;
        }

        $value = mb_strtolower(
            trim((string) $aktivitas)
        );

        $value = str_replace(
            [
                ' ',
                '-',
            ],
            '_',
            $value
        );

        return match ($value) {
            'ringan',
            'light',
            'lightly_active',
            'aktivitas_ringan' => 1.375,

            'sedang',
            'moderate',
            'moderately_active',
            'aktivitas_sedang' => 1.55,

            'berat',
            'aktif',
            'active',
            'very_active',
            'aktivitas_berat' => 1.725,

            'sangat_berat',
            'sangat_aktif',
            'extra_active',
            'extremely_active' => 1.9,

            default => 1.2,
        };
    }

    private function getSummary(array $items): array
    {
        $totalKalori = collect($items)
            ->sum('total_kalori');

        $totalProtein = collect($items)
            ->sum('total_protein');

        $totalKarbohidrat = collect($items)
            ->sum('total_karbohidrat');

        $totalLemak = collect($items)
            ->sum('total_lemak');

        $consumedKalori = collect($items)
            ->where('is_consumed', true)
            ->sum('total_kalori');

        $totalKalori = (int) round($totalKalori);

        $targetKalori =
            $this->getTargetKaloriHarian();

        $selisihKalori =
            $targetKalori - $totalKalori;

        $sisaKalori = max(
            0,
            $selisihKalori
        );

        $kelebihanKalori = max(
            0,
            -$selisihKalori
        );

        $persentaseRencana =
            $targetKalori > 0
                ? (int) round(
                    ($totalKalori / $targetKalori)
                    * 100
                )
                : 0;

        if ($targetKalori <= 0) {
            $statusRencana =
                'belum_tersedia';
        } elseif ($selisihKalori > 0) {
            $statusRencana = 'kurang';
        } elseif ($selisihKalori < 0) {
            $statusRencana = 'lebih';
        } else {
            $statusRencana = 'sesuai';
        }

        return [
            'jumlah_menu' =>
                count($items),

            'total_kalori' =>
                $totalKalori,

            'target_kalori' =>
                $targetKalori,

            'sisa_kalori_rencana' =>
                $sisaKalori,

            'kelebihan_kalori_rencana' =>
                $kelebihanKalori,

            'persentase_rencana' =>
                $persentaseRencana,

            'status_rencana' =>
                $statusRencana,

            'total_protein' =>
                (float) $totalProtein,

            'total_karbohidrat' =>
                (float) $totalKarbohidrat,

            'total_lemak' =>
                (float) $totalLemak,

            'consumed_kalori' =>
                (int) round($consumedKalori),
        ];
    }

    private function getMakananOptions(): array
    {
        $makanan = new Makanan();
        $table = $makanan->getTable();

        if (! Schema::hasTable($table)) {
            return [];
        }

        $query = Makanan::query();

        $userId = Auth::id();

        if (Schema::hasColumn($table, 'user_id')) {
            $query->where(function ($subQuery) use ($table, $userId) {
                $subQuery->where('user_id', $userId);

                if (Schema::hasColumn($table, 'is_public')) {
                    $subQuery->orWhere('is_public', true);
                }
            });
        }

        if (trim($this->makananSearch) !== '') {
            $search = '%' . trim($this->makananSearch) . '%';

            $query->where(function ($subQuery) use ($table, $search) {
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
                        $subQuery->orWhere($column, 'like', $search);
                    }
                }
            });
        }

        if (Schema::hasColumn($table, 'created_at')) {
            $query->latest();
        } else {
            $query->orderByDesc('id');
        }

        return $query
            ->limit(30)
            ->get()
            ->map(function (Makanan $makanan): array {
                $nama = (string) ($this->getAttributeValue($makanan, [
                    'nama',
                    'name',
                    'nama_makanan',
                    'title',
                ]) ?? 'Makanan tanpa nama');

                $kalori = (int) round((float) ($this->getAttributeValue($makanan, [
                    'kalori',
                    'calories',
                    'calorie',
                    'kalori_per_porsi',
                    'total_calories',
                ]) ?? 0));

                return [
                    'id' => $makanan->id,
                    'nama' => $nama,
                    'kalori' => $kalori,
                ];
            })
            ->values()
            ->toArray();
    }

    private function resolveMakananFromMealPlanItem(MealPlanItem $item): ?Makanan
    {
        $makananId = $this->getAttributeValue($item, [
            'makanan_id',
            'food_id',
        ]);

        if (! $makananId) {
            return null;
        }

        $makanan = Makanan::find((int) $makananId);

        return $makanan instanceof Makanan ? $makanan : null;
    }

    private function canAccessMakanan(Makanan $makanan): bool
    {
        $table = $makanan->getTable();

        if (! Schema::hasColumn($table, 'user_id')) {
            return true;
        }

        if ((int) $makanan->user_id === (int) Auth::id()) {
            return true;
        }

        if (Schema::hasColumn($table, 'is_public')) {
            return (bool) $makanan->is_public;
        }

        return false;
    }

    private function canManageMealPlanItem(MealPlanItem $item): bool
    {
        $mealPlanId = $this->getAttributeValue($item, [
            'meal_plan_id',
        ]);

        if (! $mealPlanId) {
            return false;
        }

        $mealPlan = MealPlan::find((int) $mealPlanId);

        if (! $mealPlan instanceof MealPlan) {
            return false;
        }

        $mealPlanUserId = $this->getAttributeValue($mealPlan, [
            'user_id',
        ]);

        return (int) $mealPlanUserId === (int) Auth::id();
    }

    private function getAttributeValue(Model $model, array $columns): mixed
    {
        foreach ($columns as $column) {
            $attributes = $model->getAttributes();

            if (! array_key_exists($column, $attributes)) {
                continue;
            }

            return $model->getAttribute($column);
        }

        return null;
    }

    private function firstExistingColumn(string $table, array $columns): ?string
    {
        foreach ($columns as $column) {
            if (Schema::hasColumn($table, $column)) {
                return $column;
            }
        }

        return null;
    }

    private function mealTimeValueForDatabase(string $selectedMealTime, string $mealTimeColumn): string
    {
        if ($mealTimeColumn === 'meal_time') {
            return match ($selectedMealTime) {
                'sarapan' => 'breakfast',
                'makan_siang' => 'lunch',
                'makan_malam' => 'dinner',
                'snack' => 'snack',
                default => 'breakfast',
            };
        }

        return $selectedMealTime;
    }

    private function normalizeMealTimeKey(string $mealTime): string
    {
        return match ($mealTime) {
            'breakfast', 'sarapan', 'Sarapan' => 'sarapan',
            'lunch', 'makan_siang', 'Makan Siang' => 'makan_siang',
            'dinner', 'makan_malam', 'Makan Malam' => 'makan_malam',
            'snack', 'snack', 'Cemilan' => 'snack',
            default => 'sarapan',
        };
    }

    private function formatMealTime(string $mealTime): string
    {
        return match ($mealTime) {
            'breakfast', 'sarapan' => 'Sarapan',
            'lunch', 'makan_siang' => 'Makan Siang',
            'dinner', 'makan_malam' => 'Makan Malam',
            'snack', 'snack' => 'Cemilan',
            default => 'Makan',
        };
    }

    private function mealTimeIcon(string $mealTime): string
    {
        return match ($mealTime) {
            'sarapan' => '🌤️',
            'makan_siang' => '☀️',
            'makan_malam' => '🌙',
            'snack' => '🍓',
            default => '🍽️',
        };
    }

    private function isMealPlanItemConsumed(mixed $status): bool
    {
        if (is_bool($status)) {
            return $status;
        }

        if (is_numeric($status)) {
            return (int) $status === 1;
        }

        return in_array((string) $status, [
            'consumed',
            'dikonsumsi',
            'selesai',
            'sudah',
            'sudah_dimakan',
            'dimakan',
            'done',
        ], true);
    }

    public function render(): View
    {
        $items = $this->getFormattedMealPlanItems();

        return view('livewire.user.meal-plan-saya', [
            'makananOptions' => $this->getMakananOptions(),
            'mealPlanItems' => $items,
            'groupedItems' => $this->getGroupedItems($items),
            'summary' => $this->getSummary($items),
            'hasMealPlan' => $this->getMealPlansForSelectedDate()->isNotEmpty(),
            'dateLabel' => Carbon::parse($this->selectedDate)->translatedFormat('l, d F Y'),
        ]);
    }
}