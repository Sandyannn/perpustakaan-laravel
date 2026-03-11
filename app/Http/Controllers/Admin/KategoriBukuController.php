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
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori',
        ]);

        KategoriBuku::create($validatedData);

        return redirect()->route('kategori.index')->with('success', 'Kategori buku berhasil ditambahkan.');
    }

    public function show(KategoriBuku $kategoriBuku)
    {
        return view('admin.kategori.show', compact('kategoriBuku'));
    }

    public function edit(KategoriBuku $kategoriBuku)
    {
        return view('admin.kategori.edit', compact('kategoriBuku'));
    }

    public function update(Request $request, KategoriBuku $kategoriBuku)
    {
        $validatedData = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $kategoriBuku->id,
        ]);

        $kategoriBuku->update($validatedData);

        return redirect()->route('kategori.index')->with('success', 'Kategori buku berhasil diperbarui.');
    }

    public function destroy(KategoriBuku $kategoriBuku)
    {
        $kategoriBuku->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori buku berhasil dihapus.');
    }
}
