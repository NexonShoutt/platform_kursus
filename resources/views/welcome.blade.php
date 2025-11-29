<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduCourse - Belajar Seru!</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; }
        
        /* Animasi Melayang (Floating) untuk Ilustrasi */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .floating-img {
            animation: float 4s ease-in-out infinite;
        }

        /* Background Pattern Halus */
        .bg-pattern {
            background-color: #f9fafb;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%236366f1' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="bg-pattern text-gray-800 flex flex-col min-h-screen overflow-x-hidden">

    <nav class="fixed w-full z-50 transition duration-300 bg-white/90 backdrop-blur-md shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="/" class="text-2xl font-extrabold text-indigo-600 flex items-center gap-2 tracking-wide">
                    <span class="text-3xl">🚀</span> EduCourse
                </a>

                <div class="flex items-center gap-4">
                    @auth
                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
                            <a href="{{ route('dashboard') }}" class="text-sm font-bold text-gray-600 hover:text-indigo-600 transition">Dashboard</a>
                        @else
                            <a href="{{ route('my.courses') }}" class="text-sm font-bold text-gray-600 hover:text-indigo-600 transition">Kursus Saya</a>
                        @endif
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-red-100 text-red-600 px-4 py-2 rounded-full text-sm font-bold hover:bg-red-200 transition">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 font-bold transition">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-6 py-2.5 rounded-full font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 transform hover:-translate-y-0.5">
                            Daftar Sekarang
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <header class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1951&q=80" alt="Background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-900/95 to-indigo-800/80"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 flex flex-col-reverse lg:flex-row items-center gap-12">
            <div class="lg:w-1/2 text-center lg:text-left" data-aos="fade-right" data-aos-duration="1000">
                <span class="inline-block py-1 px-3 rounded-full bg-yellow-400 text-yellow-900 text-xs font-bold mb-4 uppercase tracking-wider shadow-md">
                    ✨ Platform Belajar #1
                </span>
                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 leading-tight">
                    Belajar Skill Baru,<br>
                    <span class="text-yellow-300">Buka Masa Depan!</span>
                </h1>
                <p class="text-lg text-indigo-100 mb-8 leading-relaxed">
                    Akses ratusan materi pembelajaran interaktif dari mentor berpengalaman. Mulai perjalananmu sekarang dengan cara yang menyenangkan.
                </p>
                
                <form action="/" method="GET" class="bg-white p-2 rounded-2xl shadow-2xl flex flex-col md:flex-row gap-2 max-w-lg mx-auto lg:mx-0 transform hover:scale-105 transition duration-300">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Mau belajar apa hari ini?" class="flex-grow px-6 py-3 rounded-xl text-gray-800 focus:outline-none focus:ring-0 bg-transparent placeholder-gray-400">
                    <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-indigo-700 transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Cari
                    </button>
                </form>
            </div>

            <div class="lg:w-1/2 flex justify-center" data-aos="fade-left" data-aos-duration="1000">
                <img src="https://42f2671d685f51e10fc6-b9fcecea3e50b3b59bdc28dead054ebc.ssl.cf5.rackcdn.com/illustrations/learning_sketching_nd4f.svg" 
                     alt="Learning Illustration" 
                     class="w-full max-w-md drop-shadow-2xl floating-img">
            </div>
        </div>

        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
            <svg class="relative block w-full h-[50px] md:h-[100px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="fill-gray-50"></path>
            </svg>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-20 flex-grow relative z-10">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Jelajahi Kursus Populer</h2>
            <div class="w-24 h-1.5 bg-indigo-600 mx-auto rounded-full"></div>
        </div>

        <div class="flex flex-wrap justify-center gap-4 mb-12" data-aos="fade-up" data-aos-delay="100">
            <a href="/" class="px-6 py-2 rounded-full border-2 {{ !request('category') ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-200 hover:border-indigo-600 hover:text-indigo-600' }} font-bold transition">
                Semua
            </a>
            @foreach($categories as $cat)
                <a href="/?category={{ $cat->id }}" class="px-6 py-2 rounded-full border-2 {{ request('category') == $cat->id ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-200 hover:border-indigo-600 hover:text-indigo-600' }} font-bold transition">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($courses as $index => $course)
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition duration-500 transform hover:-translate-y-2 border border-gray-100 overflow-hidden flex flex-col h-full" 
                     data-aos="fade-up" 
                     data-aos-delay="{{ $index * 100 }}"> <div class="h-52 bg-gray-200 relative overflow-hidden group">
                        @if($course->thumbnail)
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->name }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-indigo-50 text-indigo-300">
                                <span class="text-6xl">🎓</span>
                            </div>
                        @endif
                        
                        <div class="absolute inset-0 bg-indigo-900/0 group-hover:bg-indigo-900/40 transition duration-500 flex items-center justify-center">
                            <a href="{{ route('course.show', $course->slug) }}" class="opacity-0 group-hover:opacity-100 bg-white text-indigo-600 px-6 py-2 rounded-full font-bold transform translate-y-4 group-hover:translate-y-0 transition duration-500 shadow-lg">
                                Lihat Detail
                            </a>
                        </div>

                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1 rounded-lg text-xs font-bold text-indigo-600 shadow-sm">
                            {{ $course->category->name ?? 'Umum' }}
                        </div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-xl font-bold text-gray-900 mb-3 leading-tight">
                            <a href="{{ route('course.show', $course->slug) }}" class="hover:text-indigo-600 transition">
                                {{ $course->name }}
                            </a>
                        </h3>
                        <p class="text-gray-500 text-sm line-clamp-2 mb-6 flex-1">
                            {{ strip_tags($course->description) }}
                        </p>
                        
                        <div class="border-t border-gray-100 pt-4 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-sm font-bold text-indigo-600 border-2 border-white shadow-sm">
                                    {{ substr($course->teacher->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400">Pengajar</p>
                                    <p class="text-sm font-bold text-gray-700">{{ Str::limit($course->teacher->name, 15) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-20">
                    <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-state-2130362-1800926.png" alt="Empty" class="w-64 mx-auto mb-6 opacity-70">
                    <p class="text-gray-500 text-xl font-medium">Yah, belum ada kursus yang ditemukan.</p>
                    <a href="/" class="text-indigo-600 font-bold hover:underline mt-2 inline-block">Coba kata kunci lain</a>
                </div>
            @endforelse
        </div>
    </main>

    <footer class="bg-gray-900 text-white pt-16 pb-8 border-t-4 border-indigo-500">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-6">Siap Belajar Hal Baru? 🚀</h2>
            <div class="flex justify-center gap-6 mb-8">
                <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-indigo-600 transition">IG</a>
                <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-indigo-600 transition">TW</a>
                <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-indigo-600 transition">YT</a>
            </div>
            <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} EduCourse Project. Dibuat dengan ❤️ dan Kopi.</p>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true, // Animasi hanya sekali saat scroll
            offset: 100, // Mulai animasi sedikit sebelum elemen muncul
        });
    </script>
</body>
</html>