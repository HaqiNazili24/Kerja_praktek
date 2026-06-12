<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::with('product')->where('user_id', auth()->id())->get();
        $total = $items->sum(fn($i) => $i->subtotal);
        return view('customer.cart.index', compact('items', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $qty = max(1, (int) $request->input('quantity', 1));
        if (! $product->is_active || $product->stock < 1) {
            return back()->with('error', 'Produk tidak tersedia.');
        }
        $qty = min($qty, $product->stock);
        $cart = Cart::firstOrNew(['user_id' => auth()->id(), 'product_id' => $product->id]);
        $cart->quantity = min($product->stock, ($cart->quantity ?? 0) + $qty);
        $cart->save();
        return redirect()->route('cart.index')->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function update(Request $request, Cart $cart)
    {
        abort_if($cart->user_id !== auth()->id(), 403);
        $qty = max(1, min((int) $request->quantity, $cart->product->stock));
        $cart->update(['quantity' => $qty]);
        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove(Cart $cart)
    {
        abort_if($cart->user_id !== auth()->id(), 403);
        $cart->delete();
        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}