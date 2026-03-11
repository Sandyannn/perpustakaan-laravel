<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Kategori: ') . $kategoriBuku->nama_kategori }}
            </h2>
            <a href="{{ route('kategori.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-sm">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-2">Informasi Kategori</h3>
                    <p class="text-gray-600 text-sm">Nama Kategori: <span class="font-semibold text-gray-900">{{ $kategoriBuku->nama_kategori }}</span></p>
                    <p class="text-gray-600 text-sm">Total Koleksi Buku: <span class="font-semibold text-gray-900">{{ $kategoriBuku->bukus->count() }} Judul</span></p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">Daftar Buku dalam Kategori Ini</h3>
                    
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="p-3 text-sm font-semibold">No</th>
                                <th class="p-3 text-sm font-semibold">Judul Buku</th>
                                <th class="p-3 text-sm font-semibold">Penulis</th>
                                <th class="p-3 text-sm font-semibold text-center">Stok</th>
                                <th class="p-3 text-sm font-semibold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kategoriBuku->bukus as $index => $buku)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="p-3 text-sm text-gray-600">{{ $index + 1 }}</td>
                                    <td class="p-3 text-sm font-bold">{{ $buku->judul }}</td>
                                    <td class="p-3 text-sm italic">{{ $buku->penulis }}</td>
                                    <td class="p-3 text-sm text-center">
                                        <span class="{{ $buku->stok <= 2 ? 'text-red-600 font-bold' : 'text-gray-700' }}">
                                            {{ $buku->stok }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-sm text-center">
                                        <a href="{{ route('buku.edit', $buku->id) }}" class="text-indigo-600 hover:underline">Edit Buku</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-gray-500 italic">
                                        Belum ada buku yang terdaftar dalam kategori ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>