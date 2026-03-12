<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'buku']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->filled('tgl_mulai') && $request->filled('tgl_selesai')) {
            $query->whereBetween('tanggal_pinjam', [$request->tgl_mulai, $request->tgl_selesai]);
        }

        $laporans = $query->latest()->get();

        return view('admin.laporan.index', compact('laporans'));
    }

    public function verifikasiKembali($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status == 'proses_kembali') {
            $tglPinjam = \Carbon\Carbon::parse($peminjaman->tanggal_pinjam);
            $tglKembaliRealitas = \Carbon\Carbon::now(); 

            $selisihHari = $tglPinjam->diffInDays($tglKembaliRealitas);
            if ($selisihHari == 0) $selisihHari = 1;

            $totalBiaya = $selisihHari * 1000 * $peminjaman->jumlah;

            $peminjaman->update([
                'tanggal_kembali' => $tglKembaliRealitas,
                'status' => 'Dikembalikan',
                'total_biaya' => $totalBiaya,
            ]);

            $peminjaman->buku->increment('stok', $peminjaman->jumlah);

            return redirect()->back()->with('success', 'Verifikasi berhasil. Buku telah masuk kembali ke stok.');
        }

        return redirect()->back()->with('error', 'Data tidak valid untuk diverifikasi.');
    }
}
