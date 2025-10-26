<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembershipController extends Controller
{
    /**
     * Menampilkan daftar anggota yang perlu persetujuan.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $selectedOrgId = $request->query('organization_id');
        $organizations = [];

        // Query dasar untuk pendaftar 'pending'
        $query = Membership::with(['user', 'organization'])->where('status', 'pending');

        if ($user->role == 'admin_kampus') {
            // Admin bisa memilih organisasi mana yang ingin dilihat
            $organizations = Organization::orderBy('name')->get();
            if ($selectedOrgId) {
                $query->where('organization_id', $selectedOrgId);
            }
        } elseif ($user->role == 'ketua_organisasi') {
            // Ketua hanya bisa melihat pendaftar organisasinya
            $organization = $user->managingOrganization();
            if ($organization) {
                $query->where('organization_id', $organization->id);
            } else {
                $query->where('organization_id', -1); // Trik agar query kosong jika ketua tdk punya org
            }
        }

        $pendingMemberships = $query->latest()->paginate(10);

        return view('memberships.index', compact('pendingMemberships', 'organizations', 'selectedOrgId'));
    }

    /**
     * Menyetujui keanggotaan.
     */
    public function approve(Membership $membership)
    {
        // (Di masa depan, kita cek dengan Policy)
        // $this->authorize('manage', $membership->organization); 

        $membership->update(['status' => 'approved']);

        return redirect()->route('memberships.index')->with('success', 'Anggota telah disetujui.');
    }

    /**
     * Menolak/menghapus keanggotaan.
     * INI YANG DIPERBAIKI (sebelumnya: publicS-function)
     */
    public function reject(Membership $membership)
    {
        // (Di masa depan, kita cek dengan Policy)
        // $this->authorize('manage', $membership->organization);

        $membership->delete();

        return redirect()->route('memberships.index')->with('success', 'Pendaftaran anggota telah ditolak/dihapus.');
    }
}

