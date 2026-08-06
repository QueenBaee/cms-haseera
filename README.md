# CMS Haseera

CMS Haseera adalah aplikasi backend untuk mengelola konten landing page Haseera. Aplikasi dibangun menggunakan Laravel dan Filament serta menyediakan panel admin untuk mengatur konten, media, visibilitas section, SEO, dan informasi perusahaan.

Repository ini hanya berisi CMS. Implementasi frontend landing page dan API publik tidak termasuk di dalamnya. Route `/` masih menggunakan halaman bawaan Laravel, sedangkan seluruh pengelolaan konten tersedia melalui panel `/admin`.

## Teknologi

- PHP 8.4
- Laravel 13
- Filament 5
- Livewire 4
- MySQL untuk database aplikasi
- Tailwind CSS 4 dan Vite 8 untuk asset panel
- Pest 5 untuk automated testing
- Laravel Pint untuk formatting PHP
- Laravel Herd sebagai environment lokal yang direkomendasikan

Versi paket aktual dapat diperiksa dengan:

```bash
php --version
composer show --direct
npm list --depth=0
```

## Fitur Utama

### Pengaturan landing page

Halaman singleton untuk mengatur:

- Informasi situs dan perusahaan
- Logo, logo mode gelap, favicon, dan gambar Open Graph
- Email, telepon, WhatsApp, alamat, dan Google Maps
- Judul serta deskripsi section statistik, layanan, portofolio, dan testimoni
- Visibilitas setiap section landing page
- Metadata SEO default
- Deskripsi dan teks hak cipta footer

### Call to Action

Halaman singleton untuk mengatur konten CTA, gambar latar, tombol utama, tombol sekunder, perilaku tab baru, dan status aktif.

### Resource konten

Panel menyediakan CRUD untuk:

| Resource | Kegunaan |
|---|---|
| Menu Navigasi | Mengatur label, URL, lokasi header/footer, ikon, dan urutan menu |
| Hero | Mengatur slide hero, media responsif, alignment, tombol, overlay, dan jadwal publikasi |
| Statistik Perusahaan | Mengatur angka, prefix, suffix, label, ikon, dan urutan statistik |
| Tentang Kami | Mengatur konten profil perusahaan, media, tombol, posisi konten, dan daftar fitur |
| Layanan | Mengatur layanan, slug, deskripsi, media, varian tampilan, SEO, dan status unggulan |
| Kategori Portofolio | Mengelompokkan portofolio berdasarkan kategori dan slug |
| Portofolio | Mengatur proyek, klien, teknologi, media, layout, SEO, dan galeri gambar |
| Testimoni | Mengatur identitas pemberi testimoni, rating, sumber, foto, dan varian kartu |
| Media Sosial | Mengatur platform, label, URL, ikon, status, dan urutan tautan |

Semua resource mendukung pencarian, sorting, filter, pagination, tampilan detail, soft delete, restore, dan force delete. `AboutSection` memiliki relation manager untuk fitur, sedangkan `Portfolio` memiliki relation manager untuk galeri gambar.

## Arsitektur Aplikasi

Struktur penting:

```text
app/
├── Enums/                 Nilai pilihan dan label tampilan
├── Filament/
│   ├── Pages/             Halaman singleton settings
│   └── Resources/         Form, table, infolist, page, dan relation manager
├── Models/                Model Eloquent dan scope query
├── Observers/             Invalidasi cache konten
├── Policies/              Otorisasi resource
├── Rules/                 Validasi URL internal/eksternal
├── Services/              Agregasi data landing page dan cache
└── Traits/                Pembersihan media yang tidak lagi digunakan

database/
├── migrations/            Struktur tabel CMS
└── seeders/               Data awal landing page

resources/views/filament/  Blade view halaman settings
tests/Feature/CmsTest.php  Pengujian fitur CMS
```

`App\Services\LandingPageService` merupakan titik akses utama untuk membaca data landing page. Service ini menyediakan method per section serta `getLandingPageData()` untuk mengambil seluruh data sekaligus.

