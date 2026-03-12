<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buku yang Saya Pinjam') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Alert Notifikasi --}}
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6 shadow-sm flex justify-between items-center">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-green-900 font-bold">&times;</button>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="p-3 text-sm font-bold text-gray-600 uppercase tracking-wider">Informasi Buku</th>
                                <th class="p-3 text-sm font-bold text-gray-600 uppercase text-center tracking-wider">Jumlah</th>
                                <th class="p-3 text-sm font-bold text-gray-600 uppercase tracking-wider">Tgl Pinjam</th>
                                <th class="p-3 text-sm font-bold text-gray-600 uppercase tracking-wider">Tgl Kembali</th>
                                <th class="p-3 text-sm font-bold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="p-3 text-sm font-bold text-gray-600 uppercase text-right tracking-wider">Biaya (Rp)</th>
                                <th class="p-3 text-sm font-bold text-gray-600 uppercase text-center tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($peminjamans as $pinjam)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-4">
                                        <p class="font-bold text-gray-800 leading-tight">{{ $pinjam->buku->judul }}</p>
                                        <p class="text-xs text-gray-500 italic mt-1">{{ $pinjam->buku->penulis }}</p>
                                    </td>
                                    <td class="p-4 text-sm text-center">
                                        <span class="bg-gray-100 px-2.5 py-1 rounded text-gray-700 font-bold">
                                            {{ $pinjam->jumlah }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d/m/Y') }}
                                    </td>
                                    <td class="p-4 text-sm text-gray-600 font-medium">
                                        {{ $pinjam->tanggal_kembali ? \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="p-4 text-sm">
                                        {{-- Logika Status --}}
                                        @if ($pinjam->status == 'Dipinjam')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200 uppercase tracking-tighter">
                                                📖 Dipinjam
                                            </span>
                                        @elseif($pinjam->status == 'proses_kembali')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 border border-yellow-200 animate-pulse uppercase tracking-tighter">
                                                ⏳ Konfirmasi...
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200 uppercase tracking-tighter">
                                                ✅ Kembali
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm text-right font-bold text-gray-900">
                                        @if ($pinjam->status == 'Dikembalikan')
                                            <span class="text-indigo-600">Rp {{ number_format($pinjam->total_biaya, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-gray-400 font-normal italic text-[10px]">Tersedia setelah verifikasi</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center">
                                        {{-- Logika Tombol Aksi --}}
                                        @if ($pinjam->status == 'Dipinjam')
                                            <form action="{{ route('peminjaman.kembalikan', $pinjam->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin mengembalikan buku ini?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="w-full bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-xs font-extrabold uppercase transition shadow-sm hover:shadow-md">
                                                    Kembalikan
                                                </button>
                                            </form>
                                        @elseif($pinjam->status == 'proses_kembali')
                                            <button disabled class="w-full bg-gray-200 text-gray-400 px-4 py-2 rounded-lg text-xs font-bold cursor-not-allowed">
                                                Diproses
                                            </button>
                                        @else
                                            <button onclick="openModal('{{ $pinjam->buku_id }}')"
                                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-xs font-extrabold uppercase transition shadow-md hover:shadow-indigo-200">
                                                Beri Ulasan
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-12 text-center text-gray-400 italic bg-gray-50">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                            Belum ada data peminjaman buku.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Ulasan --}}
    <div id="modalUlasan" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-70 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>

            <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 transition-all transform scale-100">
                <div class="flex justify-between items-center mb-6 border-b pb-4">
                    <h3 class="text-xl font-extrabold text-gray-900">Ulas Buku</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-3xl transition-colors">&times;</button>
                </div>

                <form action="{{ route('ulasan.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="buku_id" id="modal_buku_id">

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Rating Kepuasan</label>
                        <select name="rating"
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3 font-semibold"
                            required>
                            <option value="5">⭐⭐⭐⭐⭐ (Sangat Bagus)</option>
                            <option value="4">⭐⭐⭐⭐ (Bagus)</option>
                            <option value="3">⭐⭐⭐ (Cukup)</option>
                            <option value="2">⭐⭐ (Kurang)</option>
                            <option value="1">⭐ (Buruk)</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Ulasan Anda</label>
                        <textarea name="ulasan" rows="4"
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 placeholder-gray-400 resize-none"
                            placeholder="Bagaimana pendapatmu tentang isi buku ini?" required></textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" onclick="closeModal()"
                            class="bg-gray-100 hover:bg-gray-200 px-6 py-3 rounded-xl text-sm font-bold text-gray-600 transition">Batal</button>
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-xl text-sm font-extrabold shadow-lg shadow-indigo-200 transition uppercase tracking-wider">
                            Kirim Ulasan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal(bukuId) {
            document.getElementById('modal_buku_id').value = bukuId;
            const modal = document.getElementById('modalUlasan');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            const modal = document.getElementById('modalUlasan');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
</x-app-layout>