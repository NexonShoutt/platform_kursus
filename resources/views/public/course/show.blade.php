<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->name }} - EduCourse</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/" class="text-xl font-bold text-indigo-600 flex items-center gap-2">
                &larr; Kembali
            </a>
            @auth
                <div class="text-sm text-gray-600">Halo, {{ auth()->user()->name }}</div>
            @else
                <a href="{{ route('login') }}" class="text-sm font-bold text-indigo-600">Login untuk Mendaftar</a>
            @endauth
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                    <span class="inline-block px-3 py-1 bg-indigo-50 text-indigo-700 text-xs font-bold rounded-full mb-4">
                        {{ $course->category->name }}
                    </span>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-6 leading-tight">{{ $course->name }}</h1>
                    
                    @if($course->thumbnail)
                        <img src="{{ asset('storage/' . $course->thumbnail) }}" class="w-full h-64 object-cover rounded-xl mb-8 shadow-sm">
                    @endif

                    <h3 class="text-xl font-bold text-gray-800 mb-4 border-l-4 border-indigo-600 pl-3">Tentang Kursus</h3>
                    <div class="prose max-w-none text-gray-600 leading-relaxed mb-8">
                        {{ $course->description }}
                    </div>

                    <h3 class="text-xl font-bold text-gray-800 mb-4 border-l-4 border-indigo-600 pl-3">Materi yang Dipelajari</h3>
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-100">
                        <ul class="space-y-3">
                            @forelse($course->contents as $index => $content)
                                <li class="flex items-start gap-3">
                                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold mt-0.5">{{ $index + 1 }}</div>
                                    <div>
                                        <p class="text-gray-700 font-medium">{{ $content->title }}</p>
                                    </div>
                                    <span class="ml-auto text-gray-400 text-xs">🔒</span>
                                </li>
                            @empty
                                <li class="text-gray-500 italic text-sm">Belum ada materi.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 sticky top-6">
                    <div class="space-y-4">
                        <div class="flex justify-between text-sm border-b pb-3 items-center">
                            <span class="text-gray-500">Pengajar</span>
                            <div class="text-right">
                                <span class="font-medium text-gray-900 block">{{ $course->teacher->name }}</span>
                                <a href="mailto:{{ $course->teacher->email }}" class="text-indigo-600 text-xs hover:underline flex items-center justify-end gap-1 mt-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    Hubungi Guru
                                </a>
                            </div>
                        </div>
                        <div class="flex justify-between text-sm border-b pb-3">
                            <span class="text-gray-500">Materi</span>
                            <span class="font-medium text-gray-900">{{ $course->contents->count() }} Bab</span>
                        </div>
                    </div>

                    <div class="mt-8">
                        @auth
                            @if($course->students()->where('user_id', auth()->id())->exists())
                                <a href="{{ route('learning.index', $course->slug) }}" class="block w-full text-center bg-green-600 text-white font-bold py-4 rounded-xl hover:bg-green-700 transition shadow-lg">Lanjut Belajar</a>
                            @else
                                <form action="{{ route('course.join', $course->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-4 rounded-xl hover:bg-indigo-700 transition shadow-lg">Ikuti Kursus Ini</button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="block w-full text-center bg-gray-800 text-white font-bold py-4 rounded-xl hover:bg-gray-900 transition">Login untuk Mendaftar</a>
                        @endauth
                    </div>
                </div>
            </div>

        </div>
    </main>
</body>
</html>