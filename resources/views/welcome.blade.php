<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PerpusDigital - Jelajahi Dunia Lewat Buku</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-900">
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-2">
                    <div class="bg-indigo-600 p-2 rounded-lg text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-gray-900">Perpus<span class="text-indigo-600">Digital</span></span>
                </div>

                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-600 hover:text-indigo-600">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-indigo-600 px-3 py-2">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-full text-sm font-semibold transition shadow-md">Daftar Akun</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="relative overflow-hidden bg-white pt-16 pb-32 space-y-24">
        <div class="relative">
            <div class="lg:mx-auto lg:grid lg:max-w-7xl lg:grid-flow-col-dense lg:grid-cols-2 lg:gap-24 lg:px-8">
                <div class="mx-auto max-w-xl px-4 sm:px-6 lg:mx-0 lg:max-w-none lg:py-16 lg:px-0">
                    <div>
                        <div class="mt-6">
                            <h2 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">
                                Literasi Tanpa Batas, <span class="text-indigo-600">Akses Tanpa Henti.</span>
                            </h2>
                            <p class="mt-4 text-lg text-gray-500">
                                Koleksi buku digital terlengkap untuk mendukung pembelajaran kamu. Mulai dari Novel, Edukasi, hingga Teknologi, semuanya ada di genggamanmu.
                            </p>
                            <div class="mt-6">
                                <a href="#koleksi" class="inline-flex rounded-lg bg-indigo-600 px-6 py-3 text-base font-semibold leading-7 text-white shadow-sm hover:bg-indigo-700 transition">
                                    Lihat Koleksi Buku
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-12 sm:mt-16 lg:mt-0">
                    <div class="pl-4 -mr-48 sm:pl-6 md:-mr-16 lg:relative lg:m-0 lg:h-full lg:px-0">
                        <div class="w-full rounded-xl shadow-xl ring-1 ring-black ring-opacity-5 lg:absolute lg:left-0 lg:h-full lg:w-auto lg:max-w-none bg-gradient-to-tr from-indigo-100 to-indigo-50 flex items-center justify-center">
                             <svg class="w-64 h-64 text-indigo-300 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="koleksi" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 border-t border-gray-100">
        <div class="text-center mb-16">
            <h3 class="text-3xl font-bold tracking-tight text-gray-900">Koleksi Buku Terbaru</h3>
            <p class="mt-4 text-gray-500">Daftar buku pilihan yang baru saja ditambahkan</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($bukus as $buku)
            <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden flex flex-col">
                <div class="aspect-[3/4] bg-indigo-50 flex items-center justify-center relative overflow-hidden">
                    <svg class="w-16 h-16 text-indigo-200 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    
                    <div class="absolute top-4 left-4 flex flex-wrap gap-1">
                        @foreach($buku->kategoris as $kat)
                            <span class="bg-white/90 backdrop-blur px-2 py-1 rounded text-[10px] font-bold text-indigo-600 shadow-sm uppercase tracking-wider">{{ $kat->nama_kategori }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="p-6 flex-1 flex flex-col">
                    <h4 class="text-lg font-bold text-gray-900 leading-snug mb-1 group-hover:text-indigo-600 transition-colors">{{ $buku->judul }}</h4>
                    <p class="text-sm text-gray-500 mb-4">{{ $buku->penulis }}</p>
                    
                    <div class="mt-auto">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-widest">{{ $buku->tahun_terbit }}</span>
                            <span class="px-2 py-1 rounded text-[10px] font-bold {{ $buku->stok > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $buku->stok > 0 ? 'STOK: '.$buku->stok : 'HABIS' }}
                            </span>
                        </div>

                        @auth
                            @if($buku->stok > 0)
                                <form action="{{ route('peminjaman.store', $buku->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 rounded-xl transition text-sm">
                                        Pinjam Sekarang
                                    </button>
                                </form>
                            @else
                                <button class="w-full bg-gray-100 text-gray-400 font-bold py-2.5 rounded-xl text-sm cursor-not-allowed" disabled>
                                    Stok Habis
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="block w-full text-center bg-gray-900 hover:bg-black text-white font-bold py-2.5 rounded-xl transition text-sm">
                                Login untuk Pinjam
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <footer class="bg-white border-t border-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-gray-400 text-sm italic">&copy; {{ date('Y') }} PerpusDigital. SMK Negeri 11 Malang - Program RPL.</p>
        </div>
    </footer>
</body>
</html>