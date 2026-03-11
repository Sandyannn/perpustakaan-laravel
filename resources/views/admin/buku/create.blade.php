<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Buku Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <form action="{{ route('buku.store') }}" method="POST">
                    @csrf

                    <div class="mt-4">
                        <x-input-label for="judul" :value="__('Judul Buku')" />
                        <x-text-input id="judul" class="block mt-1 w-full" type="text" name="judul"
                            :value="old('judul')" required />
                        <x-input-error :messages="$errors->get('judul')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="penulis" :value="__('Penulis')" />
                        <x-text-input id="penulis" class="block mt-1 w-full" type="text" name="penulis"
                            :value="old('penulis')" required />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="penerbit" :value="__('Penerbit')" />
                        <x-text-input id="penerbit" class="block mt-1 w-full" type="text" name="penerbit"
                            :value="old('penerbit')" required />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="tahun_terbit" :value="__('Tahun Terbit')" />
                        <x-text-input id="tahun_terbit" class="block mt-1 w-full" type="number" name="tahun_terbit"
                            :value="old('tahun_terbit')" required />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="kategori_ids" :value="__('Kategori Buku')" />
                        <select name="kategori_ids[]" id="kategori_ids"
                            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            multiple required>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">*Tahan Ctrl/Command untuk memilih lebih dari satu.</p>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="stok" :value="__('Jumlah Stok')" />
                        <x-text-input id="stok" class="block mt-1 w-full" type="number" name="stok"
                            :value="old('stok', 1)" min="0" required />
                        <x-input-error :messages="$errors->get('stok')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('buku.index') }}" class="text-gray-600 mr-4">Batal</a>
                        <x-primary-button>
                            {{ __('Simpan Buku') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
