# Sistem Informasi Organisasi Kampus (SIOK)

Proyek Sistem Informasi Organisasi Kampus (SIOK) adalah platform berbasis web untuk mendukung pengelolaan organisasi dan kegiatan kampus. Sistem ini dibangun menggunakan Laravel 11 dengan dukungan autentikasi dan peran pengguna yang jelas untuk meningkatkan efisiensi dan transparansi kegiatan kampus.

---

## 🚀 Fitur Utama

### 1. Manajemen Organisasi *(Admin Kampus)*
- CRUD data organisasi kampus
- Kelola informasi utama: Nama, Logo, Deskripsi, Kontak

### 2. Manajemen Kegiatan *(Admin & Ketua Organisasi)*
- CRUD data kegiatan atau event kampus
- Admin dapat mengelola semua kegiatan
- Ketua organisasi hanya mengelola kegiatan dari organisasinya sendiri

### 3. Sistem Autentikasi & Role
Menggunakan Laravel Breeze dengan 3 peran pengguna:
| Peran | Akses |
|------|------|
| `admin_kampus` | Penuh, mengelola organisasi & semua kegiatan |
| `ketua_organisasi` | Mengelola kegiatan & anggota organisasinya |
| `mahasiswa` | Melihat dashboard dan mendaftar kegiatan (pengembangan) |

### 4. Dashboard Dinamis
Dashboard akan menampilkan statistik dan event berbeda sesuai peran pengguna yang login.

---

## 🛠️ Teknologi yang Digunakan

| Kategori | Teknologi |
|---------|-----------|
| Framework | Laravel 11 |
| Bahasa | PHP 8.2+ |
| Database | MySQL |
| Frontend | Blade |
| Styling | TailwindCSS |
| Bundler | Vite |
| Autentikasi | Laravel Breeze |

---

## 📦 Instalasi Lokal

### ✅ Prasyarat
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL Server

### 🔧 Langkah Instalasi
```bash
git clone https://github.com/AndreasNababan/SYSTEM-ORGANISASI-DAN-KEGIATAN-KAMPUS.git
cd NAMA-REPO-ANDA
cp .env.example .env
composer install
npm install
php artisan key:generate
```

### ⚙️ Konfigurasi Database
Buat database MySQL baru, lalu sesuaikan konfigurasi di file `.env`:
```
DB_DATABASE=si_organisasi_kampus
DB_USERNAME=root
DB_PASSWORD=
```

Lalu jalankan migrasi:
```bash
php artisan migrate
```

Aktifkan storage untuk file upload:
```bash
php artisan storage:link
```

### ▶️ Menjalankan Proyek
Jalankan dua terminal:
```bash
php artisan serve
npm run dev
```

Akses melalui:
👉 http://127.0.0.1:8000

---

## 🧑‍💻 Membuat Akun Admin

1. Register akun melalui halaman register
2. Akses database lalu ubah kolom `role` user menjadi `admin_kampus`
3. Refresh dashboard untuk melihat akses admin

---

## 📌 Status Proyek
✅ Tahap Pengembangan Awal  
🛠️ Akan ditambahkan:
- Manajemen anggota organisasi
- Pendaftaran kegiatan oleh mahasiswa
- Notifikasi kegiatan

---

## 📜 Lisensi
Proyek ini mengikuti lisensi sesuai repositori GitHub masing-masing.

---

Terima kasih telah menggunakan Sistem Informasi Organisasi Kampus! 🎓✨
Saran dan kontribusi sangat terbuka.
