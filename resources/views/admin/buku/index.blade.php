<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Buku') }}
            </h2>
            <a href="{{ route('buku.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                + Tambah Buku
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white p-6 rounded-lg shadow">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-3">Judul</th>
                            <th class="p-3">Penulis</th>
                            <th class="p-3">Kategori</th>
                            <th class="p-3">Tahun</th>
                            <th class="p-3">Aksi</th>
                            <th class="p-3">stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bukus as $buku)
                            <tr class="border-b">
                                <td class="p-3 font-bold">{{ $buku->judul }}</td>
                                <td class="p-3">{{ $buku->penulis }}</td>
                                <td class="p-3">
                                    @foreach ($buku->kategoris as $k)
                                        <span
                                            class="bg-gray-200 px-2 py-1 rounded text-xs">{{ $k->nama_kategori }}</span>
                                    @endforeach
                                </td>
                                <td class="p-3 text-center">
                                    @if ($buku->stok <= 2)
                                        <span class="text-red-600 font-bold">{{ $buku->stok }} (Kritis)</span>
                                    @else
                                        <span class="text-gray-700">{{ $buku->stok }}</span>
                                    @endif
                                </td>
                                <td class="p-3">{{ $buku->tahun_terbit }}</td>
                                <td class="p-3 flex gap-2">
                                    <a href="{{ route('buku.edit', $buku->id) }}"
                                        class="text-yellow-600 font-bold">Edit</a>
                                    <form action="{{ route('buku.destroy', $buku->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 font-bold">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
