<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data user lama agar tidak bentrok
        User::truncate();

        // 1. Akun Super Admin
        User::create([
            'name'     => 'Super Admin MyCash',
            'email'    => 'admin@mycash.com',
            'password' => Hash::make('password123'),
            'role'     => 'super_admin',
            'status'   => 'aktif',
        ]);

        // 2. Akun Bendahara
        User::create([
            'name'     => 'Bendahara Kelas',
            'email'    => 'bendahara@mycash.com',
            'password' => Hash::make('password123'),
            'role'     => 'bendahara',
            'status'   => 'aktif',
        ]);

        // 3. Akun Wali Kelas
        User::create([
            'name'     => 'Wali Kelas 10-A',
            'email'    => 'walikelas@mycash.com',
            'password' => Hash::make('password123'),
            'role'     => 'wali_kelas',
            'status'   => 'aktif',
        ]);

        // 4. Akun Siswa
        User::create([
            'name'     => 'Budi Santoso (Siswa)',
            'email'    => 'siswa@mycash.com',
            'password' => Hash::make('password123'),
            'role'     => 'siswa',
            'status'   => 'aktif',
        ]);
    }
}