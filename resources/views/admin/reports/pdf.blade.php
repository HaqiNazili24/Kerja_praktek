<!DOCTYPE html><html><head><meta charset="utf-8"><title>Laporan Penjualan</title>
<style>
body{font-family:DejaVu Sans,sans-serif;font-size:11px;color:#222;}
h2{color:#2D5016;margin-bottom:0;}
table{width:100%;border-collapse:collapse;margin-top:10px;}
th,td{border:1px solid #ccc;padding:5px;text-align:left;}
th{background:#2D5016;color:#fff;}
.summary{margin-top:10px;background:#F5F0E8;padding:8px;}
.right{text-align:right;}
</style></head><body>
<h2>{{ $storeName }} — Laporan Penjualan</h2>
<small>Periode: {{ $filters['date_from'] ?? '-' }} s/d {{ $filters['date_to'] ?? '-' }} | Dicetak: {{ now()->format('d M Y H:i') }}</small>
<table>
<thead><tr><th>No.Pesanan</th><th>Tanggal</th><th>Customer</th><th>Items</th><th>Qty</th><th class="right">Total</th><th>Status</th></tr></thead>
<tbody>
    @foreach($orders as $o)
        <tr>
            <td>{{ $o->order_number }}</td>
            <td>{{ $o->created_at->format('d/m/Y') }}</td>
            <td>{{ $o->user->full_name }}</td>
            <td>@foreach($o->items as $it){{ $it->product_name_snapshot }} ({{ $it->quantity }})@if(!$loop->last); @endif @endforeach</td>
            <td>{{ $o->items->sum('quantity') }}</td>
            <td class="right">Rp {{ number_format($o->total,0,',','.') }}</td>
            <td>{{ $o->status_label }}</td>
        </tr>
    @endforeach
</tbody></table>
<div class="summary">
    <strong>Total Pesanan:</strong> {{ $totalOrders }} &nbsp; | &nbsp;
    <strong>Total Pendapatan:</strong> Rp {{ number_format($totalRevenue,0,',','.') }}
</div>
</body></html>
