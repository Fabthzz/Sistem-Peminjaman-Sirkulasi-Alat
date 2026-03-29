<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'user_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'denda',
    ];

    // 🔥 RELASI BARU
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function details()
    {
        return $this->hasMany(PeminjamanDetail::class, 'peminjaman_id', 'id');
    }
}