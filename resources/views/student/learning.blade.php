<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $currentContent->title }} - {{ $course->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .prose h1 { font-size: 2em; font-weight: bold; margin-bottom: 0.5em; }
        .prose p { margin-bottom: 1em; line-height: 1.6; }
        .prose ul { list-style: disc; margin-left: 1.5em; }
        .prose img { max-width: 100%; border-radius: 0.5rem; }
    </style>
</head>
<body class="bg-gray-100 h-screen flex flex-col font-sans overflow-hidden">

    <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-4 lg:px-8 flex-shrink-0 z-20">
        <div class="flex items-center gap-4">
            <a href="{{ route('course.show', $course->slug) }}" class="text-gray-500 hover:text-indigo-600 transition">
                &larr; <span class="hidden md:inline">Detail Kursus</span>
            </a>
            <h1 class="text-lg font-bold text-gray-800 truncate max-w-md">{{ $course->name }}</h1>
        </div>
        <div class="text-sm font-medium text-gray-600">
            Halo, {{ auth()->user()->name }}
        </div>
    </header>

    <div class="flex flex-1 overflow-hidden">
        
        <aside class="w-80 bg-white border-r border-gray-200 overflow-y-auto hidden md:block flex-shrink-0">
            <div class="p-4 border-b bg-gray-50">
                <h3 class="font-bold text-gray-700 text-sm uppercase tracking-wide">Daftar Materi</h3>
            </div>
            <ul>
                @foreach($contents as $index => $content)
                    @php
                        $isActive = $content->id == $currentContent->id;
                        $isDone = $content->users()->where('user_id', auth()->id())->exists();
                    @endphp
                    <li>
                        <a href="{{ route('learning.content', [$course->slug, $content->id]) }}" 
                           class="flex items-center p-4 border-l-4 transition hover:bg-gray-50 {{ $isActive ? 'border-indigo-600 bg-indigo-50' : 'border-transparent' }}">
                            
                            <div class="mr-3">
                                @if($isDone)
                                    <span class="text-green-500 text-xl">✓</span>
                                @else
                                    <span class="flex items-center justify-center w-6 h-6 rounded-full text-xs font-bold {{ $isActive ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-600' }}">
                                        {{ $index + 1 }}
                                    </span>
                                @endif
                            </div>

                            <div>
                                <p class="text-sm font-medium {{ $isActive ? 'text-indigo-700' : 'text-gray-700' }}">
                                    {{ $content->title }}
                                </p>
                                <p class="text-xs text-gray-400 mt-0.5">Materi Pembelajaran</p>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </aside>

        <main class="flex-1 overflow-y-auto bg-gray-100 p-6 md:p-10">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    
                    <div class="p-8 border-b border-gray-100">
                        <span class="text-xs font-bold text-indigo-500 uppercase tracking-widest">BAB {{ $currentContent->sort_order }}</span>
                        <h2 class="text-3xl font-bold text-gray-900 mt-2">{{ $currentContent->title }}</h2>
                    </div>

                    <div class="p-8 prose max-w-none text-gray-700">
                        {!! $currentContent->body !!}
                    </div>

                    <div class="p-8 bg-gray-50 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
                        
                        <div class="text-sm">
                            @if($isCompleted)
                                <span class="text-green-600 font-bold flex items-center gap-2">
                                    <span>🎉</span> Anda sudah menyelesaikan materi ini.
                                </span>
                            @else
                                <span class="text-gray-500 italic">Baca materi sampai selesai untuk lanjut.</span>
                            @endif
                        </div>

                        <div>
                            @if(!$isCompleted)
                                <form action="{{ route('learning.complete', [$course->slug, $currentContent->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-indigo-700 transition shadow-md flex items-center gap-2">
                                        ✅ Tandai Selesai
                                    </button>
                                </form>
                            @elseif($nextContent)
                                <a href="{{ route('learning.content', [$course->slug, $nextContent->id]) }}" class="bg-white border border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-bold hover:bg-gray-50 transition shadow-sm flex items-center gap-2">
                                    Lanjut Materi Berikutnya &rarr;
                                </a>
                            @else
                                <button disabled class="bg-gray-200 text-gray-400 px-6 py-3 rounded-lg font-bold cursor-not-allowed">
                                    Ini Materi Terakhir
                                </button>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </main>

    </div>

</body>
</html>