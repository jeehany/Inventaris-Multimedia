{{-- MODAL EDIT BORROWER --}}
<div id="modal-edit-{{ $b->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-hidden="true" role="dialog">
    <div class="flex items-center justify-center min-h-screen px-4 text-center">
        <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity backdrop-blur-sm" onclick="toggleModal('modal-edit-{{ $b->id }}')"></div>
        
        <div class="inline-block w-full max-w-md bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all">
            <form method="POST" action="{{ route('borrowers.update', $b->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="bg-white px-6 pt-6 pb-6">
                    <div class="flex justify-between items-center mb-5 border-b border-slate-100 pb-3">
                        <h3 class="text-lg font-bold text-slate-900">Edit Data Anggota</h3>
                        <button type="button" onclick="toggleModal('modal-edit-{{ $b->id }}')" class="text-slate-400 hover:text-rose-500 transition-colors">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    
                    <div class="space-y-4">
                        {{-- Profil Saat Ini --}}
                        @if($b->photo)
                        <div class="flex items-center justify-center mb-4">
                            <img src="{{ asset('storage/'.$b->photo) }}" alt="Foto" class="h-16 w-16 rounded-full object-cover border-2 border-indigo-100 shadow-sm">
                        </div>
                        @else
                        <div class="flex items-center justify-center mb-4">
                            <div class="h-16 w-16 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 font-bold text-xl border-2 border-white shadow-sm">
                                {{ substr($b->name, 0, 1) }}
                            </div>
                        </div>
                        @endif

                        <!-- Nomor Induk / ID Anggota -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">ID / Nomor Induk (NIM/NIP) <span class="text-rose-500">*</span></label>
                            <input type="text" name="code" value="{{ old('code', $b->code) }}" required 
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400">
                        </div>

                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $b->name) }}" required 
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400">
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Kontak (WhatsApp/No.HP)</label>
                            <input type="text" name="phone" value="{{ old('phone', $b->phone) }}" 
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400">
                        </div>

                        <!-- Photo -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Ubah Foto Profil</label>
                            <input type="file" name="photo" accept="image/*"
                                class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 focus:outline-none">
                            <p class="mt-1 text-xs text-slate-400">Format: JPG, PNG. Maks 2MB.</p>
                        </div>
                    </div>
                </div>
                <!-- Footer -->
                <div class="bg-slate-50 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-100">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm font-semibold shadow-md transition">Simpan Perubahan</button>
                    <button type="button" onclick="toggleModal('modal-edit-{{ $b->id }}')" class="bg-white border border-slate-300 text-slate-700 px-4 py-2 rounded-lg hover:bg-slate-50 text-sm font-semibold shadow-sm transition">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
