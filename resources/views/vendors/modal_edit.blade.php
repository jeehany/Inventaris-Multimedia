{{-- MODAL EDIT VENDOR --}}
<div id="modal-edit-{{ $vendor->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-hidden="true" role="dialog">
    <div class="flex items-center justify-center min-h-screen px-4 text-center">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity backdrop-blur-sm" onclick="toggleModal('modal-edit-{{ $vendor->id }}')"></div>
        
        <!-- Modal Panel -->
        <div class="inline-block bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-md sm:w-full">
            <form action="{{ route('vendors.update', $vendor->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-white px-6 pt-6 pb-6">
                    <div class="flex justify-between items-center mb-5 border-b border-slate-100 pb-3">
                        <h3 class="text-lg font-bold text-slate-900">Edit Vendor</h3>
                        <button type="button" onclick="toggleModal('modal-edit-{{ $vendor->id }}')" class="text-slate-400 hover:text-rose-500 transition-colors">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Vendor <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" value="{{ $vendor->name }}" required 
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Telepon / HP <span class="text-rose-500">*</span></label>
                            <input type="text" name="phone" value="{{ $vendor->phone }}" required 
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Email <span class="text-slate-400 font-normal">(Opsional)</span></label>
                            <input type="email" name="email" value="{{ $vendor->email }}" 
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Alamat Lengkap <span class="text-slate-400 font-normal">(Opsional)</span></label>
                            <textarea name="address" rows="2" 
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400">{{ $vendor->address }}</textarea>
                        </div>
                    </div>
                </div>
                <!-- Footer -->
                <div class="bg-slate-50 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-100">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm font-semibold shadow-md transition">Simpan Perubahan</button>
                    <button type="button" onclick="toggleModal('modal-edit-{{ $vendor->id }}')" class="bg-white border border-slate-300 text-slate-700 px-4 py-2 rounded-lg hover:bg-slate-50 text-sm font-semibold shadow-sm transition">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
