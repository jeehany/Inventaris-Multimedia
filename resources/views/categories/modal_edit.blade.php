{{-- ID Modal harus unik berdasarkan ID kategori --}}
<div id="modal-edit-{{ $category->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-hidden="true" role="dialog">
    
    {{-- Container untuk memusatkan modal --}}
    <div class="flex items-center justify-center min-h-screen px-4 text-center">
        
        {{-- Overlay Gelap --}}
        <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity backdrop-blur-sm" onclick="toggleModal('modal-edit-{{ $category->id }}')"></div>

        {{-- Konten Modal --}}
        <div class="inline-block bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-md sm:w-full z-10">
            
            <form action="{{ route('categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="bg-white px-6 pt-6 pb-6">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="text-lg font-bold text-slate-900">Edit Kategori</h3>
                        <button type="button" onclick="toggleModal('modal-edit-{{ $category->id }}')" class="text-slate-400 hover:text-slate-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    
                    {{-- Input Nama Kategori --}}
                    <div class="space-y-4">
                        <div>
                            <label for="name-{{ $category->id }}" class="block text-sm font-semibold text-slate-700 mb-1">Nama Kategori</label>
                            <input type="text" 
                                   id="name-{{ $category->id }}"
                                   name="category_name" 
                                   value="{{ old('category_name', $category->category_name) }}"
                                   required 
                                   class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-medium" 
                                   placeholder="Nama Kategori">
                        </div>

                        <div>
                            <label for="code-{{ $category->id }}" class="block text-sm font-semibold text-slate-700 mb-1">Kode Prefix</label>
                            <input type="text"
                                   id="code-{{ $category->id }}"
                                   name="code"
                                   value="{{ old('code', $category->code) }}"
                                   maxlength="10"
                                   class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 font-mono uppercase"
                                   placeholder="Contoh: LPT">
                            <p class="text-xs text-slate-500 mt-1">Ubah prefix akan mempengaruhi kode aset baru.</p>
                        </div>

                        <div>
                            <label for="desc-{{ $category->id }}" class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi</label>
                            <textarea id="desc-{{ $category->id }}" 
                                      name="description" 
                                      rows="2"
                                      class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400">{{ old('description', $category->description) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="bg-slate-50 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-100">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm font-semibold shadow-md transition">
                        Simpan Perubahan
                    </button>
                    <button type="button" onclick="toggleModal('modal-edit-{{ $category->id }}')" class="bg-white border border-slate-300 text-slate-700 px-4 py-2 rounded-lg hover:bg-slate-50 text-sm font-semibold shadow-sm transition">
                        Batal
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>