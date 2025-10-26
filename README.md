# 🎓 Sistem Informasi Organisasi Kampus (SIOK)

SIOK adalah sebuah **web-based Campus Organization Information System** yang dibangun untuk mengelola organisasi dan kegiatan kampus secara terpusat.  
Dibuat menggunakan **Laravel 11**, **TailwindCSS**, dan **Laravel Breeze** untuk autentikasi.

---

## 🚀 Fitur Utama

### 🔹 1) Manajemen Organisasi *(Admin Kampus)*  
- CRUD data organisasi  
- Upload, preview, dan hapus Logo  
- Kelola deskripsi & kontak  
- Lihat anggota tiap organisasi (approved & pending)

### 🔹 2) Manajemen Kegiatan/Event *(Admin & Ketua Organisasi)*  
- CRUD data Event  
- Upload poster + preview  
- Admin dapat kelola semua Event  
- Ketua hanya kelola Event organisasinya (via Policy)  
- Lihat daftar peserta Event  

### 🔹 3) Sistem Keanggotaan Organisasi  
- Mahasiswa bisa daftar organisasi  
- Admin/Ketua dapat Approve/Reject pendaftar

### 🔹 4) Pendaftaran Event  
- Mahasiswa bisa daftar sebagai peserta  
- Tombol otomatis disabled jika sudah mendaftar

### 🔹 5) Autentikasi & Role  
Menggunakan Laravel Breeze dengan 3 role utama:

| Role | Akses |
|------|------|
| `admin_kampus` | Full access: organisasi, semua event, keanggotaan |
| `ketua_organisasi` | Kelola event & keanggotaan organisasi sendiri |
| `mahasiswa` | Bisa daftar organisasi dan event |

### 🔹 6) Dashboard Dinamis  
Menampilkan informasi berbeda untuk tiap role 🎯

### 🔹 7) User Interface
- Blade + TailwindCSS  
- Dark Mode menyeluruh  
- Navigasi menyesuaikan role pengguna  

---

## 🛠️ Teknologi yang Digunakan

| Kategori | Teknologi | Deskripsi |
|---------|-----------|-----------|
| Backend | Laravel 11 | MVC, Routing, ORM, dsb |
|  | PHP 8.2+ | Server-side programming |
|  | MySQL/MariaDB | Database Relasional |
|  | Eloquent ORM | Interaksi model–database |
|  | Middleware, Policies | Otorisasi & filtering request |
| Frontend | TailwindCSS | Utility-first CSS |
|  | Alpine.js | JavaScript interaktif kecil |
|  | Blade | View templating |
| Build Tools | Vite | Bundler modern |
| Tools | Git + GitHub | Version control |
|  | VS Code | Editor development |
|  | Composer + NPM | Dependency manager |
| Env | XAMPP/Laragon | Local server & DB |

---

## 📦 Instalasi Lokal

### ✅ Prasyarat
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL Server

### 🔧 Setup
```bash
git clone https://github.com/[USERNAME-ANDA]/[NAMA-REPO-ANDA].git
cd [NAMA-REPO-ANDA]
cp .env.example .env
composer install
npm install
php artisan key:generate
```

### ⚙️ Konfigurasi Database
```
DB_DATABASE=si_organisasi_kampus
DB_USERNAME=root
DB_PASSWORD=
```

Lalu:
```bash
php artisan migrate
php artisan storage:link
```

---

## ▶️ Menjalankan Proyek

Terminal 1:
```bash
php artisan serve
```

Terminal 2:
```bash
npm run dev
```

Akses: http://127.0.0.1:8000 ✅

---

## 👑 Membuat Akun Admin

1. Daftar melalui `/register`
2. Buka tabel `users` di database
3. Set kolom `role` menjadi `admin_kampus`
4. Refresh halaman dashboard

---

## ✅ Status Proyek

| Fitur | Status |
|------|:-----:|
| CRUD Organisasi & Event | ✅ |
| Role & Autentikasi | ✅ |
| Dashboard Dinamis | ✅ |
| Keanggotaan Organisasi | ✅ |
| Pendaftaran Event | ✅ |
| UI Dark Mode | ✅ |
| Preview & Hapus File Upload | ✅ |

---

## 🧩 Pengembangan Selanjutnya

- ✅ Role anggota organisasi lebih detail (Ketua/Wakil/Sekretaris)
- 🔄 Verifikasi kehadiran event (QR Code)
- 🔄 Notifikasi event & pendaftaran baru
- 🔄 Halaman detail Event/Organisasi lebih kaya
- 🔄 Pencarian & filter data
  (Kalo Ada Waktu Luang Di Tamabahin)

---

## 📜 Lisensi

SIOK dirilis dengan **MIT License**  
(atau sesuai file lisensi pada repository GitHub)

---

🎉 Terima kasih telah menggunakan Sistem Informasi Organisasi Kampus!  
Kontribusi dan feedback sangat kami hargai! 🙌
