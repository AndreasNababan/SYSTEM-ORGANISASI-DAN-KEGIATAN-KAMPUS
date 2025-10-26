<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\MembershipController; // <-- PASTIKAN INI ADA
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Organization;
use App\Models\Event;
use App\Models\Membership; // <-- PASTIKAN INI ADA

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
// Rute Dashboard
// =================================================================
Route::get('/dashboard', function () {
    $user = Auth::user();
    $stats = [];
    $upcomingEvents = collect();
    $myOrganizations = collect(); // <-- Tambahan baru

    // Logika untuk Admin Kampus
    if ($user->role == 'admin_kampus') {
        $stats['totalOrganizations'] = Organization::count();
        $stats['totalEvents'] = Event::count();
        $upcomingEvents = Event::with('organization')
                            ->where('date', '>=', now())
                            ->orderBy('date', 'asc')
                            ->take(5)
                            ->get();
    }
    // Logika untuk Ketua Organisasi
    elseif ($user->role == 'ketua_organisasi') {
        $organization = $user->managingOrganization();
        if ($organization) {
            $stats['totalEvents'] = $organization->events()->count();
            $upcomingEvents = $organization->events()
                                        ->where('date', '>=', now())
                                        ->orderBy('date', 'asc')
                                        ->take(5)
                                        ->get();
            $stats['organizationName'] = $organization->name;
        } else {
            $stats['totalEvents'] = 0;
            $stats['organizationName'] = "Organisasi (Pending Approval)";
        }
    }
    // Logika untuk Mahasiswa Biasa
    elseif ($user->role == 'mahasiswa') {
         $upcomingEvents = Event::with('organization')
                            ->where('date', '>=', now())
                            ->orderBy('date', 'asc')
                            ->take(5)
                            ->get();

        // (INI TAMBAHAN BARU) Ambil organisasi yang dia ikuti
        $myOrganizations = $user->membershipRecords()->with('organization')->get();
    }

    // Kirim data ke view dashboard
    return view('dashboard', [
        'stats' => $stats,
        'upcomingEvents' => $upcomingEvents,
        'myOrganizations' => $myOrganizations // <-- Variabel baru
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
     // ==== TAMBAHAN BARU (LANGKAH 2) ====
    Route::get('/organizations/{organization}/members', [OrganizationController::class, 'showMembers'])->name('organizations.members');
});

// --- GRUP ADMIN & KETUA ORGANISASI ---
Route::middleware(['auth', 'verified', 'role:admin_kampus,ketua_organisasi'])->group(function () {
    // CRUD Kegiatan
    Route::resource('events', EventController::class);
    // Rute Keanggotaan
    Route::get('/memberships', [MembershipController::class, 'index'])->name('memberships.index');
    Route::patch('/memberships/{membership}/approve', [MembershipController::class, 'approve'])->name('memberships.approve');
    Route::delete('/memberships/{membership}/reject', [MembershipController::class, 'reject'])->name('memberships.reject');
    // Rute Daftar Peserta Event
    Route::get('/events/{event}/participants', [EventController::class, 'showParticipants'])->name('events.participants');
});

// --- RUTE UNTUK MAHASISWA (CARI ORGANISASI & EVENT) ---
Route::middleware(['auth', 'verified', 'role:mahasiswa'])->group(function () {
    // Rute Cari Organisasi
    Route::get('/cari-organisasi', [PublicController::class, 'listOrganizations'])->name('organizations.browse');
    Route::post('/organisasi/{organization}/join', [PublicController::class, 'joinOrganization'])->name('organizations.join');

    // Rute Daftar Event
    Route::get('/daftar-event', [PublicController::class, 'listEvents'])->name('events.list');
    Route::post('/event/{event}/register', [PublicController::class, 'registerForEvent'])->name('events.register');
});


// Rute Autentikasi (Login, Register, dll)
require __DIR__.'/auth.php';