<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail; // Nonaktifkan jika tidak pakai verifikasi email
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Organization; // Import yang sudah Anda tambahkan

class User extends Authenticatable
{
    /**
     * !! PENTING: Traits HARUS diletakkan di paling atas class body !!
     */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Pastikan role ada di sini
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    // ===============================================
    // ==== METHOD RELASI (Letakkan di bawah sini) ====
    // ===============================================

    /**
     * Relasi untuk semua organisasi di mana user ini terdaftar.
     */
    public function memberships()
    {
        return $this->belongsToMany(Organization::class, 'memberships')
                    ->withPivot('role', 'status')
                    ->withTimestamps();
    }

    /**
     * Method helper untuk mengambil organisasi YANG DIA KETUAI.
     * Kita asumsikan seorang user hanya bisa jadi ketua di 1 organisasi.
     */
    public function managingOrganization()
    {
        // Mengambil organisasi pertama dimana user ini adalah 'ketua_organisasi' dan statusnya 'approved'
        return $this->memberships()
                    ->wherePivot('role', 'ketua_organisasi')
                    ->wherePivot('status', 'approved')
                    ->first();
    }
}

