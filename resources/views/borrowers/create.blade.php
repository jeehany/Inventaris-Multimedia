<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Peminjam Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('borrowers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Nama Lengkap</label>
                            <input type="text" name="name" class="border rounded w-full py-2 px-3" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Kode Anggota</label>
                            <input type="text" name="code" class="border rounded w-full py-2 px-3" required placeholder="Contoh: 12345678">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Nomor Telepon (WA)</label>
                            <input type="text" name="phone" class="border rounded w-full py-2 px-3" placeholder="Contoh: 0812...">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Foto Profil (Opsional)</label>
                            <input type="file" name="photo" class="border rounded w-full py-2 px-3">
                        </div>

                        <div class="flex justify-end gap-2 mt-6">
                            <a href="{{ route('borrowers.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Batal</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">Simpan Data</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>