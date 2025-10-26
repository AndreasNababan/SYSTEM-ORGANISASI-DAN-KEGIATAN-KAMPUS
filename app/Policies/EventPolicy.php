<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EventPolicy
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
     * Siapa yang boleh membuat event baru?
     * (Hanya Admin dan Ketua Organisasi)
     */
    public function create(User $user): bool
    {
        return in_array($user->role, ['admin_kampus', 'ketua_organisasi']);
    }

    /**
     * Siapa yang boleh mengupdate event?
     * (Hanya Admin, atau Ketua Organisasi JIKA event itu miliknya)
     */
    public function update(User $user, Event $event): bool
    {
        // Admin sudah diizinkan oleh 'before'
        
        // Cek untuk Ketua Organisasi
        $managingOrg = $user->managingOrganization();
        if (!$managingOrg) {
            return false; // Dia bukan ketua organisasi yang valid
        }
        
        // Cek kepemilikan
        return $managingOrg->id === $event->organization_id;
    }

    /**
     * Siapa yang boleh menghapus event?
     * (Logikanya sama dengan update)
     */
    public function delete(User $user, Event $event): bool
    {
        $managingOrg = $user->managingOrganization();
        if (!$managingOrg) {
            return false;
        }
        
        return $managingOrg->id === $event->organization_id;
    }
}
