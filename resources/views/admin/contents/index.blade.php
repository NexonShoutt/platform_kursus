<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Materi: {{ $course->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="flex justify-between items-center mb-6">
                    <a href="{{ route('courses.contents.create', $course->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">
                        + Tambah Materi Baru
                    </a>
                    <a href="{{ route('courses.index') }}" class="text-gray-600 hover:text-gray-900 underline">
                        &larr; Kembali ke Daftar Kursus
                    </a>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-200 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="w-full border-collapse border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border p-3 text-left w-16">Urutan</th>
                            <th class="border p-3 text-left">Judul Materi</th>
                            <th class="border p-3 text-center w-48">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contents as $content)
                            <tr class="hover:bg-gray-50">
                                <td class="border p-3 text-center font-bold">{{ $content->sort_order }}</td>
                                <td class="border p-3">{{ $content->title }}</td>
                                <td class="border p-3 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('courses.contents.edit', [$course->id, $content->id]) }}" class="text-indigo-600 hover:text-indigo-900 font-bold mr-2">Edit</a>
                                        <form action="{{ route('courses.contents.destroy', [$course->id, $content->id]) }}" method="POST" class="inline" onsubmit="return confirm('Hapus materi ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-bold">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="border p-8 text-center text-gray-500 italic">Belum ada materi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>