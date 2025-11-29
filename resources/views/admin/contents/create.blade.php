<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Materi ke: {{ $course->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('courses.contents.store', $course->id) }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-4">
                        <div class="col-span-3">
                            <label class="block font-medium text-sm text-gray-700 mb-2">Judul Materi</label>
                            <input type="text" name="title" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500" required>
                        </div>
                        <div class="col-span-1">
                            <label class="block font-medium text-sm text-gray-700 mb-2">No. Urut</label>
                            <input type="number" name="sort_order" value="1" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500" required>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block font-medium text-sm text-gray-700 mb-2">Isi Materi (Teks/Youtube Link)</label>
                        <textarea name="body" rows="10" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500" required></textarea>
                        <p class="text-xs text-gray-500 mt-1">*Anda bisa menulis teks panjang atau menempelkan link video di sini.</p>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('courses.contents.index', $course->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition">Batal</a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">Simpan Materi</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>