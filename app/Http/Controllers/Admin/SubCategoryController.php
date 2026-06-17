<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::with('category')->latest()->paginate(15);
        $categories = Category::orderBy('name')->get();
        return view('admin.subcategories.index', compact('subCategories', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
        ]);
        $data['slug'] = Str::slug($data['name']).'-'.uniqid();
        SubCategory::create($data);
        return back()->with('success', 'Sub kategori ditambahkan.');
    }

    public function update(Request $request, SubCategory $subCategory)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
        ]);
        $subCategory->update($data);
        return back()->with('success', 'Sub kategori diperbarui.');
    }

    public function destroy(SubCategory $subCategory)
    {
        if ($subCategory->products()->exists()) {
            return back()->with('error', 'Sub kategori tidak dapat dihapus karena masih memiliki produk.');
        }
        $subCategory->delete();
        return back()->with('success', 'Sub kategori dihapus.');
    }
}
