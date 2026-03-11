<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buku yang Saya Pinjam') }}
        </h2>
    </x-slot>
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4 shadow-sm">
            {{ session('success') }}
        </div>
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <th class="p-3 text-sm font-semibold">Judul Buku</th>
                            <th class="p-3 text-sm font-semibold">Tgl Pinjam</th>
                            <th class="p-3 text-sm font-semibold">Tgl Kembali</th>
                            <th class="p-3 text-sm font-semibold">Status</th>
                            <th class="p-3 text-sm font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjamans as $pinjam)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3 text-sm">
                                    <p class="font-bold text-gray-800">{{ $pinjam->buku->judul }}</p>
                                    <p class="text-xs text-gray-500">{{ $pinjam->buku->penulis }}</p>
                                </td>
                                <td class="p-3 text-sm">{{ $pinjam->tanggal_peminjaman }}</td>
                                <td class="p-3 text-sm">{{ $pinjam->tanggal_pengembalian ?? '-' }}</td>
                                <td class="p-3 text-sm">
                                    <span
                                        class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ $pinjam->status_peminjaman == 'dipinjam' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                                        {{ $pinjam->status_peminjaman }}
                                    </span>
                                </td>
                                <td class="p-3 text-sm">
                                    @if ($pinjam->status_peminjaman == 'dipinjam')
                                        <form action="{{ route('peminjaman.kembalikan', $pinjam->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-1 rounded text-xs">Kembalikan</button>
                                        </form>
                                    @else
                                        <button onclick="openModal('{{ $pinjam->buku_id }}')"
                                            class="text-indigo-600 hover:underline text-xs font-bold">Beri
                                            Ulasan</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-500 italic">Kamu belum meminjam buku
                                    apapun.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="modalUlasan" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Berikan Ulasan Buku</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">&times;</button>
                </div>

                <form action="{{ route('ulasan.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="buku_id" id="modal_buku_id">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Rating</label>
                        <select name="rating"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500"
                            required>
                            <option value="5">⭐⭐⭐⭐⭐ (Sangat Bagus)</option>
                            <option value="4">⭐⭐⭐⭐ (Bagus)</option>
                            <option value="3">⭐⭐⭐ (Cukup)</option>
                            <option value="2">⭐⭐ (Kurang)</option>
                            <option value="1">⭐ (Buruk)</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Ulasan Anda</label>
                        <textarea name="ulasan" rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500"
                            placeholder="Tuliskan pendapatmu tentang buku ini..." required></textarea>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closeModal()"
                            class="bg-gray-200 px-4 py-2 rounded-md text-sm">Batal</button>
                        <button type="submit"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">Kirim
                            Ulasan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal(bukuId) {
            document.getElementById('modal_buku_id').value = bukuId;
            document.getElementById('modalUlasan').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modalUlasan').classList.add('hidden');
        }
    </script>
</x-app-layout>
