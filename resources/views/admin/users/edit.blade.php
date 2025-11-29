<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700 mb-2">Peran (Role)</label>
                        <select name="role" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Student (Siswa)</option>
                            <option value="teacher" {{ $user->role == 'teacher' ? 'selected' : '' }}>Teacher (Guru)</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <div class="mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <label class="block font-bold text-sm text-gray-800 mb-2">Status Akun</label>
                        <select name="is_active" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="1" {{ $user->is_active ? 'selected' : '' }}>✅ Aktif (Bisa Login)</option>
                            <option value="0" {{ !$user->is_active ? 'selected' : '' }}>❌ Non-Aktif (Blokir Login)</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Jika Non-Aktif, user tidak akan bisa login ke dalam sistem.</p>
                    </div>

                    <div class="mb-6 border-t pt-4">
                        <h3 class="text-sm font-bold text-gray-700 mb-3">Ubah Password (Opsional)</h3>
                        <div class="mb-4">
                            <label class="block text-xs text-gray-500 mb-1">Password Baru</label>
                            <input type="password" name="password" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Update User
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>