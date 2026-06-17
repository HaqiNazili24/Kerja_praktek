<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('subCategory.category')->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $subCategories = SubCategory::with('category')->get();
        return view('admin.products.create', compact('subCategories'));
    }

    public function store(Request $request)
    {
        $data = $this->validateProduct($request);
        $data['slug'] = Str::slug($data['name']).'-'.uniqid();
        $data['is_active'] = $request->boolean('is_active', true);
        if ($request->hasFile('image')) {
            $data['image_url'] = $request->file('image')->store('products', 'public');
        }
        Product::create($data);
        return redirect()->route('admin.products.index')->with('success', 'Produk ditambahkan.');
    }

    public function edit(Product $product)
    {
        $subCategories = SubCategory::with('category')->get();
        return view('admin.products.edit', compact('product', 'subCategories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateProduct($request);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) {
            if ($product->image_url) {
                Storage::disk('public')->delete($product->image_url);
            }
            $data['image_url'] = $request->file('image')->store('products', 'public');
        }
        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Produk diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->hasOrders()) {
            $product->update(['is_active' => false]);
            return back()->with('error', 'Produk memiliki pesanan, hanya dinonaktifkan.');
        }
        if ($product->image_url) {
            Storage::disk('public')->delete($product->image_url);
        }
        $product->delete();
        return back()->with('success', 'Produk dihapus.');
    }

    private function validateProduct(Request $request): array
    {
        return $request->validate([
            'sub_category_id' => 'required|exists:sub_categories,id',
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'price'           => 'required|numeric|min:0',
            'weight_label'    => 'required|string|max:50',
            'stock'           => 'required|integer|min:0',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    }
}   