<?php

namespace App\Livewire\User;

use App\Models\CatatanMakananHarian;
use App\Models\KategoriMakanan;
use App\Models\Makanan;
use App\Models\MealPlan;
use App\Models\MealPlanItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Throwable;

#[Layout('layouts.user')]
class BerandaDiet extends Component
{
    public int $targetKalori = 0;

    public int $kaloriMasuk = 0;

    public int $sisaKalori = 0;

    public int $persentaseKalori = 0;

    public float $proteinMasuk = 0;

    public float $karboMasuk = 0;

    public float $lemakMasuk = 0;

    public array $dataTubuh = [];

    public array $jadwalMakanHariIni = [];

    public array $catatanMakananHariIni = [];

    public array $rekomendasiMenu = [];

    public bool $dataTubuhLengkap = false;

    public string $tanggalHariIni = '';

    public string $selectedMealPlanDate = '';

    public string $selectedMealTime = 'sarapan';

    public string $extra_food_date = '';

    public string $extra_meal_time = 'sarapan';

    public string $extra_food_name = '';

    public $extra_porsi = 1;

    public $extra_calories = null;

    public $extra_protein = null;

    public $extra_karbohidrat = null;

    public $extra_lemak = null;

    public ?string $extra_catatan = null;

    public array $mealTimeOptions = [
        'sarapan' => 'Sarapan',
        'makan_siang' => 'Makan Siang',
        'makan_malam' => 'Makan Malam',
        'cemilan' => 'Cemilan',
    ];

    public function mount(): void
    {
        if (! Auth::check()) {
            abort(403);
        }

        $today = Carbon::today()->toDateString();

        $this->selectedMealPlanDate = $today;
        $this->extra_food_date = $today;

        $this->loadDashboard();
    }

