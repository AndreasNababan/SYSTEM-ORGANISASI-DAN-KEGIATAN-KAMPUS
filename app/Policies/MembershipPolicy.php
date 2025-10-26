<?php

namespace App\Policies;

use App\Models\Membership;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MembershipPolicy
{
    /**
     * Izinkan Admin melakukan segalanya.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'admin_kampus') {
            return true;
        }
        return null;
    }

    /**
     * Siapa yang boleh mengelola (approve/reject) keanggotaan?
     * (Hanya Admin, atau Ketua Organisasi JIKA keanggotaan itu milik organisasinya)
     */
    public function manage(User $user, Membership $membership): bool
    {
        // Admin sudah diizinkan oleh 'before'
        
        // Cek untuk Ketua Organisasi
        $managingOrg = $user->managingOrganization();
        if (!$managingOrg) {
            return false; // Dia bukan ketua organisasi yang valid
        }
        
        // Cek kepemilikan
        return $managingOrg->id === $membership->organization_id;
    }
}
