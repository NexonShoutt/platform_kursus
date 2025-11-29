<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kursus Saya - EduCourse</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

    <nav class="bg-white shadow mb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold text-indigo-600">EduCourse</a>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-500">Halo, {{ auth()->user()->name }}</span>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-500 text-sm font-bold hover:underline">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 pb-20">
        <h1 class="text-3xl font-bold mb-8 text-gray-900">Pembelajaran Saya</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($courses as $course)
                <div class="bg-white rounded-lg shadow border border-gray-100 overflow-hidden flex flex-col">
                    <div class="h-32 bg-indigo-50 flex items-center justify-center overflow-hidden">
                        @if($course->thumbnail)
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-4xl">🎓</span>
                        @endif
                    </div>
                    
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $course->name }}</h3>
                        
                        <div class="mt-auto">
                            <div class="flex justify-between text-xs font-semibold text-gray-600 mb-1">
                                <span>Progress</span>
                                <span>{{ $course->progress }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                                <div class="bg-indigo-600 h-2.5 rounded-full transition-all duration-500" 
                                     style="width: {{ $course->progress }}%"></div>
                            </div>

                            <a href="{{ route('learning.index', $course->slug) }}" class="block w-full text-center bg-indigo-600 text-white font-bold py-2 rounded hover:bg-indigo-700 transition">
                                Lanjutkan Belajar
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 bg-white rounded-lg border border-dashed border-gray-300">
                    <p class="text-gray-500 text-lg mb-4">Anda belum mengikuti kursus apapun.</p>
                    <a href="/" class="inline-block px-6 py-2 bg-indigo-600 text-white rounded font-bold hover:bg-indigo-700">
                        Cari Kursus Sekarang
                    </a>
                </div>
            @endforelse
        </div>
    </main>

</body>
</html>