<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $kategoris = KategoriBuku::all();
        
        $query = Buku::with(['kategoris', 'ulasanBukus']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('penulis', 'like', '%' . $search . '%');
            });
        }

        if ($request->has('kategori') && $request->kategori != '') {
            $query->whereHas('kategoris', function($q) use ($request) {
                $q->where('kategori_bukus.id', $request->kategori);
            });
        }

        $bukus = $query->latest()->get();

        return view('peminjam.katalog.index', compact('bukus', 'kategoris'));
    }

    public function show(Buku $buku)
    {
        $buku->load(['kategoris', 'ulasanBukus.user']);
        return view('peminjam.katalog.show', compact('buku'));
    }
}
