<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $pendingPayments = Order::whereIn('status', ['menunggu_pembayaran', 'pembayaran_dikirim'])->count();
        $totalRevenue = Order::where('status', 'selesai')->sum('total');
        $recentOrders = Order::with('user')->latest()->take(10)->get();

        return view('admin.dashboard', compact('totalProducts', 'totalOrders', 'pendingPayments', 'totalRevenue', 'recentOrders'));
    }
}
