<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - EduCourse</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-white h-screen flex overflow-hidden">

    <div class="w-full md:w-1/2 flex flex-col justify-center px-8 md:px-16 lg:px-24 bg-white relative z-10 overflow-y-auto">
        
        <div class="md:hidden mb-8 text-center mt-8">
            <a href="/" class="text-3xl font-extrabold text-indigo-600">EduCourse</a>
        </div>

        <div class="mb-8">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Mulai Belajar 🚀</h2>
            <p class="text-gray-500">Buat akun siswa baru dan akses semua materi.</p>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" required class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition" placeholder="Contoh: Andi Belajar">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Email</label>
                <input type="email" name="email" required class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition" placeholder="nama@email.com">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition" placeholder="Min. 8 karakter">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi</label>
                    <input type="password" name="password_confirmation" required class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition" placeholder="Ulangi password">
                </div>
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3.5 rounded-lg hover:bg-indigo-700 transition duration-300 shadow-lg shadow-indigo-200 transform hover:-translate-y-0.5">
                Daftar Sekarang
            </button>

            <p class="text-center text-sm text-gray-500 mt-6">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:underline transition">Masuk disini</a>
            </p>
        </form>
    </div>

    <div class="hidden md:flex w-1/2 bg-indigo-50 relative items-center justify-center overflow-hidden">
        <div class="absolute top-0 -right-20 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-70"></div>
        <div class="absolute bottom-0 -left-20 w-96 h-96 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-70"></div>

        <div class="relative z-10 text-center p-10">
            <img src="https://illustrations.popsy.co/amber/man-riding-a-rocket.svg" alt="Register Illustration" class="w-4/5 mx-auto mb-8 drop-shadow-xl hover:rotate-2 transition duration-500">
            
            <h3 class="text-3xl font-bold text-gray-800 mb-2">Siap Meluncur?</h3>
            <p class="text-gray-600 max-w-md mx-auto">Bergabunglah dengan ribuan siswa lainnya.</p>
        </div>
    </div>

</body>
</html>