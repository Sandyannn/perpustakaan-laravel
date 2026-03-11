<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Kategori Buku') }}
            </h2>
            <a href="{{ route('kategori.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm">
                + Tambah Kategori
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white p-6 rounded-lg shadow">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-3 w-16">No</th>
                            <th class="p-3">Nama Kategori</th>
                            <th class="p-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategoriBukus as $index => $kategori)
                        <tr class="border-b">
                            <td class="p-3 text-gray-600">{{ $index + 1 }}</td>
                            <td class="p-3 font-semibold">{{ $kategori->nama_kategori }}</td>
                            <td class="p-3 flex justify-center gap-4">
                                <a href="{{ route('kategori.edit', $kategori->id) }}" class="text-yellow-600 hover:text-yellow-800 font-bold">Edit</a>
                                <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" onsubmit="return confirm('Menghapus kategori juga akan berdampak pada relasi buku. Yakin?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800 font-bold">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="p-4 text-center text-gray-500 italic">Belum ada data kategori.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>