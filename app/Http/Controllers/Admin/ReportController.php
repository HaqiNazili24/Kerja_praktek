<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        [$orders, $filters] = $this->buildQuery($request);
        $totalOrders = $orders->count();
        $totalRevenue = $orders->whereIn('status', ['pembayaran_dikonfirmasi', 'diproses', 'dikirim', 'selesai'])->sum('total');
        $categories = Category::orderBy('name')->get();
        $statuses = Order::STATUSES;
        return view('admin.reports.index', compact('orders', 'totalOrders', 'totalRevenue', 'categories', 'statuses', 'filters'));
    }

    public function pdf(Request $request)
    {
        [$orders, $filters] = $this->buildQuery($request);
        $totalOrders = $orders->count();
        $totalRevenue = $orders->whereIn('status', ['pembayaran_dikonfirmasi', 'diproses', 'dikirim', 'selesai'])->sum('total');
        $pdf = Pdf::loadView('admin.reports.pdf', [
            'orders' => $orders, 'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue, 'filters' => $filters,
            'storeName' => config('app.store.name'),
        ]);
        return $pdf->download('laporan-penjualan-'.date('Ymd-His').'.pdf');
    }

    private function buildQuery(Request $request): array
    {
        $q = Order::with('user', 'items.product.subCategory.category');
        if ($request->filled('date_from')) $q->whereDate('created_at', '>=', $request->date_from);
        if ($request->filled('date_to')) $q->whereDate('created_at', '<=', $request->date_to);
        if ($request->filled('status')) $q->where('status', $request->status);
        if ($request->filled('category_id')) {
            $q->whereHas('items.product.subCategory', fn($x) => $x->where('category_id', $request->category_id));
        }
        return [$q->latest()->get(), $request->only(['date_from', 'date_to', 'status', 'category_id'])];
    }
}
