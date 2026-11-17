# Sistem Informasi Desa Ciranjeng

**Sistem Informasi Desa Ciranjeng** merupakan aplikasi berbasis web yang dikembangkan untuk menyediakan informasi mengenai profil, pemerintahan, potensi, kegiatan, dan perkembangan Desa Ciranjeng.

Aplikasi ini bertujuan untuk mempermudah masyarakat dalam memperoleh informasi desa serta membantu pengelolaan konten informasi secara digital.

## Fitur Utama

- **Profil Desa** — Menampilkan informasi umum dan gambaran mengenai Desa Ciranjeng.
- **Struktur Pemerintahan** — Menampilkan susunan perangkat dan organisasi pemerintahan desa.
- **Berita Desa** — Menyajikan informasi dan dokumentasi kegiatan desa.
- **Pengumuman** — Menyampaikan informasi penting kepada masyarakat.
- **Agenda Kegiatan** — Menampilkan jadwal dan kegiatan desa.
- **Statistik Desa** — Menyajikan informasi data dan statistik desa.
- **Potensi Desa** — Memperkenalkan potensi unggulan desa, termasuk sektor pertanian dan bawang merah.
- **UMKM Desa** — Menampilkan informasi usaha mikro, kecil, dan menengah di desa.
- **Galeri** — Menampilkan dokumentasi foto kegiatan dan lingkungan desa.
- **Manajemen Konten** — Pengelolaan informasi dan konten melalui halaman administrator.

## Teknologi yang Digunakan

| Teknologi | Kegunaan |
|---|---|
| PHP | Bahasa pemrograman backend |
| Laravel 12 | Framework aplikasi |
| MySQL | Basis data |
| JavaScript | Interaksi antarmuka |
| HTML5 & CSS3 | Struktur dan tampilan website |

## Persyaratan Sistem

- PHP 8.2 atau lebih baru
- Composer
- MySQL
- Node.js dan NPM
- Web browser

## Instalasi

1. Clone repository:

   ```bash
   git clone https://github.com/rizki12-cyber/sistem-informasi-desa.git
   ```

2. Masuk ke direktori project:

   ```bash
   cd sistem-informasi-desa
   ```

3. Install dependency:

   ```bash
   composer install
   npm install
   ```

4. Salin file konfigurasi:

   ```powershell
   Copy-Item .env.example .env
   ```

5. Buat application key:

   ```bash
   php artisan key:generate
   ```

6. Buat database MySQL, kemudian sesuaikan konfigurasi `.env`:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. Jalankan migrasi:

   ```bash
   php artisan migrate
   ```

8. Build asset frontend:

   ```bash
   npm run build
   ```

9. Jalankan aplikasi:

   ```bash
   php artisan serve
   ```

10. Buka melalui browser:

   ```text
   http://127.0.0.1:8000
   ```

## Tentang Desa Ciranjeng

Desa Ciranjeng memiliki potensi di sektor pertanian, khususnya komoditas bawang merah. Potensi tersebut menjadi salah satu informasi unggulan yang diperkenalkan melalui aplikasi ini.

## Pengembang

**Rizki**

Dikembangkan sebagai project pengembangan aplikasi web untuk mendukung digitalisasi informasi dan pelayanan informasi desa.

## Lisensi

Project ini merupakan project pengembangan dan portofolio pribadi.