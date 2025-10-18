<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use App\Models\Category;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Products/Index', [
            'products' => Product::with('category')->latest()->paginate(15),
            'categories' => Category::orderBy('name')->get(['id','name']),
        ]);
    }

    public function store(StoreProductRequest $r)
    {
        Product::create($r->validated());
        return back()->with('ok','Produk dibuat');
    }

    public function update(StoreProductRequest $r, Product $product)
    {
        $product->update($r->validated());
        return back()->with('ok','Produk diubah');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('ok','Produk dihapus');
    }
}
