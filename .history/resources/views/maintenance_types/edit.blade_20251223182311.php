<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Jenis Maintenance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Perhatikan route-nya kita arahkan ke maintenance-types.update --}}
                    <form action="{{ route('maintenance-types.update', $maintenance->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block font-bold text-sm text-gray-700">Nama Jenis Maintenance</label>
                            {{-- Input sederhana hanya untuk nama jenis --}}
                            <input type="text" name="name" value="{{ $maintenance->name }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div class="flex justify-end gap-2">
                            <a href="{{ route('maintenance-types.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Batal</a>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Update Jenis</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>