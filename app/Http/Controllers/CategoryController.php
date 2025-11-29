<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // 1. READ: Tampilkan daftar kategori
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    // 2. CREATE: Tampilkan form tambah
    public function create()
    {
        return view('admin.categories.create');
    }

    // 3. STORE: Simpan data ke database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
        ]);

        // Simpan
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name), // Buat slug otomatis (Web Design -> web-design)
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dibuat!');
    }

    // 4. EDIT: Tampilkan form edit
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // 5. UPDATE: Simpan perubahan
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diupdate!');
    }

    // 6. DELETE: Hapus data
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}