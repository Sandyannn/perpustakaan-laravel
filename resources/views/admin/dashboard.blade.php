<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
                    <div class="text-gray-500 text-sm">Total Buku</div>
                    <div class="text-2xl font-bold">{{ $data['total_buku'] }}</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
                    <div class="text-gray-500 text-sm">Peminjaman Aktif</div>
                    <div class="text-2xl font-bold">{{ $data['pinjaman_aktif'] }}</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-yellow-500">
                    <div class="text-gray-500 text-sm">Total User</div>
                    <div class="text-2xl font-bold">{{ $data['total_user'] }}</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-purple-500">
                    <div class="text-gray-500 text-sm">Total Petugas</div>
                    <div class="text-2xl font-bold">{{ $data['total_petugas'] }}</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold mb-4">Peminjaman Terbaru</h3>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b">
                                <th class="p-2">Peminjam</th>
                                <th class="p-2">Buku</th>
                                <th class="p-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['recent_orders'] as $order)
                            <tr class="border-b">
                                <td class="p-2">{{ $order->user->name }}</td>
                                <td class="p-2">{{ $order->buku->judul }}</td>
                                <td class="p-2">
                                    <span class="px-2 py-1 rounded text-xs {{ $order->status == 'dipinjam' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>