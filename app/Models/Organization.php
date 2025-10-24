<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logo', 'description', 'contact'];

    // Relasi: Satu organisasi punya banyak kegiatan
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    // Relasi: Satu organisasi punya banyak anggota (via pivot table)
    public function members()
    {
        return $this->belongsToMany(User::class, 'memberships')
                    ->withPivot('role', 'status') // role (ketua, wakil), status (pending, approved)
                    ->withTimestamps();
    }
}
