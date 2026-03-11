<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;

class LaporanController extends Controller
{
    public function index()
    {
        $laporans = Peminjaman::with(['user', 'buku'])->latest()->get();
        return view('admin.laporan.index', compact('laporans'));
    }
}
