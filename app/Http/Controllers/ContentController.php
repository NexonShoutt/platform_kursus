<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentController extends Controller
{
    // 1. Tampilkan Daftar Materi per Kursus
    public function index(Course $course)
    {
        // Cek Otorisasi: Teacher cuma boleh lihat materi kursusnya sendiri
        if (Auth::user()->role === 'teacher' && $course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $contents = $course->contents()->orderBy('sort_order', 'asc')->get();
        return view('admin.contents.index', compact('course', 'contents'));
    }

    // 2. Form Tambah Materi
    public function create(Course $course)
    {
        return view('admin.contents.create', compact('course'));
    }

    // 3. Simpan Materi
    public function store(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'sort_order' => 'required|integer',
            'body' => 'required',
        ]);

        $course->contents()->create([
            'title' => $request->title,
            'sort_order' => $request->sort_order,
            'body' => $request->body,
        ]);

        return redirect()->route('courses.contents.index', $course->id)
                         ->with('success', 'Materi berhasil ditambahkan!');
    }

    // 4. Form Edit
    public function edit(Course $course, Content $content)
    {
        return view('admin.contents.edit', compact('course', 'content'));
    }

    // 5. Update Materi
    public function update(Request $request, Course $course, Content $content)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'sort_order' => 'required|integer',
            'body' => 'required',
        ]);

        $content->update($request->all());

        return redirect()->route('courses.contents.index', $course->id)
                         ->with('success', 'Materi berhasil diperbarui!');
    }

    // 6. Hapus Materi
    public function destroy(Course $course, Content $content)
    {
        $content->delete();
        return redirect()->route('courses.contents.index', $course->id)
                         ->with('success', 'Materi dihapus!');
    }
}