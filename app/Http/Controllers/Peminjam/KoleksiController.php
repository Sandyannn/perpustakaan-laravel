<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\KoleksiPribadi;
use Illuminate\Http\Request;

class KoleksiController extends Controller
{
    public function index()
    {
        $koleksis = KoleksiPribadi::where('user_id', auth()->id())
                    ->with('buku')
                    ->get();
        return view('peminjam.koleksi.index', compact('koleksis'));
    }

    public function store(Request $request)
    {
        $request->validate(['buku_id' => 'required|exists:bukus,id']);

        KoleksiPribadi::firstOrCreate([
            'user_id' => auth()->id(),
            'buku_id' => $request->buku_id,
        ]);

        return redirect()->back()->with('success', 'Buku ditambahkan ke koleksi pribadi.');
    }

    public function destroy($id)
    {
        $koleksi = KoleksiPribadi::where('user_id', auth()->id())->findOrFail($id);
        $koleksi->delete();

        return redirect()->back()->with('success', 'Buku dihapus dari koleksi.');
    }
}
