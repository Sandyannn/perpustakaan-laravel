<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KoleksiPribadi extends Model
{
    protected $fillable = [
        'buku_id',
        'user_id',
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
