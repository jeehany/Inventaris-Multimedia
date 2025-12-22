{{-- ID Modal harus unik berdasarkan ID kategori --}}
<div id="modal-edit-{{ $category->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-hidden="true">
    
    {{-- Container untuk memusatkan modal --}}
    <div class="flex items-center justify-center min-h-screen px-4 text-center">
        
        {{-- Overlay Gelap (Klik di sini untuk tutup) --}}
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="toggleModal('modal-edit-{{ $category->id }}')"></div>

        {{-- Konten Modal --}}
        <div class="inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:max-w-md sm:w-full z-10">
            
            <form action="{{ route('categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Penting untuk Update data di Laravel --}}
                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Kategori</h3>
                    
                    {{-- Input Nama Kategori --}}
                    <div>
                        <label for="name-{{ $category->id }}" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                        <input type="text" 
                               id="name-{{ $category->id }}"
                               name="category_name" 
                               value="{{ old('category_name', $category->category_name) }}"
                               required 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                               placeholder="Nama Kategori">
                    </div>

                    <div class="mt-3">
                        <label for="code-{{ $category->id }}" class="block text-sm font-medium text-gray-700 mb-1">Kode (prefix)</label>
                        <input type="text"
                               id="code-{{ $category->id }}"
                               name="code"
                               value="{{ old('code', $category->code) }}"
                               maxlength="10"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                               placeholder="Contoh: LPT">
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="bg-gray-50 px-4 py-3 flex flex-row-reverse gap-2">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm font-medium shadow-sm">
                        Simpan Perubahan
                    </button>
                    <button type="button" onclick="toggleModal('modal-edit-{{ $category->id }}')" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-50 text-sm font-medium shadow-sm">
                        Batal
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>