<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Jenis Maintenance</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm rounded-lg">
                <a href="{{ route('maintenance-types.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Jenis</a>
                <table class="w-full border mt-4">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border p-2">Nama Jenis</th>
                            <th class="border p-2">Deskripsi</th>
                            <th class="border p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($types as $type)
                        <tr>
                            <td class="border p-2">{{ $type->name }}</td>
                            <td class="border p-2">{{ $type->description }}</td>
                            <td class="border p-2 text-center">
                                <a href="{{ route('maintenance-types.edit', $type->id) }}" class="text-blue-600">Edit</a>
                                <form action="{{ route('maintenance-types.destroy', $type->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Hapus?')" class="text-red-600 ml-2">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>