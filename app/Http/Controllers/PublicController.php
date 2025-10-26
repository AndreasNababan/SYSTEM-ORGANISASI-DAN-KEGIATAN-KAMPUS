<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Event; // <-- TAMBAHKAN
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
    /**
     * Menampilkan daftar semua organisasi untuk mahasiswa.
     */
    public function listOrganizations()
    {
        $user = Auth::user();
        // Ambil ID data user dan ID organisasi tempat dia sudah mendaftar (pending atau approved)
        $joinedOrganizationIds = $user->memberships()->pluck('organization_id')->toArray();

        // Ambil semua organisasi, dan tandai mana yang sudah di-join
        $organizations = Organization::latest()->paginate(10);

        return view('public.organizations-list', compact('organizations', 'joinedOrganizationIds'));
    }

    /**
     * Memproses permintaan "Gabung" dari mahasiswa.
     */
    public function joinOrganization(Organization $organization)
    {
        $user = Auth::user();

        // Cek apakah user sudah terdaftar (pending atau approved)
        $isMember = $user->memberships()->where('organization_id', $organization->id)->exists();

        if ($isMember) {
            // Jika sudah, kembalikan dengan pesan info
            return redirect()->route('organizations.browse')->with('info', 'Anda sudah terdaftar di organisasi ini.');
        }

        // Jika belum, daftarkan user ke organisasi dengan status 'pending' dan role 'anggota'
        $user->memberships()->attach($organization->id, [
            'role' => 'anggota',
            'status' => 'pending' // Status default adalah 'pending'
        ]);

        // Kembalikan dengan pesan sukses
        return redirect()->route('organizations.browse')->with('success', 'Berhasil mengirim permintaan gabung ke ' . $organization->name . '. Mohon tunggu persetujuan.');
    }


    // ===============================================
    // ==== TAMBAHAN BARU (LANGKAH 2) ====
    // ===============================================

    /**
     * Menampilkan daftar semua event untuk mahasiswa.
     */
    public function listEvents()
    {
        $user = Auth::user();
        // Ambil ID event yang sudah didaftari
        $registeredEventIds = $user->attendedEvents()->pluck('event_id')->toArray();

        // Ambil semua event yang AKAN DATANG (belum lewat)
        $events = Event::with('organization')
                        ->where('date', '>=', now())
                        ->orderBy('date', 'asc')
                        ->paginate(9); // Ubah jadi 9 agar pas 3 kolom

        return view('public.events-list', compact('events', 'registeredEventIds'));
    }

    /**
     * Memproses pendaftaran event oleh mahasiswa.
     */
    public function registerForEvent(Event $event)
    {
        $user = Auth::user();

        // Cek apakah user sudah terdaftar
        $isRegistered = $user->attendedEvents()->where('event_id', $event->id)->exists();

        if ($isRegistered) {
            return redirect()->route('events.list')->with('info', 'Anda sudah terdaftar di event ini.');
        }

        // Daftarkan user ke event
        $user->attendedEvents()->attach($event->id);

        return redirect()->route('events.list')->with('success', 'Berhasil mendaftar untuk event: ' . $event->title);
    }
}