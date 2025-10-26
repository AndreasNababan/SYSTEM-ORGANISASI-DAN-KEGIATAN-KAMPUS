<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // <-- Pastikan ini ada

class OrganizationController extends Controller
{
    use AuthorizesRequests; // <-- Pastikan ini ada

    // Kita authorize di setiap method

    /**
     * Menampilkan daftar organisasi.
     */
    public function index()
    {
        // Policy: Hanya admin_kampus yang boleh lihat daftar semua organisasi
        $this->authorize('viewAny', Organization::class);

        $organizations = Organization::latest()->paginate(10);
        return view('organizations.index', compact('organizations'));
    }

    /**
     * Menampilkan form untuk membuat organisasi baru.
     */
    public function create()
    {
        // Policy: Hanya admin_kampus yang boleh create
        $this->authorize('create', Organization::class);

        return view('organizations.create');
    }

    /**
     * Menyimpan organisasi baru ke database.
     */
    public function store(Request $request)
    {
        // Policy: Hanya admin_kampus yang boleh store (sama dengan create)
        $this->authorize('create', Organization::class);

        $request->validate([
            'name' => 'required|string|max:255|unique:organizations',
            'description' => 'required|string',
            'contact' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('public/logos');
            $data['logo'] = str_replace('public/', '', $path);
        }

        Organization::create($data);

        return redirect()->route('organizations.index')->with('success', 'Organisasi berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail (belum diimplementasikan)
     */
    public function show(Organization $organization)
    {
        // Policy: Hanya admin_kampus yang boleh lihat detail
        $this->authorize('view', $organization);

         return view('organizations.show', compact('organization')); // Contoh
    }

    /**
     * Menampilkan form untuk edit organisasi.
     */
    public function edit(Organization $organization)
    {
        // Policy: Hanya admin_kampus yang boleh edit
        $this->authorize('update', $organization);

        return view('organizations.edit', compact('organization'));
    }

    /**
     * Update organisasi di database.
     */
    public function update(Request $request, Organization $organization)
    {
        // Policy: Hanya admin_kampus yang boleh update
        $this->authorize('update', $organization);

        $request->validate([
            'name' => 'required|string|max:255|unique:organizations,name,' . $organization->id,
            'description' => 'required|string',
            'contact' => 'nullable|string|max:255',
             'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Kecualikan logo dan delete_logo dari data awal
        $data = $request->except(['logo', 'delete_logo']);

        // ==== LOGIKA HAPUS LOGO (BARU) ====
        if ($request->filled('delete_logo') && $request->delete_logo == '1') {
            // Hapus logo lama jika ada
            if ($organization->logo) {
                Storage::delete('public/' . $organization->logo);
            }
            // Set kolom logo di DB jadi null
            $data['logo'] = null; // Pastikan logo di-update jadi null
        }
        // ==== BATAS LOGIKA HAPUS ====

        // ==== LOGIKA UPLOAD LOGO BARU ====
        // Hanya jalankan jika TIDAK menghapus logo
        elseif ($request->hasFile('logo')) {
            // Hapus logo lama jika ada (jika user ganti logo)
            if ($organization->logo) {
                Storage::delete('public/' . $organization->logo);
            }
            // Simpan logo baru
            $path = $request->file('logo')->store('public/logos');
            $data['logo'] = str_replace('public/', '', $path);
        }
        // Jika tidak ada file baru DAN tidak minta hapus, kolom logo tidak diubah (tidak masuk ke $data)

        $organization->update($data); // Update data organisasi

        return redirect()->route('organizations.index')->with('success', 'Organisasi berhasil diperbarui.');
    } // <-- Akhir method update


    /**
     * Hapus organisasi.
     */
    public function destroy(Organization $organization)
    {
        // Policy: Hanya admin_kampus yang boleh delete
        $this->authorize('delete', $organization);

         if ($organization->logo) {
             Storage::delete('public/' . $organization->logo);
         }

        $organization->delete();
        return redirect()->route('organizations.index')->with('success', 'Organisasi berhasil dihapus.');
    }

    /**
     * Menampilkan daftar anggota untuk sebuah organisasi.
     */
    public function showMembers(Organization $organization)
    {
        // Policy: Hanya admin_kampus yang boleh lihat anggota (gunakan 'update' sbg izin)
        $this->authorize('update', $organization);

        $members = $organization->members()
                                ->orderBy('pivot_status', 'desc')
                                ->orderBy('name', 'asc')
                                ->paginate(15);

        return view('organizations.members', compact('organization', 'members'));
    }
}