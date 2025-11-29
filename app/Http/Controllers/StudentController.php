<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    // 1. FITUR MENDAFTAR (ENROLL)
    public function enroll(Course $course)
    {
        // Cek apakah user sudah terdaftar?
        if ($course->students()->where('user_id', Auth::id())->exists()) {
            return redirect()->route('learning.index', $course->slug);
        }

        // Simpan data pendaftaran ke tabel pivot course_user
        $course->students()->attach(Auth::id());

        return redirect()->route('learning.index', $course->slug)
            ->with('success', 'Berhasil mendaftar! Selamat belajar.');
    }

    // 2. HALAMAN BELAJAR (LEARNING PAGE)
    public function index(Course $course, $contentId = null)
    {
        // Cek: Apakah user sudah terdaftar di kursus ini?
        if (! $course->students()->where('user_id', Auth::id())->exists()) {
            return redirect()->route('course.show', $course->slug)
                ->with('error', 'Anda harus mendaftar terlebih dahulu.');
        }

        // Ambil semua materi urut dari 1, 2, 3...
        $contents = $course->contents()->orderBy('sort_order')->get();

        // Tentukan materi mana yang sedang dibuka
        // Jika $contentId kosong, ambil materi pertama
        $currentContent = $contentId 
            ? $contents->where('id', $contentId)->first() 
            : $contents->first();

        // Jika materi tidak ditemukan (misal kursus kosong), handle error
        if (!$currentContent) {
            return redirect()->back()->with('error', 'Belum ada materi di kursus ini.');
        }

        // Cek apakah materi ini sudah "Selesai" oleh siswa?
        $isCompleted = $currentContent->users()->where('user_id', Auth::id())->exists();

        // Cari materi selanjutnya (untuk tombol Next)
        $nextContent = $contents->where('sort_order', '>', $currentContent->sort_order)->first();

        return view('student.learning', compact('course', 'contents', 'currentContent', 'isCompleted', 'nextContent'));
    }

    // 3. TANDAI SELESAI (MARK AS DONE)
    public function complete(Course $course, Content $content)
    {
        // Simpan data "Selesai" ke tabel pivot content_user
        $content->users()->syncWithoutDetaching([Auth::id() => ['completed_at' => now()]]);

        // Cari materi selanjutnya
        $nextContent = $course->contents()
            ->where('sort_order', '>', $content->sort_order)
            ->orderBy('sort_order')
            ->first();

        // Jika ada materi selanjutnya, redirect ke sana
        if ($nextContent) {
            return redirect()->route('learning.index', ['course' => $course->slug, 'contentId' => $nextContent->id]);
        }

        // Jika materi habis, tetap di halaman ini
        return redirect()->route('learning.index', ['course' => $course->slug, 'contentId' => $content->id])
            ->with('success', 'Selamat! Anda telah menyelesaikan semua materi.');
    }
}