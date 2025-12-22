<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Peminjam') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('borrowers.update', $borrower->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Kode Anggota</label>
                            <input type="text" name="code" value="{{ old('code', $borrower->code) }}" class="border rounded w-full py-2 px-3" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $borrower->name) }}" class="border rounded w-full py-2 px-3" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Nomor Telepon (WA)</label>
                            <input type="text" name="phone" value="{{ old('phone', $borrower->phone) }}" class="border rounded w-full py-2 px-3">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Foto Profil (Opsional)</label>
                            @if($borrower->photo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$borrower->photo) }}" alt="Foto" class="h-20 w-20 object-cover rounded">
                                </div>
                            @endif
                            <input type="file" name="photo" class="border rounded w-full py-2 px-3">
                        </div>

                        <div class="flex justify-end gap-2 mt-6">
                            <a href="{{ route('borrowers.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Batal</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">Simpan Perubahan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
