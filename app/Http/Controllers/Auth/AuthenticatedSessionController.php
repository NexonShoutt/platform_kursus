<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = auth()->user();

        // 1. CEK STATUS AKTIF/NON-AKTIF
        if ($user->is_active == 0) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors(['email' => 'Akun Anda dinonaktifkan oleh Admin.']);
        }

        $request->session()->regenerate();

        // 2. REDIRECT BERDASARKAN ROLE (LOGIKA BARU)
        
        // Jika Siswa -> Ke Halaman Belajar Saya
        if ($user->role === 'student') {
            return redirect()->route('my.courses');
        }
        
        // Jika Admin -> Ke Manajemen User (Tabel User)
        if ($user->role === 'admin') {
            return redirect()->route('users.index');
        }

        // Jika Teacher -> Ke Manajemen Kursus (Tabel Kursus)
        if ($user->role === 'teacher') {
            return redirect()->route('courses.index');
        }

        // Default (jika ada role lain)
        return redirect()->intended(route('home'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}