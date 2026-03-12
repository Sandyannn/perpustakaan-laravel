<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen User & Petugas') }}
            </h2>
            <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm transition shadow-md">
                + Tambah Akun
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-4 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <th class="p-3 text-sm font-semibold text-gray-700 uppercase tracking-wider">Nama</th>
                            <th class="p-3 text-sm font-semibold text-gray-700 uppercase tracking-wider">Username</th>
                            <th class="p-3 text-sm font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                            <th class="p-3 text-sm font-semibold text-gray-700 uppercase tracking-wider">Role</th>
                            <th class="p-3 text-sm font-semibold text-gray-700 uppercase tracking-wider">Alamat</th>
                            <th class="p-3 text-sm font-semibold text-gray-700 uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="p-3 text-sm font-bold text-gray-900">{{ $user->name }}</td>
                                <td class="p-3 text-sm text-gray-600">{{ $user->username }}</td>
                                <td class="p-3 text-sm text-gray-600">{{ $user->email }}</td>
                                <td class="p-3 text-sm">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $user->role == 'petugas' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="p-3 text-sm text-gray-600">{{ Str::limit($user->alamat, 40) }}</td>
                                <td class="p-3 text-center">
                                    <div class="flex justify-center items-center gap-2">
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus user {{ $user->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded text-xs font-bold transition flex items-center gap-1 shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Tambah User --}}
    <div id="modalTambah" class="hidden fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-6 border w-96 shadow-2xl rounded-xl bg-white animate-fade-in-down">
            <div class="mt-2 text-center">
                <h3 class="text-lg font-bold text-gray-900 mb-6 border-b pb-2">Tambah Akun Baru</h3>
                <form action="{{ route('users.store') }}" method="POST" class="text-left">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Nama Lengkap</label>
                        <input type="text" name="name" placeholder="Contoh: Budi Santoso"
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Username</label>
                        <input type="text" name="username" placeholder="budi_s"
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Email</label>
                        <input type="email" name="email" placeholder="email@contoh.com"
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Password</label>
                        <input type="password" name="password" placeholder="Minimal 8 karakter"
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Alamat</label>
                        <textarea name="alamat" rows="2" placeholder="Alamat lengkap..."
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" required></textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Role Akses</label>
                        <select name="role" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="petugas">Petugas</option>
                            <option value="administrator">Administrator</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-3 mt-8">
                        <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')"
                            class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold px-4 py-2 rounded-lg transition text-sm">
                            Batal
                        </button>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-2 rounded-lg transition text-sm shadow-md">
                            Simpan Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>