    public function loadDashboard(): void
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            return;
        }

        $this->tanggalHariIni = Carbon::today()->translatedFormat('l, d F Y');

        $this->dataTubuhLengkap = $user->hasCompleteBodyData();

        if ($this->dataTubuhLengkap && empty($user->daily_calorie_target)) {
            $user->recalculateDailyCalories();

            $freshUser = $user->fresh();

            if ($freshUser instanceof User) {
                $user = $freshUser;
            }
        }

        $this->targetKalori = (int) ($user->daily_calorie_target ?? 0);

        $this->dataTubuh = [
            'gender' => $user->gender,
            'gender_label' => $user->gender_label ?? '-',
            'age' => $user->age,
            'usia' => $user->age,
            'height_cm' => $user->height_cm,
            'tinggi' => $user->height_cm,
            'weight_kg' => $user->weight_kg,
            'berat' => $user->weight_kg,
            'activity_level' => $user->activity_level,
            'activity_label' => $user->activity_level_label ?? '-',
            'activity_level_label' => $user->activity_level_label ?? '-',
            'aktivitas' => $user->activity_level_label ?? '-',
        ];

        $this->loadJadwalMakanHariIni();
        $this->loadCatatanMakananHariIni();
        $this->loadRekomendasiMenu();

        $this->sisaKalori = $this->targetKalori - $this->kaloriMasuk;

        $this->persentaseKalori = $this->targetKalori > 0
            ? min(100, (int) round(($this->kaloriMasuk / $this->targetKalori) * 100))
            : 0;
    }

    public function addCatatanMakananHarian(): void
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            session()->flash(
                'dashboard_error',
                'User tidak ditemukan. Silakan login ulang.'
            );

            return;
        }

        $validated = $this->validate([
            'extra_food_date' => [
                'required',
                'date',
            ],
            'extra_meal_time' => [
                'required',
                'in:sarapan,makan_siang,makan_malam,cemilan',
            ],
            'extra_food_name' => [
                'required',
                'string',
                'max:255',
            ],
            'extra_porsi' => [
                'required',
                'numeric',
                'min:0.1',
                'max:50',
            ],
            'extra_calories' => [
                'required',
                'numeric',
                'min:0',
                'max:10000',
            ],
            'extra_protein' => [
                'nullable',
                'numeric',
                'min:0',
                'max:1000',
            ],
            'extra_karbohidrat' => [
                'nullable',
                'numeric',
                'min:0',
                'max:1000',
            ],
            'extra_lemak' => [
                'nullable',
                'numeric',
                'min:0',
                'max:1000',
            ],
            'extra_catatan' => [
                'nullable',
                'string',
                'max:500',
            ],
        ], [
            'extra_food_date.required' =>
                'Tanggal wajib diisi.',

            'extra_meal_time.required' =>
                'Waktu makan wajib dipilih.',

            'extra_food_name.required' =>
                'Nama makanan wajib diisi.',

            'extra_porsi.required' =>
                'Jumlah porsi wajib diisi.',

            'extra_calories.required' =>
                'Kalori per porsi wajib diisi.',
        ]);

        try {
            DB::transaction(function () use (
                $user,
                $validated
            ): void {
                $foodName = trim(
                    (string) $validated['extra_food_name']
                );

                /*
                 * Simpan atau perbarui makanan pribadi.
                 * Data ini yang akan dibaca dropdown Meal Plan.
                 */
                $this->syncCatatanMakananKeKoleksi(
                    user: $user,
                    validated: $validated
                );

                /*
                 * Simpan catatan konsumsi harian.
                 * Data ini yang masuk ke Catatan Hari Ini
                 * dan perhitungan kalori Dashboard.
                 */
                CatatanMakananHarian::create([
                    'user_id' => $user->id,

                    'tanggal' =>
                        $validated['extra_food_date'],

                    'waktu_makan' =>
                        $validated['extra_meal_time'],

                    'nama_makanan' =>
                        $foodName,

                    'porsi' =>
                        (float) $validated['extra_porsi'],

                    'kalori' =>
                        (float) $validated['extra_calories'],

                    'protein' =>
                        (float) (
                            $validated['extra_protein']
                            ?? 0
                        ),

                    'karbohidrat' =>
                        (float) (
                            $validated['extra_karbohidrat']
                            ?? 0
                        ),

                    'lemak' =>
                        (float) (
                            $validated['extra_lemak']
                            ?? 0
                        ),

                    'catatan' =>
                        $validated['extra_catatan']
                        ?? null,
                ]);
            });
        } catch (Throwable $exception) {
            report($exception);

            session()->flash(
                'dashboard_error',
                'Catatan gagal disimpan. Data makanan atau kategori belum sesuai.'
            );

            return;
        }

        $this->reset([
            'extra_food_name',
            'extra_calories',
            'extra_protein',
            'extra_karbohidrat',
            'extra_lemak',
            'extra_catatan',
        ]);

        $this->extra_porsi = 1;

        $this->extra_food_date =
            Carbon::today()->toDateString();

        $this->extra_meal_time = 'sarapan';

        session()->flash(
            'dashboard_success',
            'Catatan berhasil disimpan dan makanan sudah tersedia di Meal Plan.'
        );

        $this->loadDashboard();
    }

    private function resolveDefaultKategoriMakananId(): ?int
    {
        $kategoriModel = new KategoriMakanan();
        $table = $kategoriModel->getTable();

        if (! Schema::hasTable($table)) {
            return null;
        }

        $kategori = KategoriMakanan::query()
            ->orderBy('id')
            ->first();

        if (! $kategori instanceof KategoriMakanan) {
            return null;
        }

        return (int) $kategori->id;
    }

    private function syncCatatanMakananKeKoleksi(
        User $user,
        array $validated
    ): Makanan {
        $makananModel = new Makanan();
        $table = $makananModel->getTable();

        if (! Schema::hasTable($table)) {
            throw new \RuntimeException(
                'Tabel makanan belum tersedia.'
            );
        }

        $foodName = trim(
            (string) $validated['extra_food_name']
        );

        /*
         * Mencari makanan dengan nama yang sama milik user.
         * Pada MySQL pencarian ini umumnya tidak membedakan
         * huruf besar dan kecil.
         */
        $makanan = Makanan::query()
            ->where('user_id', $user->id)
            ->where('nama', $foodName)
            ->first();

        $isNewFood = ! $makanan instanceof Makanan;

        if ($isNewFood) {
            $makanan = new Makanan();
            $makanan->user_id = $user->id;

            if (
                Schema::hasColumn(
                    $table,
                    'kategori_makanan_id'
                )
            ) {
                $kategoriId =
                    $this->resolveDefaultKategoriMakananId();

                if ($kategoriId !== null) {
                    $makanan->kategori_makanan_id =
                        $kategoriId;
                }
            }

            if (
                Schema::hasColumn(
                    $table,
                    'deskripsi'
                )
            ) {
                $makanan->deskripsi =
                    'Disimpan otomatis dari Catat Makanan Tambahan.';
            }

            if (
                Schema::hasColumn(
                    $table,
                    'is_public'
                )
            ) {
                $makanan->is_public = false;
            }

            if (
                Schema::hasColumn(
                    $table,
                    'is_recommended'
                )
            ) {
                $makanan->is_recommended = false;
            }

            if (
                Schema::hasColumn(
                    $table,
                    'recommended_note'
                )
            ) {
                $makanan->recommended_note = null;
            }
        }

        $makanan->nama = $foodName;

        /*
         * Nilai nutrisi disimpan sebagai nilai per porsi.
         */
        $makanan->kalori =
            (float) $validated['extra_calories'];

        $makanan->protein =
            (float) (
                $validated['extra_protein']
                ?? 0
            );

        $makanan->karbohidrat =
            (float) (
                $validated['extra_karbohidrat']
                ?? 0
            );

        $makanan->lemak =
            (float) (
                $validated['extra_lemak']
                ?? 0
            );

        $makanan->save();

        return $makanan;
    }

    public function deleteCatatanMakananHarian(int $id): void
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            session()->flash('dashboard_error', 'User tidak ditemukan. Silakan login ulang.');
            return;
        }

        $catatan = CatatanMakananHarian::query()
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (! $catatan instanceof CatatanMakananHarian) {
            session()->flash('dashboard_error', 'Catatan makanan tidak ditemukan.');
            return;
        }

        $catatan->delete();

        session()->flash('dashboard_success', 'Catatan makanan berhasil dihapus.');

        $this->loadDashboard();
    }

    public function addRekomendasiToMealPlan(int $makananId): void
    {
        $validated = $this->validate([
            'selectedMealPlanDate' => [
                'required',
                'date',
            ],
            'selectedMealTime' => [
                'required',
                'in:sarapan,makan_siang,makan_malam,cemilan',
            ],
        ], [
            'selectedMealPlanDate.required' => 'Tanggal meal plan wajib dipilih.',
            'selectedMealPlanDate.date' => 'Tanggal meal plan tidak valid.',
            'selectedMealTime.required' => 'Waktu makan wajib dipilih.',
            'selectedMealTime.in' => 'Waktu makan tidak valid.',
        ]);

        $user = Auth::user();

        if (! $user instanceof User) {
            session()->flash('dashboard_error', 'User tidak ditemukan. Silakan login ulang.');
            return;
        }

        $makanan = Makanan::find($makananId);

        if (! $makanan instanceof Makanan) {
            session()->flash('dashboard_error', 'Menu rekomendasi tidak ditemukan.');
            return;
        }

        $mealPlan = new MealPlan();
        $mealPlanTable = $mealPlan->getTable();

        $mealPlanItem = new MealPlanItem();
        $mealPlanItemTable = $mealPlanItem->getTable();

        if (! Schema::hasTable($mealPlanTable) || ! Schema::hasTable($mealPlanItemTable)) {
            session()->flash('dashboard_error', 'Tabel meal plan belum tersedia.');
            return;
        }

        $mealPlanUserColumn = $this->firstExistingColumn($mealPlanTable, [
            'user_id',
        ]);

        $mealPlanDateColumn = $this->firstExistingColumn($mealPlanTable, [
            'tanggal_rencana',
            'tanggal',
            'date',
            'plan_date',
            'meal_date',
        ]);

        if (! $mealPlanUserColumn || ! $mealPlanDateColumn) {
            session()->flash('dashboard_error', 'Kolom user atau tanggal pada tabel meal plan belum sesuai.');
            return;
        }

        $selectedDate = (string) $validated['selectedMealPlanDate'];
        $selectedMealTime = (string) $validated['selectedMealTime'];

        $mealPlan = MealPlan::query()
            ->where($mealPlanUserColumn, $user->id)
            ->whereDate($mealPlanDateColumn, $selectedDate)
            ->first();

        if (! $mealPlan instanceof MealPlan) {
            $mealPlan = new MealPlan();
            $mealPlan->{$mealPlanUserColumn} = $user->id;
            $mealPlan->{$mealPlanDateColumn} = $selectedDate;

            if (Schema::hasColumn($mealPlanTable, 'judul')) {
                $mealPlan->judul = 'Meal Plan ' . Carbon::parse($selectedDate)->translatedFormat('d F Y');
            }

            if (Schema::hasColumn($mealPlanTable, 'title')) {
                $mealPlan->title = 'Meal Plan ' . Carbon::parse($selectedDate)->translatedFormat('d F Y');
            }

            if (Schema::hasColumn($mealPlanTable, 'nama')) {
                $mealPlan->nama = 'Meal Plan ' . Carbon::parse($selectedDate)->translatedFormat('d F Y');
            }

            if (Schema::hasColumn($mealPlanTable, 'catatan')) {
                $mealPlan->catatan = 'Dibuat dari rekomendasi menu.';
            }

            if (Schema::hasColumn($mealPlanTable, 'notes')) {
                $mealPlan->notes = 'Dibuat dari rekomendasi menu.';
            }

            if (Schema::hasColumn($mealPlanTable, 'status')) {
                $mealPlan->status = 'aktif';
            }

            $mealPlan->save();
        }

        $mealPlanItemForeignKey = $this->firstExistingColumn($mealPlanItemTable, [
            'meal_plan_id',
        ]);

        $makananForeignKey = $this->firstExistingColumn($mealPlanItemTable, [
            'makanan_id',
            'food_id',
        ]);

        if (! $mealPlanItemForeignKey || ! $makananForeignKey) {
            session()->flash('dashboard_error', 'Kolom relasi meal plan item belum sesuai.');
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
                selectedMealTime: $selectedMealTime,
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
            $item->{$portionColumn} = 1;
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
            $item->catatan = 'Ditambahkan dari rekomendasi menu.';
        }

        if (Schema::hasColumn($mealPlanItemTable, 'notes')) {
            $item->notes = 'Ditambahkan dari rekomendasi menu.';
        }

        if (Schema::hasColumn($mealPlanItemTable, 'note')) {
            $item->note = 'Ditambahkan dari rekomendasi menu.';
        }

        $item->save();

        session()->flash('dashboard_success', 'Menu berhasil ditambahkan ke meal plan.');

        $this->loadDashboard();
    }

    public function toggleMealPlanItemConsumed(int $itemId): void
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            session()->flash(
                'dashboard_error',
                'User tidak ditemukan. Silakan login ulang.'
            );

            return;
        }

        $item = MealPlanItem::find($itemId);

        if (! $item instanceof MealPlanItem) {
            session()->flash(
                'dashboard_error',
                'Item meal plan tidak ditemukan.'
            );

            return;
        }

        $mealPlanId = $this->getAttributeValue($item, [
            'meal_plan_id',
        ]);

        if (! $mealPlanId) {
            session()->flash(
                'dashboard_error',
                'Relasi meal plan item tidak ditemukan.'
            );

            return;
        }

        $mealPlan = MealPlan::find((int) $mealPlanId);

        if (! $mealPlan instanceof MealPlan) {
            session()->flash(
                'dashboard_error',
                'Meal plan tidak ditemukan.'
            );

            return;
        }

        $mealPlanUserId = $this->getAttributeValue(
            $mealPlan,
            [
                'user_id',
            ]
        );

        if ((int) $mealPlanUserId !== (int) $user->id) {
            session()->flash(
                'dashboard_error',
                'Kamu tidak memiliki akses ke item meal plan ini.'
            );

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

        $isConsumed = $this->isMealPlanItemConsumed(
            $currentStatus
        );

        $newStatus = ! $isConsumed;

        if (Schema::hasColumn($table, 'is_consumed')) {
            $item->is_consumed = $newStatus;
        }

        if (Schema::hasColumn($table, 'consumed')) {
            $item->consumed = $newStatus;
        }

        if (Schema::hasColumn($table, 'sudah_dimakan')) {
            $item->sudah_dimakan = $newStatus;
        }

        if (Schema::hasColumn($table, 'sudah_dikonsumsi')) {
            $item->sudah_dikonsumsi = $newStatus;
        }

        if (Schema::hasColumn($table, 'dikonsumsi_pada')) {
            $item->dikonsumsi_pada = ($newStatus) ? now() : null;
        }

        if (Schema::hasColumn($table, 'dikonsumsi')) {
            $item->dikonsumsi = $newStatus;
        }

        if (Schema::hasColumn($table, 'status')) {
            $item->status = $newStatus
                ? 'consumed'
                : 'planned';
        }

        $item->save();

        session()->flash(
            'dashboard_success',
            $newStatus
                ? 'Menu berhasil ditandai sudah dikonsumsi.'
                : 'Menu berhasil ditandai belum dikonsumsi.'
        );

        $this->loadDashboard();
    }

    private function loadJadwalMakanHariIni(): void
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            return;
        }

        $today = Carbon::today()->toDateString();

        $this->jadwalMakanHariIni = [];
        $this->kaloriMasuk = 0;
        $this->proteinMasuk = 0;
        $this->karboMasuk = 0;
        $this->lemakMasuk = 0;

        $items = $this->getTodayMealPlanItems((int) $user->id, $today);

        foreach ($items as $item) {
            if (! $item instanceof MealPlanItem) {
                continue;
            }

            $makanan = $this->resolveMakananFromMealPlanItem($item);

            if (! $makanan) {
                continue;
            }

            $porsi = (float) ($this->getAttributeValue($item, [
                'portion',
                'porsi',
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

            $karbo = (float) ($this->getAttributeValue($makanan, [
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

            $totalKalori = (int) round($kalori * $porsi);
            $totalProtein = $protein * $porsi;
            $totalKarbo = $karbo * $porsi;
            $totalLemak = $lemak * $porsi;

            $status = $this->getAttributeValue($item, [
                'sudah_dikonsumsi',
                'is_consumed',
                'consumed',
                'sudah_dimakan',
                'dikonsumsi',
                'status',
            ]);

            $isConsumed = $this->isMealPlanItemConsumed($status);

            if ($isConsumed) {
                $this->kaloriMasuk += $totalKalori;
                $this->proteinMasuk += $totalProtein;
                $this->karboMasuk += $totalKarbo;
                $this->lemakMasuk += $totalLemak;
            }

            $rawMealTime = (string) ($this->getAttributeValue($item, [
                'meal_time',
                'waktu_makan',
                'jenis_waktu_makan',
            ]) ?? 'sarapan');

            $mealTimeKey = $this->normalizeMealTimeKey($rawMealTime);
            $mealTimeLabel = $this->formatMealTime($mealTimeKey);

            $foodName = (string) ($this->getAttributeValue($makanan, [
                'nama',
                'name',
                'nama_makanan',
                'title',
            ]) ?? 'Menu tanpa nama');

            $this->jadwalMakanHariIni[] = [
                'id' => $item->id,
                'waktu_makan' => $mealTimeKey,
                'meal_time' => $mealTimeKey,
                'jenis_waktu_makan' => $mealTimeKey,
                'waktu_makan_label' => $mealTimeLabel,
                'nama_makanan' => $foodName,
                'nama' => $foodName,
                'kalori' => $totalKalori,
                'total_kalori' => $totalKalori,
                'protein' => $totalProtein,
                'total_protein' => $totalProtein,
                'karbohidrat' => $totalKarbo,
                'karbo' => $totalKarbo,
                'total_karbohidrat' => $totalKarbo,
                'lemak' => $totalLemak,
                'total_lemak' => $totalLemak,
                'porsi' => $porsi,
                'is_consumed' => $isConsumed,
            ];
        }
    }

    private function loadCatatanMakananHariIni(): void
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            return;
        }

        $this->catatanMakananHariIni = [];

        $table = (new CatatanMakananHarian())->getTable();

        if (! Schema::hasTable($table)) {
            return;
        }

        $query = CatatanMakananHarian::query()
            ->where('user_id', $user->id)
            ->whereDate('tanggal', Carbon::today()->toDateString());

        if (Schema::hasColumn($table, 'created_at')) {
            $query->latest();
        } else {
            $query->orderByDesc('id');
        }

        $catatans = $query->get();

        foreach ($catatans as $catatan) {
            if (! $catatan instanceof CatatanMakananHarian) {
                continue;
            }

            $totalKalori = (int) round((float) $catatan->kalori * (float) $catatan->porsi);
            $totalProtein = (float) $catatan->protein * (float) $catatan->porsi;
            $totalKarbo = (float) $catatan->karbohidrat * (float) $catatan->porsi;
            $totalLemak = (float) $catatan->lemak * (float) $catatan->porsi;

            $this->kaloriMasuk += $totalKalori;
            $this->proteinMasuk += $totalProtein;
            $this->karboMasuk += $totalKarbo;
            $this->lemakMasuk += $totalLemak;

            $mealTimeKey = $this->normalizeMealTimeKey((string) $catatan->waktu_makan);
            $mealTimeLabel = $this->formatMealTime($mealTimeKey);

            $this->catatanMakananHariIni[] = [
                'id' => $catatan->id,
                'waktu_makan' => $mealTimeKey,
                'meal_time' => $mealTimeKey,
                'waktu_makan_label' => $mealTimeLabel,
                'nama_makanan' => $catatan->nama_makanan,
                'nama' => $catatan->nama_makanan,
                'porsi' => (float) $catatan->porsi,
                'kalori' => $totalKalori,
                'total_kalori' => $totalKalori,
                'protein' => $totalProtein,
                'total_protein' => $totalProtein,
                'karbohidrat' => $totalKarbo,
                'karbo' => $totalKarbo,
                'total_karbohidrat' => $totalKarbo,
                'lemak' => $totalLemak,
                'total_lemak' => $totalLemak,
                'catatan' => $catatan->catatan,
            ];
        }
    }

    private function loadRekomendasiMenu(): void
    {
        $this->rekomendasiMenu = [];

        $makanan = new Makanan();
        $table = $makanan->getTable();

        if (! Schema::hasTable($table)) {
            return;
        }

        $query = Makanan::query();

        if (Schema::hasColumn($table, 'is_recommended')) {
            $query->where('is_recommended', true);
        }

        if (Schema::hasColumn($table, 'is_public')) {
            $authUserId = Auth::id();

            $query->where(function ($subQuery) use ($table, $authUserId) {
                $subQuery->where('is_public', true);

                if (Schema::hasColumn($table, 'user_id') && $authUserId) {
                    $subQuery->orWhere('user_id', $authUserId);
                }
            });
        } elseif (Schema::hasColumn($table, 'user_id')) {
            $authUserId = Auth::id();

            $query->where(function ($subQuery) use ($authUserId) {
                $subQuery->whereNull('user_id');

                if ($authUserId) {
                    $subQuery->orWhere('user_id', $authUserId);
                }
            });
        }

        if (Schema::hasColumn($table, 'created_at')) {
            $query->latest();
        } else {
            $query->orderByDesc('id');
        }

        $menus = $query->limit(6)->get();

        foreach ($menus as $menu) {
            if (! $menu instanceof Makanan) {
                continue;
            }

            $description = (string) ($this->getAttributeValue($menu, [
                'recommended_note',
                'deskripsi',
                'description',
                'catatan',
                'note',
            ]) ?? 'Menu sehat yang bisa dimasukkan ke meal plan.');

            $foodName = (string) ($this->getAttributeValue($menu, [
                'nama',
                'name',
                'nama_makanan',
                'title',
            ]) ?? 'Menu sehat');

            $kalori = (int) round((float) ($this->getAttributeValue($menu, [
                'kalori',
                'calories',
                'calorie',
                'kalori_per_porsi',
                'total_calories',
            ]) ?? 0));

            $protein = (float) ($this->getAttributeValue($menu, [
                'protein',
                'protein_gram',
                'protein_g',
            ]) ?? 0);

            $karbohidrat = (float) ($this->getAttributeValue($menu, [
                'karbohidrat',
                'karbo',
                'carbohydrate',
                'carbs',
                'carb',
            ]) ?? 0);

            $lemak = (float) ($this->getAttributeValue($menu, [
                'lemak',
                'fat',
                'fat_gram',
                'fat_g',
            ]) ?? 0);

            $this->rekomendasiMenu[] = [
                'id' => $menu->id,
                'nama' => $foodName,
                'nama_makanan' => $foodName,
                'deskripsi' => $description,
                'recommended_note' => $description,
                'kalori' => $kalori,
                'protein' => $protein,
                'karbohidrat' => $karbohidrat,
                'karbo' => $karbohidrat,
                'lemak' => $lemak,
            ];
        }
    }

    private function getTodayMealPlanItems(int $userId, string $date): Collection
    {
        $mealPlan = new MealPlan();
        $mealPlanTable = $mealPlan->getTable();

        $mealPlanItem = new MealPlanItem();
        $mealPlanItemTable = $mealPlanItem->getTable();

        if (! Schema::hasTable($mealPlanTable) || ! Schema::hasTable($mealPlanItemTable)) {
            return collect();
        }

        $dateColumn = $this->firstExistingColumn($mealPlanTable, [
            'tanggal_rencana',
            'tanggal',
            'date',
            'plan_date',
            'meal_date',
        ]);

        $userColumn = $this->firstExistingColumn($mealPlanTable, [
            'user_id',
        ]);

        if (! $dateColumn || ! $userColumn) {
            return collect();
        }

        $plans = MealPlan::query()
            ->where($userColumn, $userId)
            ->whereDate($dateColumn, $date)
            ->get();

        if ($plans->isEmpty()) {
            return collect();
        }

        $foreignKey = $this->firstExistingColumn($mealPlanItemTable, [
            'meal_plan_id',
        ]);

        if (! $foreignKey) {
            return collect();
        }

        return MealPlanItem::query()
            ->whereIn($foreignKey, $plans->pluck('id')->toArray())
            ->get();
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
                'cemilan' => 'snack',
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
            'snack', 'cemilan', 'Cemilan' => 'cemilan',
            default => 'sarapan',
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

    private function formatMealTime(string $mealTime): string
    {
        return match ($mealTime) {
            'breakfast', 'sarapan' => 'Sarapan',
            'lunch', 'makan_siang' => 'Makan Siang',
            'dinner', 'makan_malam' => 'Makan Malam',
            'snack', 'cemilan' => 'Cemilan',
            default => 'Makan',
        };
    }

    public function render(): View
    {
        return view('livewire.user.beranda-diet');
    }
}