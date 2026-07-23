# Sistem Pola Makan Sehat

[![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![Filament](https://img.shields.io/badge/Filament-v3-FDAE4B)](https://filamentphp.com/)
[![Livewire](https://img.shields.io/badge/Livewire-3-4E56A6)](https://livewire.laravel.com/)
[![MariaDB](https://img.shields.io/badge/MariaDB-Database-003545?logo=mariadb&logoColor=white)](https://mariadb.org/)
[![Docker](https://img.shields.io/badge/Docker-Containerized-2496ED?logo=docker&logoColor=white)](https://www.docker.com/)

Aplikasi web untuk membantu pengguna merencanakan pola makan, menghitung estimasi kebutuhan kalori harian, menyusun *meal plan*, mencatat konsumsi, dan mengelola daftar belanja secara terintegrasi.

Proyek ini dikembangkan sebagai **Capstone Project Program Studi Sistem Informasi Universitas Esa Unggul**.

---

## Daftar Isi

- [Tentang Proyek](#tentang-proyek)
- [Fitur Utama](#fitur-utama)
- [Aktor dan Hak Akses](#aktor-dan-hak-akses)
- [Teknologi](#teknologi)
- [Arsitektur Singkat](#arsitektur-singkat)
- [Struktur Proyek](#struktur-proyek)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi Lokal](#instalasi-lokal)
- [Konfigurasi Lingkungan](#konfigurasi-lingkungan)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)
- [Akses Panel Administrator](#akses-panel-administrator)
- [Pengujian](#pengujian)
- [API dan Dokumentasi](#api-dan-dokumentasi)
- [Deployment](#deployment)
- [Tangkapan Layar](#tangkapan-layar)
- [Catatan Keamanan](#catatan-keamanan)
- [Kontributor](#kontributor)
- [Lisensi dan Penggunaan](#lisensi-dan-penggunaan)

---

## Tentang Proyek

Pengelolaan pola makan sering melibatkan beberapa proses yang terpisah, seperti menghitung kebutuhan kalori, memilih makanan, menyusun jadwal makan, mencatat konsumsi, dan menyiapkan daftar belanja.

Sistem Pola Makan Sehat menyatukan proses tersebut dalam satu aplikasi berbasis web. Data tubuh dan tingkat aktivitas pengguna digunakan untuk menghitung estimasi kebutuhan kalori harian dengan persamaan Harris-Benedict revisi. Hasil perhitungan menjadi pembanding bagi rencana makan dan konsumsi aktual pengguna.

Aplikasi ini berfungsi sebagai alat bantu perencanaan. Hasil perhitungan tidak menggantikan diagnosis, rekomendasi, atau konsultasi dari tenaga kesehatan dan ahli gizi.

---

## Fitur Utama

### Autentikasi dan Profil

- Registrasi menggunakan email dan kata sandi.
- Login dan logout pengguna.
- Dukungan autentikasi Google apabila kredensial OAuth telah dikonfigurasi.
- Pengelolaan nama, email, jenis kelamin, usia, tinggi badan, berat badan, dan tingkat aktivitas.
- Perubahan kata sandi.
- Pembatasan akses berdasarkan peran dan kepemilikan data.

### Dashboard Pengguna

- Estimasi target kalori harian.
- Kalori yang telah dikonsumsi.
- Sisa atau kelebihan kalori.
- Ringkasan protein, karbohidrat, dan lemak.
- Jadwal makan hari ini.
- Status makanan sudah atau belum dikonsumsi.
- Catatan makanan tambahan.
- Rekomendasi menu sehat.

### Koleksi Makanan

- Pencarian makanan berdasarkan nama atau deskripsi.
- Filter kategori dan jenis makanan.
- Makanan pribadi, publik, dan rekomendasi.
- Informasi kalori, protein, karbohidrat, lemak, porsi, dan deskripsi.
- CRUD makanan pribadi.
- Penambahan makanan langsung ke rencana makan.
- Gambar makanan global yang dapat dikelola administrator.

### Rencana Makan

- Penyusunan rencana berdasarkan tanggal.
- Pembagian waktu makan: sarapan, makan siang, makan malam, dan cemilan.
- Pemilihan makanan dan jumlah porsi.
- Catatan tambahan pada setiap menu.
- Penandaan makanan sudah atau belum dikonsumsi.
- Perhitungan total kalori rencana.
- Perbandingan total kalori dengan target harian.
- Perhitungan kalori yang telah dikonsumsi.
- Penghapusan item atau seluruh rencana makan pada tanggal tertentu.

> Nilai internal waktu makan cemilan disimpan sebagai `snack` pada basis data, sedangkan antarmuka pengguna menampilkan label **Cemilan**.

### Makanan Tambahan

- Pencatatan makanan yang dikonsumsi di luar rencana makan.
- Penyimpanan tanggal, waktu makan, porsi, kalori, protein, karbohidrat, lemak, dan catatan.
- Pembaruan otomatis pada ringkasan konsumsi harian.
- Penyimpanan makanan sebagai koleksi pribadi agar dapat digunakan kembali.

### Daftar Belanja

- Penambahan, perubahan, pencarian, penyaringan, dan penghapusan item.
- Informasi jumlah, satuan, kategori belanja, kategori makanan, dan catatan.
- Informasi kalori, protein, karbohidrat, dan lemak.
- Status sudah atau belum dibeli.
- Pengelompokan item berdasarkan kategori.
- Pembersihan item yang telah selesai.
- Item bernutrisi yang telah dibeli dapat tersedia pada pilihan rencana makan.

### Panel Administrator

Administrator dapat mengelola:

- Pengguna.
- Peran dan izin.
- Kategori makanan.
- Data makanan.
- Status publik dan rekomendasi.
- Bahan makanan.
- Rencana makan.
- Detail rencana makan.
- Daftar belanja.
- Nama dan subjudul website.
- Logo website.
- Latar halaman login dan registrasi.
- Gambar global makanan.
- Catatan aktivitas.

### API

- Autentikasi token menggunakan Laravel Sanctum.
- Layanan API untuk sumber daya Filament.
- Dokumentasi endpoint menggunakan Scramble.
- Dukungan pengembangan integrasi lanjutan.

---

## Aktor dan Hak Akses

| Aktor | Hak akses utama |
|---|---|
| Pengguna | Mengelola profil, data tubuh, makanan pribadi, rencana makan, konsumsi harian, makanan tambahan, dan daftar belanja |
| Administrator | Mengelola pengguna, peran, kategori, makanan, rekomendasi, data transaksi, dan pengaturan tampilan website |

Pengguna biasa tidak dapat mengakses panel administrator. Setiap pengguna hanya dapat mengelola data yang menjadi miliknya, kecuali administrator memiliki kewenangan sesuai peran yang diberikan.

---

## Teknologi

| Bagian | Teknologi |
|---|---|
| Framework utama | Laravel 12 |
| Bahasa pemrograman | PHP 8.3 |
| Antarmuka pengguna | Blade dan Livewire |
| Panel administrator | Filament 3 |
| Basis data | MariaDB |
| ORM | Eloquent ORM |
| Web server | Nginx |
| Lingkungan | Docker |
| Autentikasi API | Laravel Sanctum |
| Dokumentasi API | Scramble |
| API Filament | Rupadana Filament API Service |
| Pengendalian versi | Git dan GitHub |
| Deployment | VPS |

---

## Arsitektur Singkat

```text
Pengguna / Administrator
          │
          ▼
Blade + Livewire / Filament
          │
          ▼
Laravel Application
          │
          ├── Autentikasi dan Otorisasi
          ├── Validasi
          ├── Logika Perhitungan Kalori
          ├── Sinkronisasi Data Makanan
          └── REST API
          │
          ▼
Eloquent ORM
          │
          ▼
MariaDB
```

Docker digunakan untuk menjalankan layanan PHP, Nginx, dan MariaDB secara konsisten pada lingkungan pengembangan dan deployment.

---

## Struktur Proyek

```text
project/
├── docker-compose.yml
├── README.md
└── src/
    ├── app/
    │   ├── Filament/
    │   ├── Http/
    │   ├── Livewire/
    │   ├── Models/
    │   ├── Policies/
    │   └── Providers/
    ├── bootstrap/
    ├── config/
    ├── database/
    │   ├── migrations/
    │   └── seeders/
    ├── public/
    ├── resources/
    │   └── views/
    ├── routes/
    ├── storage/
    ├── tests/
    ├── artisan
    ├── composer.json
    └── package.json
```

---

## Persyaratan Sistem

Pastikan perangkat telah memiliki:

- Git.
- Docker Desktop atau Docker Engine.
- Docker Compose.
- Node.js dan npm untuk membangun aset frontend.
- Peramban modern.

Composer dan PHP dapat dijalankan melalui container Docker sehingga tidak wajib dipasang langsung pada sistem operasi host.

---

## Instalasi Lokal

### 1. Clone repositori

```bash
git clone https://github.com/adeliarizkycantika/project.git
cd project
```

### 2. Salin file konfigurasi

```bash
cp src/.env.example src/.env
```

Sesuaikan konfigurasi pada `src/.env`, terutama koneksi basis data, URL aplikasi, email, dan OAuth Google apabila digunakan.

### 3. Bangun dan jalankan container

```bash
docker compose up -d --build
```

### 4. Pasang dependensi PHP

```bash
docker compose exec php composer install
```

### 5. Buat application key

```bash
docker compose exec php php artisan key:generate
```

### 6. Jalankan migrasi dan seeder

```bash
docker compose exec php php artisan migrate --seed
```

Jangan menjalankan perintah reset basis data pada lingkungan yang telah berisi data penting.

### 7. Buat symbolic link storage

```bash
docker compose exec php php artisan storage:link
```

### 8. Pasang dan bangun aset frontend

```bash
cd src
npm install
npm run build
cd ..
```

Untuk pengembangan frontend:

```bash
cd src
npm run dev
```

### 9. Bersihkan cache Laravel

```bash
docker compose exec php php artisan optimize:clear
```

---

## Konfigurasi Lingkungan

Konfigurasi utama berada pada:

```text
src/.env
```

Variabel yang perlu diperiksa:

```dotenv
APP_NAME="Pola Makan Sehat"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=https://project.test

DB_CONNECTION=mariadb
DB_HOST=db
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

Untuk autentikasi Google, tambahkan konfigurasi sesuai implementasi proyek:

```dotenv
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=
```

Untuk layanan email:

```dotenv
MAIL_MAILER=
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="${APP_NAME}"
```

Jangan memasukkan file `.env`, kata sandi, token, atau kredensial produksi ke repositori Git.

---

## Menjalankan Aplikasi

Menjalankan container:

```bash
docker compose up -d
```

Melihat status container:

```bash
docker compose ps
```

Melihat log:

```bash
docker compose logs -f
```

Menghentikan container:

```bash
docker compose down
```

Lingkungan lokal proyek menggunakan alamat:

```text
https://project.test
```

Alamat dapat berbeda sesuai konfigurasi host dan `APP_URL`.

---

## Akses Panel Administrator

Panel administrator hanya dapat diakses oleh akun yang memiliki peran dan izin sesuai konfigurasi Filament dan Filament Shield.

Untuk membuat pengguna Filament baru:

```bash
docker compose exec php php artisan make:filament-user
```

Setelah akun dibuat, berikan peran administrator atau `super_admin` sesuai mekanisme yang digunakan oleh proyek.

Jangan menuliskan kredensial administrator pada README atau repositori publik.

---

## Pengujian

Pemeriksaan sintaks PHP:

```bash
docker compose exec php php -l app/Livewire/User/MealPlanSaya.php
```

Menjalankan pengujian Laravel:

```bash
docker compose exec php php artisan test
```

Memeriksa dan membangun view Blade:

```bash
docker compose exec php php artisan view:clear
docker compose exec php php artisan view:cache
```

Membersihkan cache:

```bash
docker compose exec php php artisan optimize:clear
```

Skenario utama yang perlu diuji:

1. Registrasi dan login.
2. Pembaruan data tubuh.
3. Perhitungan target kalori.
4. CRUD makanan pribadi.
5. Pencarian dan filter makanan.
6. Penambahan makanan ke rencana.
7. Penandaan status konsumsi.
8. Pencatatan makanan tambahan.
9. Penyimpanan makanan tambahan ke koleksi.
10. Penambahan item daftar belanja.
11. Sinkronisasi item yang sudah dibeli ke pilihan rencana makan.
12. Pengelolaan data melalui panel administrator.
13. Responsivitas pada desktop, tablet, dan telepon seluler.

---

## API dan Dokumentasi

API dilindungi menggunakan Laravel Sanctum. Dokumentasi endpoint dibuat melalui Scramble, sedangkan sumber daya Filament menggunakan Filament API Service.

Lokasi dokumentasi API mengikuti konfigurasi route Scramble pada aplikasi. Pastikan akun atau token yang digunakan memiliki izin yang sesuai sebelum melakukan pengujian endpoint.

Jangan memublikasikan token autentikasi pada dokumentasi, commit, tangkapan layar, atau issue GitHub.

---

## Deployment

Gambaran umum deployment:

1. Clone atau tarik perubahan terbaru dari repositori.
2. Salin dan isi `.env` produksi.
3. Bangun container Docker.
4. Pasang dependensi Composer dengan konfigurasi produksi.
5. Jalankan migrasi basis data.
6. Bangun aset frontend.
7. Buat symbolic link storage.
8. Bersihkan dan optimalkan cache Laravel.
9. Pastikan Nginx, PHP, basis data, SSL, dan domain berjalan.
10. Periksa log aplikasi setelah deployment.

Contoh perintah produksi:

```bash
git pull origin main

docker compose up -d --build

docker compose exec php composer install \
  --no-dev \
  --optimize-autoloader

docker compose exec php php artisan migrate --force
docker compose exec php php artisan storage:link
docker compose exec php php artisan optimize:clear
docker compose exec php php artisan optimize
```

Sebelum deployment, lakukan pencadangan basis data dan berkas yang diunggah pengguna.

---

## Tangkapan Layar

Simpan tangkapan layar pada direktori berikut agar dapat ditampilkan pada README:

```text
docs/screenshots/
```

Struktur yang disarankan:

```text
docs/screenshots/
├── login.png
├── register.png
├── dashboard.png
├── makanan.png
├── meal-plan.png
├── daftar-belanja.png
├── profil.png
└── admin-panel.png
```

Contoh pemasangan gambar:

```md
![Dashboard pengguna](docs/screenshots/dashboard.png)
```

<!--
Aktifkan bagian berikut setelah berkas tangkapan layar tersedia.

### Halaman Login
![Halaman login](docs/screenshots/login.png)

### Dashboard Pengguna
![Dashboard pengguna](docs/screenshots/dashboard.png)

### Koleksi Makanan
![Koleksi makanan](docs/screenshots/makanan.png)

### Rencana Makan
![Rencana makan](docs/screenshots/meal-plan.png)

### Daftar Belanja
![Daftar belanja](docs/screenshots/daftar-belanja.png)

### Panel Administrator
![Panel administrator](docs/screenshots/admin-panel.png)
-->

---

## Catatan Keamanan

- Jangan commit file `.env`.
- Jangan menyimpan kata sandi, token, atau secret di dalam kode.
- Gunakan HTTPS pada lingkungan produksi.
- Batasi panel administrator berdasarkan peran.
- Validasi seluruh input pengguna.
- Lakukan pencadangan basis data secara berkala.
- Periksa log Laravel dan Nginx apabila terjadi error.
- Jalankan migrasi produksi menggunakan opsi `--force`.
- Jangan menjalankan perintah reset atau seed ulang pada basis data produksi tanpa pencadangan.

---

## Kontributor

**Adeliar Rizky Cantika**  
NIM: 20240801059  
Program Studi Sistem Informasi  
Fakultas Ilmu Komputer  
Universitas Esa Unggul

Repositori:

[github.com/adeliarizkycantika/project](https://github.com/adeliarizkycantika/project)

---

## Lisensi dan Penggunaan

Proyek ini dibuat untuk kebutuhan akademik Capstone Project.

Hak penggunaan, pengembangan, dan distribusi mengikuti kebijakan pemilik repositori. Tambahkan berkas lisensi secara terpisah apabila proyek akan dipublikasikan sebagai perangkat lunak sumber terbuka.

---

## Disclaimer

Sistem ini memberikan estimasi kebutuhan kalori berdasarkan data yang dimasukkan pengguna. Hasil yang ditampilkan bukan diagnosis medis dan tidak menggantikan konsultasi dengan dokter, ahli gizi, atau tenaga kesehatan profesional.
