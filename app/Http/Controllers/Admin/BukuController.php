<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::with('kategoris')->latest()->get();
        return view('admin.buku.index', compact('bukus'));
    }

    public function create()
    {
        $kategoris = KategoriBuku::all();
        return view('admin.buku.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'penerbit'     => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|digits:4',
            'kategori_ids' => 'required|array',
            'kategori_ids.*' => 'exists:kategori_bukus,id',
            'stok' => 'required|integer|min:0',
        ]);

        $buku = Buku::create([
            'judul'        => $validatedData['judul'],
            'penulis'      => $validatedData['penulis'],
            'penerbit'     => $validatedData['penerbit'],
            'tahun_terbit' => $validatedData['tahun_terbit'],
            'stok' => $validatedData['stok'],
        ]);

        $buku->kategoris()->sync($request->kategori_ids);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Buku $buku)
    {
        $kategoris = KategoriBuku::all();
        return view('admin.buku.edit', compact('buku', 'kategoris'));
    }

    public function update(Request $request, Buku $buku)
    {
        $validatedData = $request->validate([
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'penerbit'     => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|digits:4',
            'kategori_ids' => 'required|array',
            'kategori_ids.*' => 'exists:kategori_bukus,id',
            'stok' => 'required|integer|min:0',
        ]);

        $buku->update([
            'judul'        => $validatedData['judul'],
            'penulis'      => $validatedData['penulis'],
            'penerbit'     => $validatedData['penerbit'],
            'tahun_terbit' => $validatedData['tahun_terbit'],
            'stok' => $validatedData['stok'],
        ]);

        $buku->kategoris()->sync($request->kategori_ids);

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}