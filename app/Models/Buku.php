<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'jumlah_buku',
        'stok',
    ];

    public function kategoris()
    {
        return $this->belongsToMany(KategoriBuku::class, 'kategori_relasis', 'buku_id', 'kategori_buku_id');
    }

    public function ulasanBukus()
    {
        return $this->hasMany(UlasanBuku::class);
    }

    public function koleksiPribadis()
    {
        return $this->hasMany(KoleksiPribadi::class);
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
