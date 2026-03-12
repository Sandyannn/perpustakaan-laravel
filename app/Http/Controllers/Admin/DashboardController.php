<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\User;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_buku'      => Buku::count(),
            'total_user'      => User::where('role', 'peminjam')->count(),
            'total_petugas'   => User::where('role', 'petugas')->count(),
            'pinjaman_aktif'  => Peminjaman::where('status', 'dipinjam')->count(),
            'recent_orders'   => Peminjaman::with(['user', 'buku'])->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('data'));
    }
}
