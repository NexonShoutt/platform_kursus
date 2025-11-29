<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
                    <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        + Tambah User
                    </a>
                    
                    <form method="GET" class="flex gap-2">
                        <select name="role" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="">Semua Role</option>
                            <option value="teacher" {{ request('role') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                            <option value="student" {{ request('role') == 'student' ? 'selected' : '' }}>Student</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/email..." class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-bold hover:bg-indigo-700 transition">
                            Cari
                        </button>
                    </form>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-200 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 text-red-800 border border-red-200 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border p-3 text-left text-gray-700">Nama</th>
                                <th class="border p-3 text-left text-gray-700">Email</th>
                                <th class="border p-3 text-center text-gray-700">Role</th>
                                <th class="border p-3 text-center text-gray-700">Status</th>
                                <th class="border p-3 text-center text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="border p-3 font-medium text-gray-900">{{ $user->name }}</td>
                                    <td class="border p-3 text-gray-600">{{ $user->email }}</td>
                                    <td class="border p-3 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $user->role == 'admin' ? 'bg-red-100 text-red-800' : 
                                              ($user->role == 'teacher' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="border p-3 text-center">
                                        @if($user->is_active)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Non-Aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="border p-3 text-center">
                                        <div class="flex justify-center gap-3">
                                            <a href="{{ route('users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900 font-bold text-sm hover:underline">
                                                Edit
                                            </a>
                                            
                                            @if($user->id !== auth()->id())
                                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                                    @csrf 
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 font-bold text-sm hover:underline">
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $users->withQueryString()->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>