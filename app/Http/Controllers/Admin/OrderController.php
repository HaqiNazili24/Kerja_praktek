<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $q = Order::with('user')->latest();
        if ($request->filled('status')) $q->where('status', $request->status);
        if ($request->filled('search')) {
            $kw = $request->search;
            $q->where(fn($x) => $x->where('order_number', 'like', "%$kw%")
                ->orWhereHas('user', fn($u) => $u->where('full_name', 'like', "%$kw%")));
        }
        $orders = $q->paginate(15)->withQueryString();
        $statuses = Order::STATUSES;
        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'user', 'address');
        return view('admin.orders.show', compact('order'));
    }

    public function confirmPayment(Order $order)
    {
        abort_unless($order->status === 'pembayaran_dikirim', 422);
        DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                $product = $item->product;
                if ($product) {
                    $product->decrement('stock', min($item->quantity, $product->stock));
                }
            }
            $order->update(['status' => 'pembayaran_dikonfirmasi']);
        });
        return back()->with('success', 'Pembayaran dikonfirmasi & stok berkurang.');
    }

    public function rejectPayment(Request $request, Order $order)
    {
        abort_unless($order->status === 'pembayaran_dikirim', 422);
        $request->validate(['rejection_reason' => 'required|string|max:500']);
        $order->update([
            'status' => 'menunggu_pembayaran',
            'rejection_reason' => $request->rejection_reason,
            'payment_proof_url' => null,
        ]);
        return back()->with('success', 'Pembayaran ditolak. Customer dapat mengupload ulang.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:diproses,dikirim,selesai',
            'tracking_number' => 'nullable|string|max:100',
        ]);
        $update = ['status' => $request->status];
        if ($request->filled('tracking_number')) $update['tracking_number'] = $request->tracking_number;
        $order->update($update);
        return back()->with('success', 'Status pesanan diperbarui.');
    }
}
