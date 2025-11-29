<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    // 1. DAFTAR KURSUS
    public function index()
    {
        // Logika: Jika Teacher, tampilkan kursus miliknya saja.
        // Jika Admin, tampilkan semuanya.
        $user = Auth::user();
        
        if ($user->role === 'teacher') {
            $courses = Course::where('teacher_id', $user->id)->latest()->get();
        } else {
            $courses = Course::latest()->get();
        }

        return view('admin.courses.index', compact('courses'));
    }

    // 2. FORM TAMBAH
    public function create()
    {
        // Kita butuh data kategori untuk dropdown
        $categories = Category::all();
        return view('admin.courses.create', compact('categories'));
    }

    // 3. SIMPAN DATA
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Validasi Gambar
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Upload Gambar
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Course::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'teacher_id' => Auth::id(), // Otomatis set pengajar = user yang login
            'category_id' => $request->category_id,
            'thumbnail' => $thumbnailPath,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('courses.index')->with('success', 'Kursus berhasil dibuat!');
    }

    // 4. FORM EDIT
    public function edit(Course $course)
    {
        // Pastikan Teacher tidak mengedit kursus orang lain
        if (Auth::user()->role === 'teacher' && $course->teacher_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengedit kursus ini.');
        }

        $categories = Category::all();
        return view('admin.courses.edit', compact('course', 'categories'));
    }

    // 5. UPDATE DATA
    public function update(Request $request, Course $course)
    {
        // Cek otorisasi lagi
        if (Auth::user()->role === 'teacher' && $course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image|max:2048', // Nullable: tidak wajib ganti gambar
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Data yang akan diupdate
        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ];

        // Cek jika ada upload gambar baru
        if ($request->hasFile('thumbnail')) {
            // Hapus gambar lama jika ada
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            // Upload baru
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $course->update($data);

        return redirect()->route('courses.index')->with('success', 'Kursus berhasil diperbarui!');
    }

    // 6. HAPUS DATA
    public function destroy(Course $course)
    {
        if (Auth::user()->role === 'teacher' && $course->teacher_id !== Auth::id()) {
            abort(403);
        }

        // Hapus gambar dari penyimpanan
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }

        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Kursus dihapus!');
    }
}