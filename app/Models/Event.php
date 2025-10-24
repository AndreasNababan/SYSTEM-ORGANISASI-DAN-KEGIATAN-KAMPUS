<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['organization_id', 'title', 'description', 'date', 'location', 'poster'];

    // Relasi: Satu kegiatan milik satu organisasi
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    // Relasi: Satu kegiatan punya banyak peserta (via pivot table)
    public function participants()
    {
        return $this->belongsToMany(User::class, 'event_registrations')
                    ->withPivot('attended') // (optional QR code)
                    ->withTimestamps();
    }
}