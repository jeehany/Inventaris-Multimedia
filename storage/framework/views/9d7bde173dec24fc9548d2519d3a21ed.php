<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['id' => 'deleteModal']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['id' => 'deleteModal']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>



<div id="<?php echo e($id); ?>" class="fixed inset-0 z-50 hidden overflow-y-auto" role="dialog" aria-modal="true">
    
    <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeDeleteModal()"></div>

    <div class="flex items-center justify-center min-h-screen p-4 text-center">
        <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all max-w-lg w-full ring-1 ring-slate-200">
            <form id="deleteForm" method="POST" action="">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                
                <div class="p-6">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-rose-100 rounded-full mb-4">
                        <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    
                    <h3 id="deleteModalTitle" class="text-xl font-bold text-center text-slate-800 mb-2">Hapus Data?</h3>
                    <p id="deleteModalMessage" class="text-sm text-center text-slate-500 mb-6">
                        Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.
                    </p>

                    
                    <?php echo e($slot); ?>


                </div>

                <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-100">
                    <button type="submit" class="w-full inline-flex justify-center rounded-xl shadow-lg bg-rose-600 px-4 py-2.5 text-base font-bold text-white hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 sm:w-auto sm:text-sm transition transform hover:-translate-y-0.5">
                        Ya, Hapus
                    </button>
                    <button type="button" onclick="closeDeleteModal()" class="w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-4 py-2.5 bg-white text-base font-bold text-slate-700 hover:bg-slate-50 focus:outline-none sm:w-auto sm:text-sm transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openDeleteModal(url, title = 'Hapus Data?', message = 'Apakah Anda yakin ingin menghapus data ini?') {
        const modal = document.getElementById('<?php echo e($id); ?>');
        const form = document.getElementById('deleteForm');
        const titleEl = document.getElementById('deleteModalTitle');
        const msgEl = document.getElementById('deleteModalMessage');

        form.action = url;
        titleEl.innerText = title;
        msgEl.innerHTML = message; // Use innerHTML to allow bold/formatting

        modal.classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('<?php echo e($id); ?>').classList.add('hidden');
    }
</script>
<?php /**PATH C:\laragon\www\app-inventaris\resources\views/components/modal-delete.blade.php ENDPATH**/ ?>