<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kursus') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('courses.update', $course) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="mb-4">
                                <label class="block font-medium text-sm text-gray-700 mb-2">Nama Kursus</label>
                                <input type="text" name="name" value="{{ $course->name }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block font-medium text-sm text-gray-700 mb-2">Kategori</label>
                                <select name="category_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $course->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block font-medium text-sm text-gray-700 mb-2">Thumbnail (Biarkan kosong jika tidak ganti)</label>
                                <input type="file" name="thumbnail" class="w-full border border-gray-300 p-2 rounded-md">
                                
                                <div class="mt-3">
                                    <p class="text-xs text-gray-500 mb-1">Gambar Saat Ini:</p>
                                    <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="" class="w-32 h-32 object-cover rounded-md border border-gray-200">
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="mb-4">
                                <label class="block font-medium text-sm text-gray-700 mb-2">Tanggal Mulai</label>
                                <input type="date" name="start_date" value="{{ $course->start_date }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                            <div class="mb-4">
                                <label class="block font-medium text-sm text-gray-700 mb-2">Tanggal Selesai</label>
                                <input type="date" name="end_date" value="{{ $course->end_date }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block font-medium text-sm text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="description" rows="5" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ $course->description }}</textarea>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('courses.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Update Kursus
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>