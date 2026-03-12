<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;

class KategoriBukuController extends Controller
{
    public function index()
    {
        $kategoriBukus = KategoriBuku::latest()->get();
        return view('admin.kategori.index', compact('kategoriBukus'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_bukus,nama_kategori',
        ]);

        KategoriBuku::create($validatedData);

        return redirect()->route('kategori.index')->with('success', 'Kategori buku berhasil ditambahkan.');
    }

    public function show(KategoriBuku $kategori)
    {
        $kategori->load('bukus');

        return view('admin.kategori.show', compact('kategori'));
    }

    public function edit(KategoriBuku $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, KategoriBuku $kategori)
    {
        $validatedData = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_bukus,nama_kategori,' . $kategori->id,
        ]);

        $kategori->update($validatedData);

        return redirect()->route('kategori.index')->with('success', 'Kategori buku berhasil diperbarui.');
    }

    public function destroy(KategoriBuku $kategori)
    {
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori buku berhasil dihapus.');
    }
}
