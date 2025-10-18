<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Categories/Index', [
            'categories'=> Category::orderBy('name')->get(),
        ]);
    }

    public function store(Request $r)
    {
        $data = $r->validate(['name'=>['required','string','max:120','unique:categories,name']]);
        Category::create($data);
        return back();
    }

    public function update(Request $r, Category $category)
    {
        $data = $r->validate(['name'=>['required','string','max:120','unique:categories,name,'.$category->id]]);
        $category->update($data);
        return back();
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back();
    }
}
