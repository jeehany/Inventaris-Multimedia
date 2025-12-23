{{-- File: resources/views/categories/modal_edit.blade.php --}}

<div id="modal-edit-{{ $cat->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-hidden="true">
    
    {{-- BAGIAN PENTING: Class ini yang bikin posisi di TENGAH (min-h-screen + items-center) --}}
    <div class="flex items-center justify-center min-h-screen px-4 text-center">
        
        {{-- Overlay Gelap (Background) --}}
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="toggleModal('modal-edit-{{ $cat->id }}')"></div>

        {{-- Kotak Putih Modal --}}
        <div class="inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:max-w-md sm:w-full z-10">
            
            <form action="{{ route('categories.update', $cat->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Edit Kategori</h3>
                        <button type="button" onclick="toggleModal('modal-edit-{{ $cat->id }}')" class="text-gray-400 hover:text-gray-500">✕</button>
                    </div>

                    {{-- Input Nama --}}
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                        <input type="text" name="category_name" value="{{ $cat->category_name }}" required 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    {{-- Input Kode --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kode (prefix)</label>
                        <input type="text" name="code" value="{{ $cat->code }}" maxlength="10" 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                {{-- Footer Tombol --}}
                <div class="bg-gray-50 px-4 py-3 flex flex-row-reverse gap-2">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 shadow-sm text-sm font-medium">
                        Update
                    </button>
                    <button type="button" onclick="toggleModal('modal-edit-{{ $cat->id }}')" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-50 text-sm font-medium">
                        Batal
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>