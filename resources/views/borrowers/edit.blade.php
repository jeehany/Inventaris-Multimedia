<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Edit Data Anggota') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-xl border border-slate-200">
                <div class="p-8 text-slate-800">

                    <div class="mb-6 border-b border-slate-100 pb-4">
                        <h3 class="text-lg font-bold text-slate-900">Perbarui Data Anggota</h3>
                        <p class="text-sm text-slate-500">Ubah informasi anggota di bawah ini.</p>
                    </div>
                    
                    @if ($errors->any())
                        <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 rounded-r-lg shadow-sm">
                            <strong class="font-bold block mb-1">Periksa kembali input Anda:</strong>
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('borrowers.update', $borrower->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $borrower->name) }}"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-slate-400 transition" 
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">ID Anggota / NIS / NIP</label>
                            <input type="text" name="code" value="{{ old('code', $borrower->code) }}"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-slate-400 transition font-mono" 
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor Telepon (WhatsApp)</label>
                            <input type="text" name="phone" value="{{ old('phone', $borrower->phone) }}"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-slate-400 transition">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Foto Profil</label>
                            <div class="flex items-center space-x-6">
                                <div class="shrink-0">
                                    @if($borrower->photo)
                                        <img src="{{ asset('storage/'.$borrower->photo) }}" class="h-20 w-20 object-cover rounded-full border-2 border-indigo-100 shadow-sm" alt="Foto Profil">
                                    @else
                                        <div class="h-20 w-20 bg-slate-100 rounded-full flex items-center justify-center border-2 border-slate-200 border-dashed text-slate-400">
                                            No Img
                                        </div>
                                    @endif
                                </div>
                                <label class="block w-full">
                                    <span class="sr-only">Choose profile photo</span>
                                    <input type="file" name="photo" class="block w-full text-sm text-slate-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-full file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-indigo-50 file:text-indigo-700
                                      hover:file:bg-indigo-100
                                      cursor-pointer
                                    "/>
                                    <p class="text-xs text-slate-500 mt-2">Biarkan kosong jika tidak ingin mengubah foto.</p>
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                            <a href="{{ route('borrowers.index') }}" class="px-5 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-700 font-semibold hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition shadow-sm">
                                Batal
                            </a>
                            <button type="submit" class="px-5 py-2.5 bg-indigo-600 border border-transparent rounded-lg text-white font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition shadow-lg shadow-indigo-500/30">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
