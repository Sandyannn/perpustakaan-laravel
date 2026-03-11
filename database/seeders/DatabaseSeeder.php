<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name'      => 'Admin Perpustakaan',
            'username'  => 'admin',
            'email'     => 'admin@digitalibrary.com',
            'password'  => Hash::make('password'),
            'role'      => 'administrator',
            'alamat'    => 'Malang, Jawa Timur',
        ]);

        User::create([
            'name'      => 'Petugas Satu',
            'username'  => 'petugas',
            'email'     => 'petugas@digitalibrary.com',
            'password'  => Hash::make('password'),
            'role'      => 'petugas',
            'alamat'    => 'Malang, Jawa Timur',
        ]);

        User::create([
            'name'      => 'Siswa Peminjam',
            'username'  => 'peminjam',
            'email'     => 'siswa@gmail.com',
            'password'  => Hash::make('password'),
            'role'      => 'peminjam',
            'alamat'    => 'Malang, Jawa Timur',
        ]);

        $informatika = KategoriBuku::create(['nama_kategori' => 'Informatika']);
        $fiksi = KategoriBuku::create(['nama_kategori' => 'Fiksi']);
        $sains = KategoriBuku::create(['nama_kategori' => 'Sains']);

        $buku1 = Buku::create([
            'judul'        => 'Belajar Laravel 11',
            'penulis'      => 'Taylor Otwell',
            'penerbit'     => 'Open Source',
            'tahun_terbit' => 2024,
        ]);

        $buku2 = Buku::create([
            'judul'        => 'Laskar Pelangi',
            'penulis'      => 'Andrea Hirata',
            'penerbit'     => 'Bentang Pustaka',
            'tahun_terbit' => 2005,
        ]);

        $buku1->kategoris()->attach($informatika->id);
        $buku2->kategoris()->attach($fiksi->id);
    }
}