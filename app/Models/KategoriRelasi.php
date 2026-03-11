<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriRelasi extends Model
{
    protected $fillable = [
        'buku_id',
        'kategori_buku_id',
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriBuku::class);
    }
}
