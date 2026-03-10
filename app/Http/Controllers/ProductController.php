<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;

class ProductController extends Controller
{
    /**
     * Constructor - apply auth middleware
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $title = 'Master Product';
        $products = Product::with('category')->orderBy('name', 'asc')->get();
        $categories = Category::orderBy('name', 'asc')->get();

        return view('admin.products.index', compact('title', 'products', 'categories'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $title = 'Create Product';
        $categories = Category::orderBy('name', 'asc')->get();

        return view('admin.products.index', compact('title', 'categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        $product = new Product();
        $product->name = $validated['name'];
        $product->description = $validated['description'];
        $product->price = $validated['price'];
        $product->stock = 1;
        $product->stoks = $validated['stoks'];
        $product->category_id = $validated['category_id'];

        if ($request->hasFile('image')) {
            $product->image = $this->uploadImage($request->file('image'), $validated['name']);
        }

        $product->save();

        return redirect()->back()->with('status', 'Anda berhasil menambahkan produk');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit($id)
    {
        $title = 'Edit Product';
        $product = Product::with('category')->findOrFail($id);
        $categories = Category::orderBy('name', 'asc')->get();

        return view('admin.products.edit', compact('product', 'title', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $validated = $request->validated();
        $product = Product::findOrFail($id);

        $product->name = $validated['name'];
        $product->description = $validated['description'];
        $product->price = $validated['price'];
        $product->stoks = $validated['stoks'];
        $product->category_id = $validated['category_id'];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            $this->deleteImage($product->image);

            // Upload new image
            $product->image = $this->uploadImage($request->file('image'), $validated['name']);
        }

        $product->save();

        return redirect()->route('product.index')->with('status', 'Anda berhasil mengubah data produk');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete product image if exists
        $this->deleteImage($product->image);

        // Soft delete the product
        $product->delete();

        return redirect()->back()->with('status', 'Anda berhasil menghapus produk: ' . $product->name);
    }

    /**
     * Display the specified product.
     */
    public function detail($id)
    {
        $product = Product::with('category')->findOrFail($id);

        return view('admin.products.detail', compact('product'));
    }

    /**
     * Toggle product stock availability.
     */
    public function changeStoks($id)
    {
        $product = Product::findOrFail($id);
        $product->stoks = $product->stoks == 0 ? 1 : 0;
        $product->save();

        $status = $product->stoks ? 'tersedia' : 'habis';

        return redirect()->back()->with('status', "Stok produk {$product->name} berhasil diubah menjadi {$status}");
    }

    /**
     * Get product data for DataTables.
     */
    public function produkData()
    {
        $data = Product::with('category')
            ->select('products.*')
            ->orderBy('name', 'asc');

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('cname', function ($product) {
                return $product->category ? $product->category->name : '-';
            })
            ->addColumn('action', function ($product) {
                $editBtn = '<a href="' . route('product.edit', $product->id) . '" class="btn btn-xs btn-success" title="Edit">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>';
                $detailBtn = '<a href="' . route('product.detail', $product->id) . '" class="btn btn-xs btn-warning" title="Detail">
                    <i class="fa-solid fa-circle-info"></i>
                </a>';

                return $editBtn . ' ' . $detailBtn;
            })
            ->editColumn('image', function ($product) {
                return '<img src="' . url($product->image) . '" alt="' . $product->name . '" style="max-width: 100px; max-height: 100px;">';
            })
            ->editColumn('stoks', function ($product) {
                if ($product->stoks == 0) {
                    return '<a href="' . route('change.stoks', $product->id) . '" class="btn btn-xs btn-danger">Habis</a>';
                }
                return '<a href="' . route('change.stoks', $product->id) . '" class="btn btn-xs btn-primary">Ada</a>';
            })
            ->editColumn('price', function ($product) {
                return 'Rp. ' . number_format($product->price, 0, ',', '.');
            })
            ->rawColumns(['image', 'action', 'stoks'])
            ->make(true);
    }

    /**
     * Upload product image.
     */
    private function uploadImage($file, $productName): string
    {
        $imageName = Str::slug($productName, '-') . '-' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('/upload/products/'), $imageName);

        return '/upload/products/' . $imageName;
    }

    /**
     * Delete product image if exists.
     */
    private function deleteImage(?string $imagePath): void
    {
        if ($imagePath && file_exists(public_path($imagePath))) {
            @unlink(public_path($imagePath));
        }
    }
}
