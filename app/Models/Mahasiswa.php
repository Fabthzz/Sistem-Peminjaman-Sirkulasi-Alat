<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class mahasiswa extends Model
{
    use HasFactory;
 
    protected $table = 'mahasiswas';
 
    protected $fillable = [
        'nama',
        'jurusan',
    ];
 
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