Data disimpan dalam cache selama 3.600 detik. `LandingPageCacheObserver` otomatis membersihkan cache ketika record dibuat, diperbarui, dihapus, dipulihkan, atau dihapus permanen.

## Persyaratan Sistem

Pastikan perangkat memiliki:

- PHP 8.4 beserta extension yang dibutuhkan Laravel
- Composer 2
- Node.js dan npm
- MySQL
- Web server lokal atau Laravel Herd

Jangan menjalankan server Artisan apabila aplikasi dibuka melalui Laravel Herd. Herd otomatis menyediakan site berdasarkan nama folder proyek.

## Instalasi

1. Install dependency PHP:

```bash
composer install
```

2. Buat file environment.

Linux/macOS:

```bash
cp .env.example .env
```

PowerShell:

```powershell
Copy-Item .env.example .env
```

3. Buat application key:

```bash
php artisan key:generate
```

4. Buat database MySQL, lalu sesuaikan konfigurasi berikut di `.env`:

```dotenv
APP_NAME="CMS Haseera"
APP_URL=http://cms-haseera.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cms_haseera
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan `APP_URL` dengan domain lokal atau production yang digunakan.

5. Jalankan migration dan seeder:

```bash
php artisan migrate
php artisan db:seed
```

Seeder aman dijalankan berulang kali dan tidak membuat user admin. Data akhir default:

| Data | Jumlah |
|---|---:|
| Landing page setting | 1 |
| Call to action setting | 1 |
| Menu navigasi | 5 |
| Hero | 2 |
| Statistik perusahaan | 4 |
| Section Tentang Kami | 1 |
| Fitur Tentang Kami | 4 |
| Layanan | 4 |
| Kategori portofolio | 3 |
| Portofolio | 6 |
| Testimoni | 4 |
| Media sosial | 4 |

6. Buat symbolic link untuk media publik:

```bash
php artisan storage:link
```

7. Install dependency frontend dan build asset:

```bash
npm install
npm run build
```

8. Buat user admin:

```bash
php artisan make:filament-user
```

Ikuti prompt untuk mengisi nama, email, dan password.

9. Buka panel admin:

```text
http://cms-haseera.test/admin
```

Gunakan domain sesuai `APP_URL` pada environment masing-masing.

## Pengembangan Lokal

Untuk hot reload asset:

```bash
npm run dev
```

Laravel Herd sudah menjalankan PHP dan web server. Jika tidak menggunakan Herd, workflow bawaan Composer tersedia melalui:

```bash
composer run dev
```

Perintah tersebut menjalankan development server, queue listener, dan Vite secara bersamaan.

## Media

Seluruh upload gambar menggunakan disk `public` dan disimpan sebagai relative path di database. Folder upload dikelompokkan di bawah:

```text
storage/app/public/landing-page/
├── about/
├── branding/
├── cta/
├── hero/
├── portfolios/
├── seo/
├── services/
└── testimonials/
```

Ketentuan upload:

- Maksimal 5 MB per file
- Format JPEG, PNG, atau WebP
- Field media bersifat nullable
- File lama dibersihkan ketika media diganti
- Media terkait dibersihkan ketika record dihapus permanen

Pastikan `APP_URL` benar dan `php artisan storage:link` sudah dijalankan agar preview media dapat diakses.

## Model dan Relasi

Relasi utama:

```text
AboutSection
└── hasMany AboutFeature

PortfolioCategory
└── hasMany Portfolio
    └── hasMany PortfolioImage
```

Model konten menyediakan scope sesuai kebutuhan, antara lain:

- `active()` untuk record aktif
- `ordered()` untuk mengurutkan berdasarkan `sort_order`
- `featured()` untuk konten unggulan
- `published()` untuk hero aktif yang jadwal publikasinya sudah berlaku

Slug layanan, kategori portofolio, dan portofolio dibuat otomatis saat create apabila field slug kosong. Slug manual tetap dipertahankan dan validasi form mengabaikan record aktif saat edit.

## Validasi URL

`InternalOrExternalUrl` menerima:

- Anchor, misalnya `#contact`
- Path internal, misalnya `/services`
- URL HTTP atau HTTPS yang valid

