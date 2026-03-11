<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Laporan Peminjaman Buku') }}
            </h2>
            <button onclick="window.print()" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-sm flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Cetak Laporan
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-lg shadow overflow-hidden" id="printableArea">
                <div class="hidden print:block text-center mb-8">
                    <h1 class="text-2xl font-bold uppercase">Laporan Perpustakaan Digital</h1>
                    <p class="text-sm">Data Seluruh Transaksi Peminjaman Buku</p>
                    <hr class="mt-4 border-b-2 border-gray-800">
                </div>

                <table class="w-full text-left border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100 print:bg-gray-200">
                            <th class="border border-gray-300 p-3 text-sm">No</th>
                            <th class="border border-gray-300 p-3 text-sm">Peminjam</th>
                            <th class="border border-gray-300 p-3 text-sm">Buku</th>
                            <th class="border border-gray-300 p-3 text-sm">Tgl Pinjam</th>
                            <th class="border border-gray-300 p-3 text-sm">Tgl Kembali</th>
                            <th class="border border-gray-300 p-3 text-sm">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporans as $key => $laporan)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 p-3 text-sm text-center">{{ $key + 1 }}</td>
                            <td class="border border-gray-300 p-3 text-sm">
                                <div class="font-bold">{{ $laporan->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $laporan->user->email }}</div>
                            </td>
                            <td class="border border-gray-300 p-3 text-sm">{{ $laporan->buku->judul }}</td>
                            <td class="border border-gray-300 p-3 text-sm">{{ $laporan->tanggal_peminjaman }}</td>
                            <td class="border border-gray-300 p-3 text-sm">{{ $laporan->tanggal_pengembalian ?? '-' }}</td>
                            <td class="border border-gray-300 p-3 text-sm">
                                <span class="uppercase font-semibold {{ $laporan->status_peminjaman == 'dipinjam' ? 'text-blue-600' : 'text-green-600' }}">
                                    {{ $laporan->status_peminjaman }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-4 text-center text-gray-500 italic">Belum ada data transaksi peminjaman.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                
                <div class="hidden print:flex justify-end mt-12">
                    <div class="text-center">
                        <p>Malang, {{ date('d F Y') }}</p>
                        <p class="mb-16">Petugas Perpustakaan,</p>
                        <p class="font-bold border-b border-gray-800">{{ Auth::user()->name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #printableArea, #printableArea * {
                visibility: visible;
            }
            #printableArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                box-shadow: none;
            }
            button, .flex.justify-between, nav {
                display: none !important;
            }
        }
    </style>
</x-app-layout>