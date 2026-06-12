@extends('layouts.customer')
@section('title','Pesanan Saya')
@section('content')
<h3 class="text-tb-green mb-3"><i class="bi bi-bag-check"></i> Pesanan Saya</h3>
<div class="card border-0 shadow-sm"><div class="card-body p-0">
<div class="table-responsive"><table class="table mb-0 align-middle">
    <thead class="bg-light"><tr><th>No. Pesanan</th><th>Tanggal</th><th>Total</th><th>Status</th><th></th></tr></thead>
    <tbody>
        @forelse($orders as $o)
        <tr>
            <td><strong>{{ $o->order_number }}</strong></td>
            <td>{{ $o->created_at->format('d M Y H:i') }}</td>
            <td>Rp {{ number_format($o->total,0,',','.') }}</td>
            <td><span class="badge bg-{{ $o->status_color }} status-badge">{{ $o->status_label }}</span></td>
            <td><a href="{{ route('orders.show',$o) }}" class="btn btn-sm btn-tb-outline">Detail</a></td>
        </tr>
        @empty
            <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada pesanan.</td></tr>
        @endforelse
    </tbody>
</table></div></div></div>
<div class="mt-3">{{ $orders->links() }}</div>
@endsection
