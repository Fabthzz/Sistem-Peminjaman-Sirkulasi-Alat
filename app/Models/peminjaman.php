<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'mahasiswa_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'denda',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function details()
    {
        return $this->hasMany(PeminjamanDetail::class, 'peminjaman_id', 'id');
    }
}