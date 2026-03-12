<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6 shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <div class="md:flex">
                    <div class="md:w-1/3 bg-gray-200 flex items-center justify-center p-8">
                         <div class="text-center">
                            <svg class="w-32 h-32 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <p class="mt-4 text-gray-500 font-bold uppercase tracking-wider text-sm">{{ $buku->penerbit }}</p>
                            <div class="mt-2 inline-block px-3 py-1 rounded bg-white text-xs font-bold text-gray-600 shadow-sm">
                                Stok: {{ $buku->stok }}
                            </div>
                         </div>
                    </div>
                    <div class="md:w-2/3 p-8">
                        <div class="flex justify-between items-start">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 leading-tight">{{ $buku->judul }}</h1>
                                <p class="text-xl text-gray-600 mt-2">{{ $buku->penulis }} <span class="text-gray-400">({{ $buku->tahun_terbit }})</span></p>
                            </div>
                            
                            <form action="{{ route('koleksi.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                                <button type="submit" class="text-pink-500 hover:text-pink-700 transition transform hover:scale-110" title="Simpan ke Koleksi">
                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>

                        <div class="mt-6 flex flex-wrap gap-2">
                            @foreach($buku->kategoris as $k)
                                <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">
                                    {{ $k->nama_kategori }}
                                </span>
                            @endforeach
                        </div>

                        <div class="mt-8 border-t pt-6">
                            @if($buku->stok > 0)
                                <form action="{{ route('peminjaman.store', $buku->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="jumlah" class="block text-sm font-bold text-gray-700 mb-2">Jumlah Buku yang Dipinjam:</label>
                                        <input type="number" name="jumlah" id="jumlah" min="1" max="{{ $buku->stok }}" value="1" 
                                            class="w-24 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="text-xs text-gray-400 ml-2 italic">* Maksimal {{ $buku->stok }} buku</span>
                                    </div>
                                    
                                    <button type="submit" 
                                        class="w-full bg-indigo-600 text-white font-extrabold py-4 rounded-lg hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                                        PINJAM BUKU SEKARANG
                                    </button>
                                </form>
                            @else
                                <div class="bg-red-50 text-red-600 p-4 rounded-lg text-center font-bold border border-red-200">
                                    Maaf, Stok Buku Sedang Kosong
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="border-t p-8 bg-gray-50">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-800">Ulasan Pembaca</h3>
                        <div class="text-sm text-gray-500 font-medium">
                            Total: {{ $buku->ulasanBukus->count() }} Ulasan
                        </div>
                    </div>

                    @forelse($buku->ulasanBukus as $ulasan)
                        <div class="bg-white p-5 rounded-xl shadow-sm mb-4 border border-gray-100">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white text-xs font-bold">
                                        {{ strtoupper(substr($ulasan->user->name, 0, 1)) }}
                                    </div>
                                    <span class="font-bold text-gray-700">{{ $ulasan->user->name }}</span>
                                </div>
                                <div class="flex text-yellow-400">
                                    @for($i=1; $i<=5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $ulasan->rating ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-gray-600 leading-relaxed italic text-sm">"{{ $ulasan->ulasan }}"</p>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-gray-400 italic">Belum ada ulasan untuk buku ini. Jadilah yang pertama memberikan ulasan!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>