<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    /**
     * Menampilkan daftar organisasi.
     */
    public function index()
    {
        $organizations = Organization::latest()->paginate(10);
        return view('organizations.index', compact('organizations'));
    }

    /**
     * Menampilkan form untuk membuat organisasi baru.
     */
    public function create()
    {
        return view('organizations.create');
    }

    /**
     * Menyimpan organisasi baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'contact' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file upload
        ]);

        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            // Simpan file logo ke storage/app/public/logos
            $path = $request->file('logo')->store('public/logos');
            // Simpan path yang relatif ke database
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
        return view('organizations.show', compact('organization'));
    }

    /**
     * Menampilkan form untuk edit organisasi.
     */
    public function edit(Organization $organization)
    {
        return view('organizations.edit', compact('organization'));
    }

    /**
     * Update organisasi di database.
     */
    public function update(Request $request, Organization $organization)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'contact' => 'nullable|string',
        ]);

        $data = $request->all();

        // (Tambahkan logika update logo jika diperlukan)

        $organization->update($data);

        return redirect()->route('organizations.index')->with('success', 'Organisasi berhasil diperbarui.');
    }

    /**
     * Hapus organisasi.
     */
    public function destroy(Organization $organization)
    {
        // (Tambahkan logika hapus file logo dari storage jika ada)
        $organization->delete();
        return redirect()->route('organizations.index')->with('success', 'Organisasi berhasil dihapus.');
    }
}