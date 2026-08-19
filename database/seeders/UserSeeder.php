<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin user
        User::create([
            'nik' => '1234567890123456',
            'name' => 'System Administrator',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('admin123'),
            'role' => 'Admin',
            'no_hp' => '081234567890',
            'is_active' => true,
        ]);

        // Create Petugas (Officer) user
        User::create([
            'nik' => '1234567890123457',
            'desa_id' => 7,
            'name' => 'Community Officer',
            'email' => 'petugas@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('petugas123'),
            'role' => 'Petugas',
            'no_hp' => '081234567891',
            'is_active' => true,
        ]);

        // Create Warga (Resident) user
        User::create([
            'nik' => '1234567890123458',
            'desa_id' => 7,
            'name' => 'Regular Resident',
            'email' => 'warga@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('warga123'),
            'role' => 'Warga',
            'no_hp' => '081234567892',
            'is_active' => true,
        ]);
    }
}
