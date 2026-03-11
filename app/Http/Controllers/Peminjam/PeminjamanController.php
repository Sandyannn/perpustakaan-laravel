<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::where('user_id', auth()->id())->with('buku')->get();
        return view('peminjam.peminjaman.index', compact('peminjamans'));
    }

    public function store(Request $request, $bukuId)
    {
        $buku = Buku::findOrFail($bukuId);

        if ($buku->stok <= 0) {
            return redirect()->back()->with('error', 'Maaf, stok buku ini sedang habis.');
        }
        Peminjaman::create([
            'user_id' => auth()->id(),
            'buku_id' => $bukuId,
            'tanggal_peminjaman' => Carbon::now(),
            'status_peminjaman' => 'dipinjam',
        ]);

        $buku->decrement('stok');

        return redirect()->route('peminjaman.index')->with('success', 'Buku berhasil dipinjam.');
    }

    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        if ($peminjaman->status_peminjaman == 'dipinjam') {
            $peminjaman->update([
                'tanggal_pengembalian' => now(),
                'status_peminjaman' => 'dikembalikan',
            ]);

            $peminjaman->buku->increment('stok');

            return redirect()->back()->with('success', 'Buku telah dikembalikan, stok diperbarui.');
        }

        return redirect()->back()->with('success', 'Buku telah dikembalikan.');
    }
}
