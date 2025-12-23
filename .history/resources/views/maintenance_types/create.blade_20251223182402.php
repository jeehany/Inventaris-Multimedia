<div class="mb-4">
    <label class="block font-bold text-sm text-gray-700">Jenis Perawatan</label>
    <select name="maintenance_type_id" class="w-full border-gray-300 rounded-md shadow-sm" required>
        <option value="">-- Pilih Jenis --</option>
        @foreach($types as $type)
            <option value="{{ $type->id }}">{{ $type->name }}</option>
        @endforeach
    </select>
</div>