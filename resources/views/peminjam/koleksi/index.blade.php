<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Koleksi Buku Favorit Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($koleksis as $koleksi)
                    <div class="bg-white rounded-lg shadow p-4 flex gap-4 items-center">
                        <div class="w-16 h-20 bg-gray-200 rounded flex-shrink-0 flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-900">{{ $koleksi->buku->judul }}</h4>
                            <p class="text-xs text-gray-500">{{ $koleksi->buku->penulis }}</p>
                            
                            <div class="mt-3 flex gap-2">
                                <a href="{{ route('katalog.show', $koleksi->buku_id) }}" class="text-xs text-indigo-600 font-bold">Detail</a>
                                
                                <form action="{{ route('koleksi.destroy', $koleksi->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs text-red-600 font-bold" onclick="return confirm('Hapus dari favorit?')">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-10 text-center rounded-lg shadow">
                        <p class="text-gray-500 italic">Belum ada buku di koleksi favoritmu.</p>
                        <a href="{{ route('dashboard') }}" class="text-indigo-600 underline text-sm mt-2 inline-block">Cari buku sekarang</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>