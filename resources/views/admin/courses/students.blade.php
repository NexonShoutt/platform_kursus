<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Siswa di Kursus: {{ $course->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <a href="{{ route('courses.index') }}" class="text-indigo-600 hover:underline mb-6 inline-block font-bold">
                    &larr; Kembali ke Daftar Kursus
                </a>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border p-3 text-left">Nama Siswa</th>
                                <th class="border p-3 text-left">Email</th>
                                <th class="border p-3 text-left">Tanggal Bergabung</th>
                                <th class="border p-3 text-center w-1/3">Progress Belajar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                                <tr class="hover:bg-gray-50">
                                    <td class="border p-3 font-bold text-gray-800">{{ $student->name }}</td>
                                    <td class="border p-3 text-gray-600">{{ $student->email }}</td>
                                    <td class="border p-3 text-gray-600">{{ $student->pivot->created_at->format('d M Y') }}</td>
                                    <td class="border p-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-full bg-gray-200 rounded-full h-4">
                                                <div class="bg-blue-600 h-4 rounded-full text-xs text-white text-center leading-4 transition-all duration-500" 
                                                     style="width: {{ $student->progress }}%">
                                                </div>
                                            </div>
                                            <span class="text-sm font-bold text-blue-700">{{ $student->progress }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="border p-8 text-center text-gray-500 italic">
                                        Belum ada siswa yang mendaftar di kursus ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>