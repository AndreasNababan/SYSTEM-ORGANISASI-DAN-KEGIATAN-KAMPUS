<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // <-- TAMBAHAN BARU
use App\Models\Organization;        // <-- TAMBAHAN BARU
use App\Models\Event;               // <-- TAMBAHAN BARU

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute Halaman Depan (Publik)
Route::get('/', function () {
    return view('welcome');
});

// =================================================================
// Rute Dashboard (INI YANG KITA UBAH)
// =================================================================
Route::get('/dashboard', function () {
    $user = Auth::user();
    $stats = [];
    $upcomingEvents = collect(); // Default koleksi kosong

    // Logika untuk Admin Kampus
    if ($user->role == 'admin_kampus') {
        $stats['totalOrganizations'] = Organization::count();
        $stats['totalEvents'] = Event::count();
        $upcomingEvents = Event::with('organization')
                            ->where('date', '>=', now()) // Acara yang akan datang
                            ->orderBy('date', 'asc')
                            ->take(5) // Ambil 5 terdekat
                            ->get();
    } 
    // Logika untuk Ketua Organisasi
    elseif ($user->role == 'ketua_organisasi') {
        $organization = $user->managingOrganization(); // Method dari User.php
        if ($organization) {
            $stats['totalEvents'] = $organization->events()->count();
            $upcomingEvents = $organization->events()
                                ->where('date', '>=', now())
                                ->orderBy('date', 'asc')
                                ->take(5)
                                ->get();
            $stats['organizationName'] = $organization->name;
        } else {
            // Jika akun ketuanya belum diapprove
            $stats['totalEvents'] = 0;
            $stats['organizationName'] = "Organisasi (Pending Approval)";
        }
    }
    // Logika untuk Mahasiswa Biasa
    elseif ($user->role == 'mahasiswa') {
        // Mahasiswa melihat semua acara yang akan datang
         $upcomingEvents = Event::with('organization')
                            ->where('date', '>=', now())
                            ->orderBy('date', 'asc')
                            ->take(5)
                            ->get();
    }

    // Kirim data ke view dashboard
    return view('dashboard', [
        'stats' => $stats,
        'upcomingEvents' => $upcomingEvents
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');
// =================================================================
// BATAS PERUBAHAN
// =================================================================


// Rute Profile (Hanya untuk yang sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// --- GRUP KHUSUS ADMIN KAMPUS ---
Route::middleware(['auth', 'verified', 'role:admin_kampus'])->group(function () {
    // CRUD Organisasi
    Route::resource('organizations', OrganizationController::class);
});

// --- GRUP ADMIN & KETUA ORGANISASI ---
Route::middleware(['auth', 'verified', 'role:admin_kampus,ketua_organisasi'])->group(function () {
    // CRUD Kegiatan
    Route::resource('events', EventController::class);
});


// Rute Autentikasi (Login, Register, dll)
require __DIR__.'/auth.php';

