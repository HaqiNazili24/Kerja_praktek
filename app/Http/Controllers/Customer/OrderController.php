<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->paginate(10);
        return view('customer.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        $order->load('items.product');
        return view('customer.orders.show', compact('order'));
    }

    public function uploadProof(Request $request, Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        abort_unless(in_array($order->status, ['menunggu_pembayaran']), 422, 'Status tidak valid untuk upload bukti.');
        $request->validate([
            'payment_proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ]);
        $path = $request->file('payment_proof')->store('payments', 'public');
        $order->update([
            'payment_proof_url' => $path,
            'status' => 'pembayaran_dikirim',
            'rejection_reason' => null,
        ]);
        return back()->with('success', 'Bukti pembayaran berhasil diupload.');
    }

    public function cancel(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        abort_unless($order->status === 'menunggu_pembayaran', 422, 'Hanya pesanan yang menunggu pembayaran yang bisa dibatalkan.');
        $order->update(['status' => 'dibatalkan']);
        return back()->with('success', 'Pesanan dibatalkan.');
    }

    public function received(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        abort_unless($order->status === 'dikirim', 422, 'Pesanan belum dikirim.');
        $order->update(['status' => 'selesai']);
        return back()->with('success', 'Pesanan telah dikonfirmasi diterima. Terima kasih!');
    }
}