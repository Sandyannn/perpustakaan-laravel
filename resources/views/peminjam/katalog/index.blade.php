<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Katalog Buku Perpustakaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <form action="{{ route('dashboard') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari judul atau penulis..."
                        class="flex-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500">

                    <select name="kategori" class="rounded-md border-gray-300 shadow-sm">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoris as $k)
                            <option value="{{ $k->id }}" {{ request('kategori') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>

                    <button type="submit"
                        class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700">Filter</button>
                </form>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($bukus as $buku)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                        <div class="h-48 bg-gray-200 flex items-center justify-center text-gray-400">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>

                        <div class="p-4 flex-1">
                            <div class="flex gap-1 mb-2 flex-wrap">
                                @foreach ($buku->kategoris as $k)
                                    <span
                                        class="bg-indigo-100 text-indigo-800 text-[10px] px-2 py-0.5 rounded-full">{{ $k->nama_kategori }}</span>
                                @endforeach
                            </div>
                            <h3 class="font-bold text-lg text-gray-900 leading-tight mb-1">{{ $buku->judul }}</h3>
                            <p class="text-sm text-gray-600 mb-4 italic">Oleh: {{ $buku->penulis }}</p>
                        </div>

                        <div class="p-4 border-t bg-gray-50 flex gap-2">
                            <a href="{{ route('katalog.show', $buku->id) }}"
                                class="flex-1 text-center bg-white border border-indigo-600 text-indigo-600 px-3 py-2 rounded text-sm font-semibold hover:bg-indigo-50">Detail</a>
                            @if ($buku->stok > 0)
                                <form action="{{ route('peminjaman.store', $buku->id) }}" method="POST"
                                    class="flex-1">
                                    @csrf
                                    <button type="submit"
                                        class="w-full bg-indigo-600 text-white px-3 py-2 rounded text-sm font-semibold hover:bg-indigo-700">Pinjam</button>
                                </form>
                            @else
                                <button
                                    class="flex-1 bg-gray-400 text-white px-3 py-2 rounded text-sm font-semibold cursor-not-allowed"
                                    disabled>Habis</button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 italic">Buku tidak ditemukan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
