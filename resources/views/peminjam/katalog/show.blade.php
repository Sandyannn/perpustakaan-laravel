<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <div class="md:flex">
                    <div class="md:w-1/3 bg-gray-200 flex items-center justify-center p-8">
                         <div class="text-center">
                            <svg class="w-32 h-32 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            <p class="mt-4 text-gray-500 font-bold uppercase">{{ $buku->penerbit }}</p>
                         </div>
                    </div>
                    <div class="md:w-2/3 p-8">
                        <div class="flex justify-between items-start">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">{{ $buku->judul }}</h1>
                                <p class="text-xl text-gray-600 mt-2">{{ $buku->penulis }} ({{ $buku->tahun_terbit }})</p>
                            </div>
                            <form action="{{ route('koleksi.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                                <button type="submit" class="text-pink-500 hover:text-pink-700">
                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path></svg>
                                </button>
                            </form>
                        </div>

                        <div class="mt-6 flex gap-2">
                            @foreach($buku->kategoris as $k)
                                <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm font-medium">{{ $k->nama_kategori }}</span>
                            @endforeach
                        </div>

                        <div class="mt-8">
                            <form action="{{ route('peminjaman.store', $buku->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-700 transition">PINJAM BUKU SEKARANG</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="border-t p-8 bg-gray-50">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Ulasan Pembaca</h3>
                    @forelse($buku->ulasanBukus as $ulasan)
                        <div class="bg-white p-4 rounded-lg shadow-sm mb-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-bold text-gray-700">{{ $ulasan->user->name }}</span>
                                <span class="text-yellow-500 font-bold">⭐ {{ $ulasan->rating }}/5</span>
                            </div>
                            <p class="text-gray-600">{{ $ulasan->ulasan }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500 italic">Belum ada ulasan untuk buku ini.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>