<div class="container mx-auto px-4">
    <h2 class="text-2xl font-bold mb-4">Edit Alat</h2>

    <form action="{{ route('tools.update', $tool->id) }}" method="POST">
        @csrf
        @method('PUT') <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Kode Alat</label>
            <input type="text" name="tool_code" value="{{ old('tool_code', $tool->tool_code) }}" class="border rounded w-full py-2 px-3">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Nama Alat</label>
            <input type="text" name="tool_name" value="{{ old('tool_name', $tool->tool_name) }}" class="border rounded w-full py-2 px-3">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Kategori Alat</label>
            <select name="category_id" class="border rounded w-full py-2 px-3">
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                        {{ $tool->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
             <label class="block text-gray-700 font-bold mb-2">Kondisi</label>
             <input type="text" name="current_condition" value="{{ old('current_condition', $tool->current_condition) }}" class="border rounded w-full py-2 px-3">
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Update Data
        </button>
    </form>
</div>