Skema lain seperti FTP ditolak. Field tombol yang berpasangan mewajibkan teks ketika URL diisi dan mewajibkan URL ketika teks diisi.

## Testing

Jalankan seluruh test:

```bash
php artisan test --compact
```

Menjalankan test tertentu:

```bash
php artisan test --compact --filter=NamaTest
```

Test mencakup:

- Idempotensi seeder
- Singleton settings
- Scope aktif, urutan, unggulan, dan publikasi
- Relasi model
- Pembuatan slug unik
- Validasi URL
- Cache dan invalidasinya
- Cast enum
- Cascade delete
- Akses panel dan halaman Filament

## Code Style

Format file PHP:

```bash
vendor/bin/pint --format agent
```

Periksa formatting tanpa mengubah file:

```bash
vendor/bin/pint --test --format agent
```

## Perintah Operasional

```bash
# Membersihkan cache framework
php artisan optimize:clear

# Melihat route
php artisan route:list

# Melihat status migration
php artisan migrate:status

# Menjalankan migration yang belum diterapkan
php artisan migrate --force

# Mengisi ulang data default secara idempotent
php artisan db:seed --force

# Build asset production
npm run build
```

Jangan menggunakan `migrate:fresh` atau `db:wipe` pada database yang berisi data penting karena keduanya menghapus data.

## Deployment

Checklist deployment minimum:

1. Gunakan PHP 8.4 dan database MySQL yang didukung.
2. Atur `APP_ENV=production`, `APP_DEBUG=false`, dan `APP_URL` yang benar.
3. Gunakan credential database, mail, cache, queue, dan storage production.
4. Jalankan `composer install --no-dev --optimize-autoloader`.
5. Jalankan `php artisan migrate --force`.
6. Jalankan `php artisan storage:link` jika memakai public disk lokal.
7. Jalankan `npm ci && npm run build`.
8. Jalankan optimasi Laravel sesuai kebutuhan environment.
9. Konfigurasikan worker apabila queue digunakan.
10. Pastikan direktori `storage` dan `bootstrap/cache` dapat ditulis oleh proses web.

Laravel Cloud dapat digunakan sebagai opsi deployment Laravel terkelola.

## Keamanan dan Otorisasi

Saat ini model `User` yang berhasil login dapat mengakses panel dan policy dasar mengizinkan seluruh operasi CRUD, termasuk restore dan force delete. Konfigurasi ini ditujukan untuk tahap pengembangan lokal.

Sebelum production:

- Terapkan role dan permission granular
- Batasi force delete kepada administrator tertentu
- Terapkan kebijakan password dan lifecycle akun
- Konfigurasikan HTTPS, cookie, session, dan rate limiting
- Audit akses upload serta jenis file
- Gunakan backup database dan media yang terjadwal

Authentication yang digunakan adalah authentication bawaan Filament/Laravel. Seeder tidak membuat akun admin secara otomatis.

## Batasan Saat Ini

- Tidak ada frontend landing page dalam repository ini
- Tidak ada API publik untuk mengirim data CMS ke frontend terpisah
- Authorization belum granular dan belum siap production
- Default dashboard masih menggunakan widget bawaan Filament
- Asset frontend hanya digunakan untuk kebutuhan aplikasi CMS

## Troubleshooting

### Perubahan UI tidak terlihat

```bash
php artisan optimize:clear
npm run build
```

Untuk pengembangan aktif, gunakan `npm run dev`.

### Gambar tidak tampil

Pastikan symbolic link tersedia dan URL aplikasi benar:

```bash
php artisan storage:link
php artisan config:show app.url
```

### Route atau komponen Filament masih memakai cache lama

```bash
php artisan optimize:clear
php artisan route:list
```

### Migration belum lengkap

```bash
php artisan migrate:status
php artisan migrate
```

### Memeriksa log aplikasi

Log Laravel tersedia di:

```text
storage/logs/laravel.log
```

## Lisensi

Project menggunakan lisensi MIT.
