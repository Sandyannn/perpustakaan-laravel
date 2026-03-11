<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{

    protected $table = 'peminjamans';
    protected $fillable = [
        'buku_id',
        'user_id',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
        'status_peminjaman'
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
