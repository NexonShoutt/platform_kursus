<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kursus Saya - EduCourse</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-extrabold text-indigo-600 flex items-center gap-2">
                        <span>🎓</span> EduCourse
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm font-medium text-gray-500 hidden md:inline">Halo, {{ auth()->user()->name }} 👋</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-500 text-sm font-bold hover:bg-red-50 px-3 py-1 rounded-md transition">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="bg-indigo-600 text-white py-12 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Pembelajaran Saya 📚</h1>
            <p class="text-indigo-200">Lanjutkan progresmu dan selesaikan kursus!</p>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 -mt-8 pb-20 relative z-20">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($courses as $course)
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden flex flex-col h-full transform hover:-translate-y-1 transition duration-300">
                    <div class="h-40 bg-gray-200 relative">
                        @if($course->thumbnail)
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-indigo-50 text-indigo-300 text-4xl">🎓</div>
                        @endif
                        <div class="absolute top-3 right-3 bg-white/90 backdrop-blur px-2 py-1 rounded text-xs font-bold text-gray-600 shadow-sm">
                            {{ $course->category->name ?? 'Umum' }}
                        </div>
                    </div>
                    
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2">{{ $course->name }}</h3>
                        
                        <div class="mt-auto">
                            <div class="flex justify-between text-xs font-bold text-gray-500 mb-1">
                                <span>Progress</span>
                                <span class="{{ $course->progress == 100 ? 'text-green-600' : 'text-indigo-600' }}">{{ $course->progress }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-3 mb-5 overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-1000 ease-out {{ $course->progress == 100 ? 'bg-green-500' : 'bg-indigo-500' }}" 
                                     style="width: {{ $course->progress }}%"></div>
                            </div>

                            <a href="{{ route('learning.index', $course->slug) }}" class="block w-full text-center {{ $course->progress == 100 ? 'bg-green-100 text-green-700' : 'bg-indigo-600 text-white' }} font-bold py-2.5 rounded-lg hover:opacity-90 transition shadow-md">
                                {{ $course->progress == 100 ? '🎉 Selesai (Review)' : 'Lanjutkan Belajar &rarr;' }}
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 bg-white p-12 rounded-xl text-center shadow-sm border border-gray-100 flex flex-col items-center">
                    <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-state-2130362-1800926.png" alt="Empty" class="w-64 mb-6 opacity-90">
                    
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Belum ada kursus yang diikuti</h3>
                    <p class="text-gray-500 mb-6 max-w-md">Wah, ruang belajarmu masih kosong nih. Yuk cari kursus menarik dan mulai belajar sekarang!</p>
                    <a href="/" class="inline-block px-8 py-3 bg-indigo-600 text-white rounded-full font-bold hover:bg-indigo-700 transition shadow-lg transform hover:-translate-y-1">
                        Cari Kursus Sekarang
                    </a>
                </div>
            @endforelse
        </div>
    </main>

</body>
</html>