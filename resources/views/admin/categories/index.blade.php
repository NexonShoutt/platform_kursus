<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="mb-6">
                    <a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        + Tambah Kategori
                    </a>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-200 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border p-3 text-left text-gray-700 w-16">No</th>
                                <th class="border p-3 text-left text-gray-700">Nama Kategori</th>
                                <th class="border p-3 text-left text-gray-700">Slug</th>
                                <th class="border p-3 text-center text-gray-700 w-48">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $index => $category)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="border p-3 text-center">{{ $index + 1 }}</td>
                                    <td class="border p-3 font-bold text-gray-800">{{ $category->name }}</td>
                                    <td class="border p-3 text-gray-500 font-mono text-sm">{{ $category->slug }}</td>
                                    <td class="border p-3 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-900 font-bold mr-2">
                                                Edit
                                            </a>
                                            
                                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-bold">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="border p-8 text-center text-gray-500 bg-gray-50">Belum ada kategori.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>