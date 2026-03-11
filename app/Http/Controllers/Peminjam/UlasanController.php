<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\UlasanBuku;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'ulasan' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        UlasanBuku::create([
            'user_id' => auth()->id(),
            'buku_id' => $request->buku_id,
            'ulasan' => $request->ulasan,
            'rating' => $request->rating,
        ]);

        return redirect()->back()->with('success', 'Terima kasih atas ulasannya!');
    }
}
