<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Tambah Anggota Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-xl border border-slate-200">
                <div class="p-8 text-slate-800">
                    
                    <div class="mb-6 border-b border-slate-100 pb-4">
                        <h3 class="text-lg font-bold text-slate-900">Formulir Pendaftaran Anggota</h3>
                        <p class="text-sm text-slate-500">Lengkapi data di bawah ini untuk menambahkan peminjam baru.</p>
                    </div>

                    {{-- Tampilkan Error Validasi --}}
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

                    <form action="{{ route('borrowers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" 
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-slate-400 transition" 
                                placeholder="Masukkan nama lengkap..." required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">No KTP</label>
                            <input type="text" name="code" 
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-slate-400 transition font-mono" 
                                placeholder="Contoh: 12345678" required>
                            <p class="text-xs text-slate-500 mt-1">Gunakan nomor identitas unik.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor Telepon (WhatsApp)</label>
                            <input type="text" name="phone" 
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-slate-400 transition" 
                                placeholder="Contoh: 08123456789">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Foto Profil (Opsional)</label>
                            <div class="flex items-center space-x-4">
                                <div class="shrink-0">
                                    <div class="h-16 w-16 bg-slate-100 rounded-full flex items-center justify-center border-2 border-slate-200 border-dashed">
                                        <svg class="h-8 w-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
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
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                            <a href="{{ route('borrowers.index') }}" class="px-5 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-700 font-semibold hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition shadow-sm">
                                Batal
                            </a>
                            <button type="submit" class="px-5 py-2.5 bg-indigo-600 border border-transparent rounded-lg text-white font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition shadow-lg shadow-indigo-500/30">
                                Simpan Data
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>