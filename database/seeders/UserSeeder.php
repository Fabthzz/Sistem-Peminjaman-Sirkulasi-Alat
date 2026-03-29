<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([
            [
                'nama' => 'Admin SPSA',
                'nim' => '1111111111',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
            ],
            [
                'nama' => 'Mahasiswa',
                'nim' => '2222222222',
                'password' => bcrypt('12345678'),
                'role' => 'mahasiswa',
            ],
        ]);
    }
}