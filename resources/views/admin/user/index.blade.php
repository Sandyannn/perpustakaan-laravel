<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen User & Petugas') }}
            </h2>
            <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm">
                + Tambah Petugas
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <th class="p-3 text-sm font-semibold">Nama</th>
                            <th class="p-3 text-sm font-semibold">Username</th>
                            <th class="p-3 text-sm font-semibold">Email</th>
                            <th class="p-3 text-sm font-semibold">Role</th>
                            <th class="p-3 text-sm font-semibold">Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 text-sm font-bold">{{ $user->name }}</td>
                            <td class="p-3 text-sm">{{ $user->username }}</td>
                            <td class="p-3 text-sm">{{ $user->email }}</td>
                            <td class="p-3 text-sm">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $user->role == 'petugas' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="p-3 text-sm text-gray-600">{{ $user->alamat }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="modalTambah" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Tambah Akun Petugas</h3>
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <input type="text" name="name" placeholder="Nama Lengkap" class="w-full mb-3 rounded border-gray-300" required>
                    <input type="text" name="username" placeholder="Username" class="w-full mb-3 rounded border-gray-300" required>
                    <input type="email" name="email" placeholder="Email" class="w-full mb-3 rounded border-gray-300" required>
                    <input type="password" name="password" placeholder="Password" class="w-full mb-3 rounded border-gray-300" required>
                    <input type="text" name="alamat" placeholder="Alamat" class="w-full mb-3 rounded border-gray-300" required>
                    <select name="role" class="w-full mb-4 rounded border-gray-300">
                        <option value="petugas">Petugas</option>
                        <option value="administrator">Administrator</option>
                    </select>
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="bg-gray-200 px-4 py-2 rounded">Batal</button>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>