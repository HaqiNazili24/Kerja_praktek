@extends('layouts.admin')
@section('page-title','Pesanan')
@section('content')
<form class="row g-2 mb-3" method="GET">
    <div class="col-md-4"><input name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari no.pesanan / nama"></div>
    <div class="col-md-3"><select name="status" class="form-select">
        <option value="">— Semua Status —</option>
        @foreach($statuses as $k=>$v)<option value="{{ $k }}" @selected(request('status')===$k)>{{ $v }}</option>@endforeach
    </select></div>
    <div class="col-md-2"><button class="btn btn-tb-primary w-100">Filter</button></div>
</form>

<div class="card border-0 shadow-sm"><div class="card-body p-0">
<table class="table align-middle mb-0">
    <thead class="bg-light"><tr><th>No. Pesanan</th><th>Customer</th><th>Total</th><th>Status</th><th>Tgl</th><th></th></tr></thead>
    <tbody>
        @forelse($orders as $o)
            <tr>
                <td>{{ $o->order_number }}</td>
                <td>{{ $o->user->full_name }}</td>
                <td>Rp {{ number_format($o->total,0,',','.') }}</td>
                <td><span class="badge bg-{{ $o->status_color }}">{{ $o->status_label }}</span></td>
                <td>{{ $o->created_at->format('d/m/Y H:i') }}</td>
                <td><a href="{{ route('admin.orders.show',$o) }}" class="btn btn-sm btn-tb-outline">Detail</a></td>
            </tr>
        @empty <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada pesanan.</td></tr> @endforelse
    </tbody>
</table></div></div>
<div class="mt-3">{{ $orders->links() }}</div>
@endsection
