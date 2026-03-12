<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Laporan Peminjaman Buku') }}
            </h2>
            
            <button onclick="window.print()" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg text-sm flex items-center shadow-md transition print:hidden">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 00-2 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Cetak Laporan
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Filter Data (Hidden saat Print) --}}
            <div class="bg-white p-6 rounded-xl shadow-sm mb-6 print:hidden border border-gray-100">
                <form action="{{ route('laporan.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-2 tracking-wider">Status Buku</label>
                        <select name="status" class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                            <option value="">Semua Status</option>
                            <option value="DIPINJAM" {{ request('status') == 'DIPINJAM' ? 'selected' : '' }}>📖 Dipinjam</option>
                            <option value="PROSES_KEMBALI" {{ request('status') == 'PROSES_KEMBALI' ? 'selected' : '' }}>⏳ Proses Kembali</option>
                            <option value="DIKEMBALIKAN" {{ request('status') == 'DIKEMBALIKAN' ? 'selected' : '' }}>✅ Dikembalikan</option>
                        </select>
                    </div>

                    <div class="flex-1 min-w-[150px]">
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-2 tracking-wider">Dari Tanggal</label>
                        <input type="date" name="tgl_mulai" value="{{ request('tgl_mulai') }}" 
                            class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 shadow-sm">
                    </div>

                    <div class="flex-1 min-w-[150px]">
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-2 tracking-wider">Sampai Tanggal</label>
                        <input type="date" name="tgl_selesai" value="{{ request('tgl_selesai') }}" 
                            class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 shadow-sm">
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg text-sm font-bold shadow-sm transition">
                            Filter
                        </button>
                        <a href="{{ route('laporan.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-5 py-2 rounded-lg text-sm font-bold transition">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- Alert Notifikasi --}}
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 shadow-sm print:hidden">
                    <span class="font-bold">Berhasil!</span> {{ session('success') }}
                </div>
            @endif

            {{-- Area Konten & Tabel --}}
            <div class="bg-white p-8 rounded-xl shadow-sm overflow-hidden border border-gray-100" id="printableArea">
                
                {{-- Kop Surat (Hanya muncul saat Print) --}}
                <div class="hidden print:block text-center mb-10">
                    <h1 class="text-2xl font-black uppercase tracking-widest text-gray-900">Laporan Perpustakaan Digital</h1>
                    <p class="text-sm text-gray-600 mt-1">SMKN 11 Malang - Rekapitulasi Data Transaksi Buku</p>
                    <div class="mt-4 flex justify-center gap-4 text-[10px] text-gray-500 uppercase font-bold">
                        <span>Periode: {{ request('tgl_mulai') ?? 'Awal' }} — {{ request('tgl_selesai') ?? 'Sekarang' }}</span>
                        <span>|</span>
                        <span>Filter Status: {{ request('status') ?? 'Semua' }}</span>
                    </div>
                    <hr class="mt-6 border-b-2 border-gray-800">
                </div>

                <table class="w-full text-left border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-50 print:bg-gray-100">
                            <th class="border border-gray-200 p-3 text-[10px] font-black uppercase text-gray-600 tracking-tighter w-10">No</th>
                            <th class="border border-gray-200 p-3 text-[10px] font-black uppercase text-gray-600 tracking-tighter">Peminjam</th>
                            <th class="border border-gray-200 p-3 text-[10px] font-black uppercase text-gray-600 tracking-tighter">Judul Buku</th>
                            <th class="border border-gray-200 p-3 text-[10px] font-black uppercase text-gray-600 tracking-tighter text-center">Tgl Pinjam</th>
                            <th class="border border-gray-200 p-3 text-[10px] font-black uppercase text-gray-600 tracking-tighter text-center">Tgl Kembali</th>
                            <th class="border border-gray-200 p-3 text-[10px] font-black uppercase text-gray-600 tracking-tighter text-center">Status</th>
                            <th class="border border-gray-200 p-3 text-[10px] font-black uppercase text-gray-600 tracking-tighter text-right">Biaya</th>
                            <th class="border border-gray-200 p-3 text-[10px] font-black uppercase text-gray-600 tracking-tighter text-center print:hidden">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($laporans as $key => $laporan)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="border border-gray-200 p-3 text-sm text-center text-gray-500">{{ $key + 1 }}</td>
                            <td class="border border-gray-200 p-3 text-sm">
                                <div class="font-extrabold text-gray-900 leading-none">{{ $laporan->user->name }}</div>
                                <div class="text-[10px] text-gray-400 mt-1">{{ $laporan->user->email }}</div>
                            </td>
                            <td class="border border-gray-200 p-3 text-sm font-semibold text-gray-700">{{ $laporan->buku->judul }}</td>
                            <td class="border border-gray-200 p-3 text-sm text-center font-mono">{{ \Carbon\Carbon::parse($laporan->tanggal_pinjam)->format('d/m/Y') }}</td>
                            <td class="border border-gray-200 p-3 text-sm text-center font-mono">
                                {{ $laporan->tanggal_kembali ? \Carbon\Carbon::parse($laporan->tanggal_kembali)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="border border-gray-200 p-3 text-sm text-center">
                                @php
                                    $statusClasses = [
                                        'DIPINJAM' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'PROSES_KEMBALI' => 'bg-amber-50 text-amber-700 border-amber-200 animate-pulse',
                                        'DIKEMBALIKAN' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    ];
                                    $class = $statusClasses[$laporan->status] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                                @endphp
                                <span class="px-2 py-0.5 rounded-full border text-[9px] font-black uppercase tracking-widest {{ $class }}">
                                    {{ str_replace('_', ' ', $laporan->status) }}
                                </span>
                            </td>
                            <td class="border border-gray-200 p-3 text-sm text-right font-bold text-gray-900">
                                Rp {{ number_format($laporan->total_biaya, 0, ',', '.') }}
                            </td>
                            <td class="border border-gray-200 p-3 text-sm text-center print:hidden">
                                @if($laporan->status == 'proses_kembali')
                                    <form action="{{ route('admin.peminjaman.verifikasi', $laporan->id) }}" method="POST" onsubmit="return confirm('Selesaikan verifikasi pengembalian?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black py-1.5 px-3 rounded-md text-[9px] uppercase tracking-wider shadow-sm transition-all hover:scale-105">
                                            Verifikasi
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-300">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="p-16 text-center text-gray-400 italic bg-gray-50/50">
                                Tidak ada data yang sesuai dengan filter pencarian.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                
                {{-- Tanda Tangan (Hanya muncul saat Print) --}}
                <div class="hidden print:flex justify-end mt-20">
                    <div class="text-center w-64 border-t border-transparent">
                        <p class="text-[11px] text-gray-600 mb-20 font-bold uppercase tracking-widest">Petugas Perpustakaan,</p>
                        <div class="w-full border-b-2 border-gray-900 mx-auto"></div>
                        <p class="font-black text-gray-900 uppercase mt-2">{{ Auth::user()->name }}</p>
                        <p class="text-[9px] text-gray-400 uppercase tracking-tighter">Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body { background-color: white !important; }
            header, nav, .print\:hidden { display: none !important; }
            .py-12 { padding-top: 0 !important; padding-bottom: 0 !important; }
            .max-w-7xl { max-width: 100% !important; width: 100% !important; margin: 0 !important; padding: 0 !important; }
            .bg-white { box-shadow: none !important; border: none !important; }
            #printableArea { padding: 0 !important; }
            
            /* Warna agar tetap muncul saat diprint */
            .bg-emerald-50 { background-color: #ecfdf5 !important; -webkit-print-color-adjust: exact; }
            .text-emerald-700 { color: #047857 !important; -webkit-print-color-adjust: exact; }
            .bg-gray-50 { background-color: #f9fafb !important; -webkit-print-color-adjust: exact; }
        }
    </style>
</x-app-layout>