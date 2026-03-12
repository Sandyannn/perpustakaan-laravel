<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <x-input-label for="nama_kategori" :value="__('Nama Kategori')" />
                        <x-text-input id="nama_kategori" class="block mt-1 w-full" type="text" name="nama_kategori" :value="old('nama_kategori', $kategori->nama_kategori)" required autofocus />
                        <x-input-error :messages="$errors->get('nama_kategori')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('kategori.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                        <x-primary-button class="bg-yellow-600 hover:bg-yellow-700">
                            {{ __('Perbarui Kategori') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>