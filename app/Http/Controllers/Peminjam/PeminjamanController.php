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
        $peminjamans = Peminjaman::where('user_id', auth()->id())->with('buku')->latest()->get();
        return view('peminjam.peminjaman.index', compact('peminjamans'));
    }

    public function store(Request $request, $bukuId)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $buku = Buku::findOrFail($bukuId);
        $jumlahPinjam = $request->jumlah;

        if ($buku->stok < $jumlahPinjam) {
            return redirect()->back()->with('error', "Maaf, stok tidak mencukupi. Stok tersisa: {$buku->stok}");
        }

        Peminjaman::create([
            'user_id' => auth()->id(),
            'buku_id' => $bukuId,
            'jumlah' => $jumlahPinjam,
            'tanggal_pinjam' => Carbon::now(),
            'status' => 'Dipinjam',
            'total_biaya' => 0,
        ]);

        $buku->decrement('stok', $jumlahPinjam);

        return redirect()->route('peminjaman.index')->with('success', "Berhasil meminjam {$jumlahPinjam} buku.");
    }

    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status == 'Dipinjam') {

            $peminjaman->update([
                'status' => 'proses_kembali',
                'tanggal_kembali' => now(),
            ]);

            return redirect()->back()->with('success', 'Permintaan pengembalian dikirim. Silahkan serahkan buku ke petugas untuk diverifikasi.');
        }

        return redirect()->back()->with('info', 'Status peminjaman ini sedang diproses atau sudah selesai.');
    }
}
