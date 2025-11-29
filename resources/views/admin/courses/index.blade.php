<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Kursus') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="mb-6">
                    <a href="{{ route('courses.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">
                        + Tambah Kursus
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
                                <th class="border p-3 text-gray-700 text-center w-24">Gambar</th>
                                <th class="border p-3 text-gray-700 text-left">Nama Kursus</th>
                                <th class="border p-3 text-gray-700 text-left">Kategori</th>
                                <th class="border p-3 text-gray-700 text-left">Pengajar</th>
                                <th class="border p-3 text-gray-700 text-center w-64">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($courses as $course)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="border p-3 text-center">
                                        @if($course->thumbnail)
                                            <img src="{{ asset('storage/' . $course->thumbnail) }}" class="w-16 h-16 object-cover rounded shadow-sm mx-auto">
                                        @else
                                            <span class="text-xs text-gray-400">No Img</span>
                                        @endif
                                    </td>
                                    <td class="border p-3 font-semibold text-gray-800">{{ $course->name }}</td>
                                    <td class="border p-3"><span class="px-2 py-1 bg-gray-200 text-gray-700 rounded text-xs font-bold">{{ $course->category->name ?? '-' }}</span></td>
                                    <td class="border p-3 text-gray-600 text-sm">{{ $course->teacher->name ?? '-' }}</td>
                                    
                                    <td class="border p-3 text-center">
                                        <div class="flex flex-col gap-2">
                                            <a href="{{ route('courses.contents.index', $course) }}" class="inline-block px-3 py-1 bg-white border border-gray-300 text-gray-700 rounded text-xs font-bold hover:bg-gray-50 shadow-sm">
                                                📂 Kelola Materi ({{ $course->contents->count() }})
                                            </a>
                                            <a href="{{ route('courses.students', $course) }}" class="inline-block px-3 py-1 bg-blue-600 text-white rounded text-xs font-bold hover:bg-blue-700 shadow-sm">
                                                👥 Siswa ({{ $course->students->count() }})
                                            </a>

                                            <div class="flex justify-center gap-3 mt-1">
                                                <a href="{{ route('courses.edit', $course) }}" class="text-indigo-600 hover:text-indigo-900 font-bold text-sm">Edit</a>
                                                <form action="{{ route('courses.destroy', $course) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 font-bold text-sm">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="border p-8 text-center text-gray-500 italic bg-gray-50">Belum ada kursus.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>