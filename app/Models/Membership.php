<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Organization;

class Membership extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     */
    protected $table = 'memberships';

    /**
     * Kolom yang boleh diisi.
     */
    protected $fillable = ['user_id', 'organization_id', 'role', 'status'];

    /**
     * Relasi ke model User (Anggota).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Organization.
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}

