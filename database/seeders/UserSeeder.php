<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Akun Admin Kampus
        User::create([
            'name' => 'Pak Admin',
            'email' => 'admin@kampus.com',
            'password' => Hash::make('password'),
            'role' => 'admin_kampus', // Pastikan kolom ini sesuai database kamu
        ]);

        // 2. Buat Akun Ketua Organisasi
        User::create([
            'name' => 'Ketua BEM',
            'email' => 'ketua@bem.com',
            'password' => Hash::make('password'),
            'role' => 'ketua_organisasi',
        ]);

        // 3. Buat Akun Mahasiswa Biasa
        User::create([
            'name' => 'Budi Mahasiswa',
            'email' => 'budi@mhs.com',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
        ]);
    }
}