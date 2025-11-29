<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - EduCourse</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-white h-screen flex overflow-hidden">

    <div class="hidden md:flex w-1/2 bg-indigo-600 items-center justify-center relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 to-purple-700 opacity-90"></div>
        <div class="relative z-10 text-center px-10">
            <h2 class="text-4xl font-bold text-white mb-4">Selamat Datang Kembali! 👋</h2>
            <p class="text-indigo-100 text-lg mb-8">Lanjutkan perjalanan belajarmu hari ini.</p>
            <img src="https://illustrations.popsy.co/amber/remote-work.svg" alt="Login Illustration" class="w-3/4 mx-auto drop-shadow-2xl hover:scale-105 transition duration-500">
        </div>
        <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-indigo-500 rounded-full opacity-50 mix-blend-multiply filter blur-xl animate-blob"></div>
        <div class="absolute -top-20 -right-20 w-64 h-64 bg-purple-500 rounded-full opacity-50 mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
    </div>

    <div class="w-full md:w-1/2 flex items-center justify-center bg-gray-50 px-6">
        <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
            <div class="text-center mb-8">
                <a href="/" class="text-3xl font-extrabold text-indigo-600">EduCourse</a>
                <p class="text-gray-400 mt-2">Silakan masuk ke akun Anda</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 bg-red-50 text-red-500 text-sm p-3 rounded-lg border border-red-100">
                    Email atau password salah. Coba lagi ya!
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-5">
                    <label class="block text-gray-700 font-bold mb-2 text-sm">Email Address</label>
                    <input type="email" name="email" required class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-indigo-500 focus:bg-white focus:outline-none transition" placeholder="nama@email.com">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2 text-sm">Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-indigo-500 focus:bg-white focus:outline-none transition" placeholder="••••••••">
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                    Masuk Sekarang
                </button>

                <div class="mt-6 text-center text-sm text-gray-500">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-indigo-600 font-bold hover:underline">Daftar Siswa</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>