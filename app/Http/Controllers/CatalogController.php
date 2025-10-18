<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Inertia\Inertia;

class CatalogController extends Controller
{
    public function index()
    {
        $q = request('q');
        $categoryId = request('category_id');

        $products = Product::query()
            ->when($q, fn($s)=>$s->where('name','like',"%$q%"))
            ->when($categoryId, fn($s)=>$s->where('category_id',$categoryId))
            ->where('is_active', true)
            ->latest()->paginate(12)->withQueryString();

        $categories = Category::orderBy('name')->get(['id','name']);

        return Inertia::render('Catalog/Index', [
            'products'   => $products,
            'categories' => $categories,
            'filters'    => ['q'=>$q,'category_id'=>$categoryId],
        ]);
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);
        $product->load('category');
        return Inertia::render('Catalog/Show', ['product'=>$product]);
    }
}
