<?php

namespace App\Policies;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrganizationPolicy
{
    /**
     * Hanya Admin yang boleh melakukan APA PUN pada Organisasi.
     * Ketua organisasi tidak boleh mengedit/menghapus data organisasi.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'admin_kampus') {
            return true;
        }
        return null;
    }

    // Kode di bawah ini sebenarnya tidak akan pernah dijalankan
    // jika rolenya bukan admin_kampus, tapi ini untuk keamanan ekstra.

    public function viewAny(User $user): bool
    {
        return $user->role === 'admin_kampus';
    }
    
    public function view(User $user, Organization $organization): bool
    {
        return $user->role === 'admin_kampus';
    }
    
    public function create(User $user): bool
    {
        return $user->role === 'admin_kampus';
    }
    
    public function update(User $user, Organization $organization): bool
    {
        return $user->role === 'admin_kampus';
    }
    
    public function delete(User $user, Organization $organization): bool
    {
        return $user->role === 'admin_kampus';
    }
}
