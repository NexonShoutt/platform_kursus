<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    // 1. HOMEPAGE (Daftar Kursus)
    public function index(Request $request)
    {
        // Query Dasar: Hanya kursus yang AKTIF
        $query = Course::where('is_active', true);

        // Filter Pencarian (Search)
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Filter Kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Ambil data (terbaru)
        $courses = $query->latest()->get();
        
        // Ambil semua kategori untuk dropdown filter
        $categories = Category::all();

        return view('welcome', compact('courses', 'categories'));
    }

    // 2. DETAIL KURSUS
    public function show(Course $course)
    {
        // Pastikan kursus aktif
        if (!$course->is_active) {
            abort(404);
        }

        // Load materi agar bisa ditampilkan list-nya
        $course->load(['contents' => function ($q) {
            $q->orderBy('sort_order');
        }]);

        return view('public.course.show', compact('course'));
    }
}