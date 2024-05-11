<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';
    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
        'tanggal_peminjaman' => 'datetime:d-m-Y',
        'tanggal_pengembalian' => 'datetime:d-m-Y',
        'tanggal_dikembalikan' => 'datetime:d-m-Y',
    ];

     // Relasi dengan model Anggota
     public function anggota()
     {
         return $this->belongsTo(Anggota::class, 'anggota_id');
     }
 
     // Relasi many-to-many dengan model Buku melalui tabel pivot
     public function bukus()
     {
         return $this->belongsToMany(Buku::class, 'peminjaman_buku', 'peminjaman_id', 'buku_id');
     }

}
