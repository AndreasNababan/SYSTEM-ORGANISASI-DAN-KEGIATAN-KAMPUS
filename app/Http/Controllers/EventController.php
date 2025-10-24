<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Menampilkan daftar kegiatan.
     * Logika: Admin melihat semua, Ketua Organisasi melihat milik organisasinya.
     */
    public function index()
    {
        $user = Auth::user();
        $query = Event::with('organization')->latest();

        if ($user->role == 'ketua_organisasi') {
            $organization = $user->managingOrganization();
            if ($organization) {
                $query->where('organization_id', $organization->id);
            } else {
                // Jika dia ketua tapi belum diapprove/tidak punya org, jangan tampilkan apa-apa
                $query->where('organization_id', -1); // Trik agar query kosong
            }
        }
        // Admin akan skip 'if' ini dan mendapatkan semua event

        $events = $query->paginate(10);
        return view('events.index', compact('events'));
    }

    /**
     * Menampilkan form untuk membuat event baru.
     */
    public function create()
    {
        $user = Auth::user();
        $organizations = [];

        if ($user->role == 'admin_kampus') {
            // Admin bisa memilih organisasi
            $organizations = Organization::orderBy('name')->get();
        }

        return view('events.create', compact('organizations'));
    }

    /**
     * Menyimpan event baru.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('poster', 'organization_id');

        // Tentukan organization_id
        if ($user->role == 'admin_kampus') {
            $request->validate(['organization_id' => 'required|exists:organizations,id']);
            $data['organization_id'] = $request->organization_id;
        } else {
            // Ambil org yang dia kelola
            $organization = $user->managingOrganization();
            if (!$organization) {
                return back()->with('error', 'Anda tidak terdaftar sebagai ketua organisasi yang valid.');
            }
            $data['organization_id'] = $organization->id;
        }

        // Handle file upload
        if ($request->hasFile('poster')) {
            $path = $request->file('poster')->store('public/posters');
            $data['poster'] = str_replace('public/', '', $path);
        }

        Event::create($data);

        return redirect()->route('events.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }


    /**
     * Menampilkan form untuk edit event.
     */
    public function edit(Event $event)
    {
        // Di langkah selanjutnya (PR #2), kita akan gunakan Policy untuk mengecek ini.
        // $this->authorize('update', $event);

        $user = Auth::user();
        $organizations = [];

        if ($user->role == 'admin_kampus') {
            $organizations = Organization::orderBy('name')->get();
        }

        return view('events.edit', compact('event', 'organizations'));
    }

    /**
     * Update event di database.
     */
    public function update(Request $request, Event $event)
    {
        // $this->authorize('update', $event);

        $user = Auth::user();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('poster', 'organization_id');

        // Admin bisa ganti organisasi, ketua tidak
        if ($user->role == 'admin_kampus') {
            $request->validate(['organization_id' => 'required|exists:organizations,id']);
            $data['organization_id'] = $request->organization_id;
        }
        
        // (Logika update poster sama seperti store)
        // ...

        $event->update($data);

        return redirect()->route('events.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    /**
     * Hapus event.
     */
    public function destroy(Event $event)
    {
        // $this->authorize('delete', $event);

        // (Logika hapus file poster dari storage)
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Kegiatan berhasil dihapus.');
    }
}
