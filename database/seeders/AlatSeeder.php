<?php

namespace Database\Seeders;

use App\Models\Alat;
use Illuminate\Database\Seeder;

class AlatSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_alat' => 'Mouse',           'stok' => 10, 'dipinjam' => 0],
            ['nama_alat' => 'Keyboard',         'stok' => 8,  'dipinjam' => 0],
            ['nama_alat' => 'Proyektor',        'stok' => 3,  'dipinjam' => 0],
            ['nama_alat' => 'Kabel HDMI',       'stok' => 5,  'dipinjam' => 0],
        ];

        foreach ($data as $item) {
            Alat::firstOrCreate(['nama_alat' => $item['nama_alat']], $item);
        }
    }
}