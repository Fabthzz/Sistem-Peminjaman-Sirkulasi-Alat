<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    use HasFactory;

    protected $table = 'alat';

    protected $fillable = [
        'nama_alat',
        'stok',
        'dipinjam',
    ];

    // Accessor: sisa stok
    public function getSisaStokAttribute(): int
    {
        return max(0, $this->stok - $this->dipinjam);
    }

    public function peminjaman_Details()
    {
        return $this->hasMany(PeminjamanDetail::class, 'peminjaman_id', 'id');
    }
}
