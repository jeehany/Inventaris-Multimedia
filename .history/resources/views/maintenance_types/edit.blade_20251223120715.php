<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Jenis Maintenance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('maintenance-types.update', $maintenanceType->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="block font-bold text-sm text-gray-700">Nama Jenis Perawatan</label>
                            <input type="text" name="name" value="{{ $maintenanceType->name }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" required>
                        </div>

                        <div class="mb-4">
                            <label class="block font-bold text-sm text-gray-700">Deskripsi</label>
                            <textarea name="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500">{{ $maintenanceType->description }}</textarea>
                        </div>

                        <div class="flex justify-end gap-2 mt-6">
                            <a href="{{ route('maintenance-types.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Batal</a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 shadow">Update Data</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>