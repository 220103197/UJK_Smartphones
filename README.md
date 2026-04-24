NAMA : HERMAWAN NUR EKA FEBRIANTO
NIM : 220103197
KELAS : 22TIA6

# 📱 UJK Smartphones — Sistem Manajemen Inventaris Smartphone

Aplikasi web berbasis **Laravel 12** untuk mengelola data inventaris smartphone di toko. Dilengkapi dengan sistem autentikasi, fitur CRUD lengkap, pencarian & filter dinamis, serta unggah gambar produk.

---

## 🗂️ Daftar Isi

- [Tentang Proyek](#tentang-proyek)
- [Fitur Utama](#fitur-utama)
- [Teknologi yang Digunakan](#teknologi-yang-digunakan)
- [Struktur Proyek](#struktur-proyek)
- [Struktur Database](#struktur-database)
- [Instalasi & Konfigurasi](#instalasi--konfigurasi)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)
- [Akun Default (Seeder)](#akun-default-seeder)
- [Alur Penggunaan](#alur-penggunaan)
- [Rute Aplikasi](#rute-aplikasi)

---

## Tentang Proyek

Proyek ini merupakan aplikasi manajemen inventaris smartphone yang dibangun sebagai bagian dari **Uji Kompetensi Kejuruan (UJK)**. Aplikasi ini memungkinkan admin atau staf toko untuk mencatat, memperbarui, dan menghapus data smartphone beserta informasi stok, harga, dan spesifikasi produk.

---

## Fitur Utama

- **Autentikasi** — Login & logout berbasis session Laravel dengan proteksi CSRF dan session regeneration untuk mencegah session fixation attack.
- **Dashboard Statistik** — Menampilkan total produk, jumlah yang tersedia, stok habis, dan total unit stok secara real-time.
- **CRUD Smartphone** — Tambah, lihat detail, edit, dan hapus data produk smartphone.
- **Upload Gambar Produk** — Mendukung format JPEG, PNG, JPG, dan WEBP (maksimal 2 MB), dengan penghapusan otomatis gambar lama saat diperbarui atau dihapus.
- **Pencarian & Filter Dinamis** — Filter berdasarkan kata kunci (nama produk, merek, model), status (tersedia / habis / tidak aktif), dan merek.
- **Paginasi** — Data ditampilkan 10 item per halaman dengan tetap mempertahankan parameter filter pada URL.
- **Kalkulasi Margin** — Model secara otomatis menghitung margin keuntungan (harga jual − harga beli) dan memformat harga ke format Rupiah.
- **Validasi Form** — Semua input divalidasi di sisi server, termasuk aturan `harga_jual >= harga_beli`.
- **Middleware Auth** — Seluruh rute CRUD dilindungi dan hanya dapat diakses oleh pengguna yang sudah login.

---

## Teknologi yang Digunakan

| Komponen        | Detail                         |
| --------------- | ------------------------------ |
| Framework       | Laravel 12                     |
| Bahasa          | PHP ^8.2                       |
| Database        | SQLite (default) / MySQL       |
| Template Engine | Blade                          |
| Build Tool      | Vite                           |
| CSS/JS          | Laravel Mix (via `resources/`) |
| Testing         | PHPUnit 11                     |
| Package Manager | Composer & NPM                 |

---

## Struktur Proyek

```
UJK_Smartphones/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AuthController.php       # Login & logout
│   │       └── SmartphoneController.php # CRUD smartphone
│   ├── Models/
│   │   ├── Smartphone.php               # Model + accessor harga & margin
│   │   └── User.php
│   └── Providers/
│       └── AppServiceProvider.php
│
├── database/
│   ├── migrations/
│   │   └── ..._create_smartphones_table.php
│   └── seeders/
│       ├── SmartphoneSeeder.php         # Data contoh smartphone
│       └── UserSeeder.php               # Akun admin & staff
│
├── resources/views/
│   ├── auth/
│   │   └── login.blade.php
│   ├── layouts/
│   │   └── app.blade.php
│   └── smartphones/
│       ├── index.blade.php              # Daftar + statistik + filter
│       ├── create.blade.php             # Form tambah
│       ├── edit.blade.php               # Form edit
│       └── show.blade.php               # Detail produk
│
├── routes/
│   └── web.php                          # Definisi semua rute
│
├── .env.example
├── composer.json
└── vite.config.js
```

---

## Struktur Database

### Tabel `smartphones`

| Kolom               | Tipe              | Keterangan                           |
| ------------------- | ----------------- | ------------------------------------ |
| `id`                | bigint (PK)       | Auto increment                       |
| `nama_produk`       | string            | Nama lengkap produk                  |
| `merek`             | string            | Samsung, Apple, Xiaomi, dll.         |
| `model`             | string            | Kode model perangkat                 |
| `spesifikasi`       | text (nullable)   | Deskripsi spesifikasi                |
| `harga_beli`        | decimal(15,2)     | Harga modal                          |
| `harga_jual`        | decimal(15,2)     | Harga jual ke konsumen               |
| `stok`              | integer           | Jumlah unit tersedia                 |
| `warna`             | string (nullable) | Warna perangkat                      |
| `kapasitas_storage` | string (nullable) | Contoh: 128GB, 256GB                 |
| `ram`               | string (nullable) | Contoh: 8GB, 12GB                    |
| `kondisi`           | enum              | `baru` / `bekas`                     |
| `status`            | enum              | `tersedia` / `habis` / `tidak_aktif` |
| `gambar`            | string (nullable) | Path file gambar                     |
| `created_at`        | timestamp         | —                                    |
| `updated_at`        | timestamp         | —                                    |

### Tabel `users`

| Kolom        | Tipe            | Keterangan        |
| ------------ | --------------- | ----------------- |
| `id`         | bigint (PK)     | Auto increment    |
| `name`       | string          | Nama pengguna     |
| `email`      | string (unique) | Email untuk login |
| `password`   | string          | Bcrypt hash       |
| `created_at` | timestamp       | —                 |
| `updated_at` | timestamp       | —                 |

---

## Instalasi & Konfigurasi

### Prasyarat

- PHP >= 8.2
- Composer
- Node.js & NPM
- SQLite (sudah termasuk di PHP) atau MySQL

### Langkah Instalasi

**1. Clone atau ekstrak repository**

```bash
git clone <url-repository>
cd UJK_Smartphones
```

**2. Install dependensi PHP**

```bash
composer install
```

**3. Salin file environment**

```bash
cp .env.example .env
```

**4. Generate application key**

```bash
php artisan key:generate
```

**5. Konfigurasi database**

Untuk SQLite (default, tidak perlu konfigurasi tambahan):

```bash
touch database/database.sqlite
```

Untuk MySQL, edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ujk_smartphones
DB_USERNAME=root
DB_PASSWORD=your_password
```

**6. Jalankan migrasi dan seeder**

```bash
php artisan migrate --seed
```

**7. Buat symbolic link untuk storage**

```bash
php artisan storage:link
```

**8. Install dependensi frontend dan build aset**

```bash
npm install
npm run build
```

> **Cara cepat:** Semua langkah di atas (kecuali konfigurasi .env manual) dapat dijalankan sekaligus dengan:
>
> ```bash
> composer run setup
> ```

---

## Menjalankan Aplikasi

```bash
# Development (menjalankan server + vite + queue + log secara bersamaan)
composer run dev

# Atau hanya server Laravel
php artisan serve
```

Akses aplikasi di: **http://localhost:8000**

---

## Akun Default (Seeder)

Setelah menjalankan `php artisan migrate --seed`, tersedia dua akun bawaan:

| Role  | Email                | Password      |
| ----- | -------------------- | ------------- |
| Admin | `admin@techshop.com` | `password123` |
| Staff | `staff@techshop.com` | `password123` |

---

## Alur Penggunaan

```
1. Buka aplikasi → diarahkan ke halaman Login
2. Login menggunakan email & password
3. Masuk ke halaman Daftar Smartphone (index)
   ├── Lihat statistik: total produk, tersedia, stok habis, total unit
   ├── Gunakan kolom pencarian atau filter merek/status
   └── Pilih aksi: Tambah / Lihat Detail / Edit / Hapus
4. Tambah Produk → isi form → submit → data tersimpan
5. Edit Produk → ubah data → submit → data diperbarui (gambar lama dihapus otomatis)
6. Hapus Produk → konfirmasi → data dan gambar dihapus permanen
7. Logout → session dihapus → kembali ke halaman login
```

---

## Rute Aplikasi

| Method | URL                      | Controller                   | Keterangan                        |
| ------ | ------------------------ | ---------------------------- | --------------------------------- |
| GET    | `/`                      | AuthController@showLogin     | Halaman utama (redirect ke login) |
| GET    | `/login`                 | AuthController@showLogin     | Tampilkan form login              |
| POST   | `/login`                 | AuthController@login         | Proses login                      |
| POST   | `/logout`                | AuthController@logout        | Proses logout                     |
| GET    | `/smartphones`           | SmartphoneController@index   | Daftar semua smartphone           |
| GET    | `/smartphones/create`    | SmartphoneController@create  | Form tambah smartphone            |
| POST   | `/smartphones`           | SmartphoneController@store   | Simpan smartphone baru            |
| GET    | `/smartphones/{id}`      | SmartphoneController@show    | Detail smartphone                 |
| GET    | `/smartphones/{id}/edit` | SmartphoneController@edit    | Form edit smartphone              |
| PUT    | `/smartphones/{id}`      | SmartphoneController@update  | Perbarui data smartphone          |
| DELETE | `/smartphones/{id}`      | SmartphoneController@destroy | Hapus smartphone                  |

> Seluruh rute `/smartphones` dilindungi oleh middleware `auth`.

---

## Lisensi

Proyek ini dibuat untuk keperluan **Uji Kompetensi Kejuruan (UJK)** dan dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT).
