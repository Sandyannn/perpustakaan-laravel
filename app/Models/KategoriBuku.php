<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriBuku extends Model
{

    protected $table = 'kategori_bukus';

    protected $fillable = [
        'nama_kategori',
    ];

    public function bukus()
    {
        return $this->belongsToMany(Buku::class, 'kategori_relasis', 'kategori_id', 'buku_id');
    }
}
