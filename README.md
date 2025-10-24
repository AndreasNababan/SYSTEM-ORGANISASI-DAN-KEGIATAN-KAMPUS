Sistem Informasi Organisasi Kampus (SIOK)Ini adalah sebuah proyek sistem informasi berbasis web yang dibangun untuk mengelola organisasi dan kegiatan di lingkungan kampus. Sistem ini dibuat menggunakan Laravel 11.Fitur UtamaSistem ini memiliki beberapa fitur inti yang dibagi berdasarkan peran pengguna:1. Manajemen Organisasi (Khusus Admin Kampus)CRUD (Create, Read, Update, Delete) data organisasi kampus.Mengelola data utama seperti Nama Organisasi, Logo, Deskripsi, dan Kontak.2. Manajemen Kegiatan (Admin & Ketua Organisasi)CRUD (Create, Read, Update, Delete) data kegiatan atau event.Admin dapat membuat kegiatan untuk organisasi manapun.Ketua Organisasi hanya dapat membuat kegiatan untuk organisasi yang dia pimpin.3. Sistem Autentikasi & Peran (Role)Sistem ini menggunakan sistem autentikasi bawaan Laravel Breeze dan memiliki 3 peran utama:admin_kampus: Memiliki akses penuh ke semua data, termasuk menambah organisasi baru dan mengelola semua kegiatan.ketua_organisasi: Dapat mengelola kegiatan dan (nantinya) anggota dari organisasinya sendiri.mahasiswa: Peran default saat registrasi, dapat melihat dashboard dan (nantinya) mendaftar kegiatan.4. Dashboard DinamisHalaman dashboard menampilkan ringkasan statistik yang berbeda-beda sesuai dengan peran (role) pengguna yang sedang login.Menampilkan daftar kegiatan terdekat yang akan datang.Teknologi yang DigunakanFramework: Laravel 11Bahasa: PHP 8.2+Database: MySQLFrontend: Laravel BladeStyling: TailwindCSSBundler: ViteAutentikasi: Laravel BreezePanduan Instalasi LokalBerikut adalah langkah-langkah untuk menjalankan proyek ini di komputer Anda.Prasyarat:PHP 8.2+ComposerNode.js & NPMServer MySQLLangkah-langkah:Clone repository ini:git clone [https://github.com/](https://github.com/)[USERNAME-ANDA]/[NAMA-REPO-ANDA].git
cd [NAMA-REPO-ANDA]
Salin file .env:Proyek ini menggunakan .env.example. Buat salinannya.cp .env.example .env
Instal dependensi Composer (PHP):composer install
Instal dependensi NPM (CSS/JS):npm install
Generate Kunci Aplikasi Laravel:php artisan key:generate
Konfigurasi Database:Buka file .env Anda.Buat sebuah database baru di MySQL (misal: si_organisasi_kampus).Atur koneksi database di file .env:DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=si_organisasi_kampus
DB_USERNAME=root
DB_PASSWORD= # (Sesuaikan dengan password Anda)
Jalankan Migrasi Database:Perintah ini akan membuat semua tabel yang dibutuhkan di database Anda.php artisan migrate
Buat Storage Link:Agar file yang di-upload (seperti logo) dapat diakses.php artisan storage:link
Jalankan Server:Anda perlu menjalankan dua server secara bersamaan di dua terminal terpisah.Terminal 1 (Server PHP):php artisan serve
Terminal 2 (Server Vite/CSS):npm run dev
Selesai!Buka aplikasi di http://127.0.0.1:8000.Cara Membuat Akun AdminBuka http://127.0.0.1:8000/register dan daftarkan akun baru.Secara default, peran (role) Anda adalah mahasiswa.Buka database Anda (misal: phpMyAdmin), masuk ke tabel users.Cari user yang baru Anda daftarkan dan ubah nilai di kolom role dari mahasiswa menjadi admin_kampus.Refresh dashboard. Anda sekarang memiliki akses admin.
