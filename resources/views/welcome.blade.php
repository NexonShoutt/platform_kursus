<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduCourse - Platform Belajar Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans flex flex-col min-h-screen">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="/" class="text-2xl font-bold text-indigo-600 flex items-center gap-2">
                    <span>🎓</span> EduCourse
                </a>

                <div class="flex items-center gap-4">
                    @auth
                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
                            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600">Dashboard</a>
                        @else
                            <a href="{{ route('my.courses') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800">Kursus Saya</a>
                        @endif
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md text-sm font-bold hover:bg-red-600 transition">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 font-medium">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-5 py-2 rounded-full font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                            Daftar Sekarang
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <header class="bg-indigo-600 text-white py-20 text-center relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        <div class="relative z-10 max-w-4xl mx-auto px-4">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight">Tingkatkan Skill Masa Depanmu</h1>
            <p class="text-lg text-indigo-100 mb-8">Pelajari keahlian baru dari mentor terbaik dengan materi yang terstruktur dan mudah dipahami.</p>
            
            <form action="/" method="GET" class="bg-white p-2 rounded-lg shadow-2xl max-w-2xl mx-auto flex flex-col md:flex-row gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kursus apa hari ini?" class="flex-grow px-4 py-3 rounded-md text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                
                <select name="category" class="px-4 py-3 rounded-md text-gray-600 bg-gray-50 border-none focus:ring-2 focus:ring-indigo-300">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="bg-indigo-800 text-white px-8 py-3 rounded-md font-bold hover:bg-indigo-900 transition">
                    Cari
                </button>
            </form>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-16 flex-grow">
        <div class="flex justify-between items-end mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Kursus Terbaru</h2>
            <a href="/" class="text-indigo-600 font-semibold hover:underline">Lihat Semua</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($courses as $course)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 overflow-hidden flex flex-col h-full group">
                    <div class="h-48 bg-gray-200 relative overflow-hidden">
                        @if($course->thumbnail)
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-indigo-50 text-indigo-300">
                                <span class="text-5xl">📚</span>
                            </div>
                        @endif
                        <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-indigo-600 shadow-sm">
                            {{ $course->category->name ?? 'Umum' }}
                        </div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 leading-tight group-hover:text-indigo-600 transition">
                            <a href="{{ route('course.show', $course->slug) }}">
                                {{ $course->name }}
                            </a>
                        </h3>
                        <p class="text-gray-500 text-sm line-clamp-2 mb-4 flex-1">
                            {{ strip_tags($course->description) }}
                        </p>
                        
                        <div class="border-t pt-4 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-600">
                                    {{ substr($course->teacher->name, 0, 1) }}
                                </div>
                                <span class="text-xs font-medium text-gray-600">{{ $course->teacher->name }}</span>
                            </div>
                            <a href="{{ route('course.show', $course->slug) }}" class="text-indigo-600 text-sm font-bold hover:underline">
                                Detail &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-20 bg-white rounded-xl border-2 border-dashed border-gray-200">
                    <p class="text-gray-400 text-lg">Belum ada kursus yang ditemukan.</p>
                    <a href="/" class="text-indigo-600 font-bold hover:underline mt-2 inline-block">Reset Filter</a>
                </div>
            @endforelse
        </div>
    </main>

    <footer class="bg-gray-900 text-white py-10 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-gray-400">&copy; {{ date('Y') }} EduCourse. Project Final Pemrograman Web.</p>
        </div>
    </footer>

</body>
</html>