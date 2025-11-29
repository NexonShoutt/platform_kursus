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
    // ==========================================
    // AREA ADMIN & TEACHER (MANAJEMEN KURSUS)
    // ==========================================

    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'teacher') {
            $courses = Course::where('teacher_id', $user->id)->latest()->get();
        } else {
            $courses = Course::latest()->get();
        }

        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.courses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:courses,name',
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $slug = Str::slug($request->name);
        if (Course::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . time();
        }

        Course::create([
            'name' => $request->name,
            'slug' => $slug,
            'teacher_id' => Auth::id(),
            'category_id' => $request->category_id,
            'thumbnail' => $thumbnailPath,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('courses.index')->with('success', 'Kursus berhasil dibuat!');
    }

    public function edit(Course $course)
    {
        if (Auth::user()->role === 'teacher' && $course->teacher_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengedit kursus ini.');
        }

        $categories = Category::all();
        return view('admin.courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, Course $course)
    {
        if (Auth::user()->role === 'teacher' && $course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:courses,name,' . $course->id,
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image|max:2048',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ];

        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $course->update($data);

        return redirect()->route('courses.index')->with('success', 'Kursus berhasil diperbarui!');
    }

    public function destroy(Course $course)
    {
        if (Auth::user()->role === 'teacher' && $course->teacher_id !== Auth::id()) {
            abort(403);
        }

        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }

        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Kursus dihapus!');
    }

    // Monitoring Siswa (Untuk Teacher)
    public function students(Course $course)
    {
        if (Auth::user()->role === 'teacher' && $course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $students = $course->students;
        $totalContents = $course->contents->count();

        foreach ($students as $student) {
            $completedCount = $course->contents->filter(function ($content) use ($student) {
                return $content->users->contains($student->id);
            })->count();

            $student->progress = $totalContents > 0 ? round(($completedCount / $totalContents) * 100) : 0;
        }

        return view('admin.courses.students', compact('course', 'students'));
    }

    // ==========================================
    // AREA SISWA (DASHBOARD KURSUS SAYA) - INI YANG TADI HILANG
    // ==========================================
    
    public function myCourses()
    {
        $user = Auth::user();

        // Ambil kursus yang diikuti user, hitung progress
        $courses = $user->courses()->with(['contents.users' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])->get()->map(function ($course) use ($user) {
            
            $totalContents = $course->contents->count();
            
            $completedContents = $course->contents->filter(function ($content) use ($user) {
                return $content->users->contains($user->id);
            })->count();

            $percentage = $totalContents > 0 ? round(($completedContents / $totalContents) * 100) : 0;
            
            $course->progress = $percentage;
            
            return $course;
        });

        // Pastikan view ini ada (Langkah 2 di bawah)
        return view('student.my-courses', compact('courses'));
    }
}