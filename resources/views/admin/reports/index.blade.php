@extends('layouts.admin')
@section('page-title','Laporan Penjualan')
@section('content')
<form class="card border-0 shadow-sm mb-3" method="GET"><div class="card-body row g-2 align-items-end">
    <div class="col-md-3"><label class="form-label">Dari Tanggal</label><input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}" class="form-control"></div>
    <div class="col-md-3"><label class="form-label">Sampai</label><input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}" class="form-control"></div>
    <div class="col-md-2"><label class="form-label">Status</label><select name="status" class="form-select">
        <option value="">Semua</option>
        @foreach($statuses as $k=>$v)<option value="{{ $k }}" @selected(($filters['status']??'')===$k)>{{ $v }}</option>@endforeach
    </select></div>
    <div class="col-md-2"><label class="form-label">Kategori</label><select name="category_id" class="form-select">
        <option value="">Semua</option>
        @foreach($categories as $c)<option value="{{ $c->id }}" @selected(($filters['category_id']??'')==$c->id)>{{ $c->name }}</option>@endforeach
    </select></div>
    <div class="col-md-2 d-flex gap-1"><button class="btn btn-tb-primary flex-grow-1">Filter</button>
        <a href="{{ route('admin.reports.pdf', $filters) }}" class="btn btn-outline-danger"><i class="bi bi-file-pdf"></i></a></div>
</div></form>

<div class="row g-3 mb-3">
    <div class="col-md-6"><div class="card border-0 shadow-sm"><div class="card-body">
        <small class="text-muted">Total Pesanan</small><h3 class="text-tb-green">{{ $totalOrders }}</h3></div></div></div>
    <div class="col-md-6"><div class="card border-0 shadow-sm"><div class="card-body">
        <small class="text-muted">Total Pendapatan</small><h3 class="text-tb-green">Rp {{ number_format($totalRevenue,0,',','.') }}</h3></div></div></div>
</div>

<div class="card border-0 shadow-sm"><div class="card-body p-0">
    <table class="table mb-0 align-middle"><thead class="bg-light">
        <tr><th>No. Pesanan</th><th>Tgl</th><th>Customer</th><th>Item</th><th>Qty</th><th>Total</th><th>Status</th></tr>
    </thead><tbody>
        @forelse($orders as $o)
            <tr>
                <td>{{ $o->order_number }}</td>
                <td>{{ $o->created_at->format('d/m/Y') }}</td>
                <td>{{ $o->user->full_name }}</td>
                <td><small>@foreach($o->items as $it){{ $it->product_name_snapshot }}@if(!$loop->last), @endif @endforeach</small></td>
                <td>{{ $o->items->sum('quantity') }}</td>
                <td>Rp {{ number_format($o->total,0,',','.') }}</td>
                <td><span class="badge bg-{{ $o->status_color }}">{{ $o->status_label }}</span></td>
            </tr>
        @empty <tr><td colspan="7" class="text-center text-muted py-3">Tidak ada data.</td></tr> @endforelse
    </tbody></table>
</div></div>
@endsection
