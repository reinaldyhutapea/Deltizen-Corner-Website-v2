<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of categories.
     */
    public function index()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        
        return view('categories.index', [
            'title' => 'Daftar Kategori',
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('categories.create', [
            'title' => 'Tambah Kategori',
        ]);
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ], [
            'name.unique' => 'Kategori sudah ditambah.',
            'name.required' => 'Nama kategori wajib diisi.',
        ]);

        Category::create($validated);

        return redirect()->route('category.index')
            ->with('status', 'Kategori berhasil ditambah.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(int $id)
    {
        $category = Category::findOrFail($id);
        
        // Check if category has products
        if ($category->products()->exists()) {
            return redirect()->back()
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk.');
        }
        
        $category->delete();
        
        return redirect()->back()
            ->with('status', 'Anda berhasil menghapus kategori');
    }
}