@extends('layouts.admin')
@section('page-title','Dashboard')
@section('content')
<div class="row g-3 mb-4">
    @php $cards = [
        ['Total Produk', $totalProducts, 'box-seam', 'primary'],
        ['Total Pesanan', $totalOrders, 'receipt', 'info'],
        ['Pembayaran Pending', $pendingPayments, 'clock-history', 'warning'],
        ['Total Pendapatan', 'Rp '.number_format($totalRevenue,0,',','.'), 'cash-coin', 'success'],
    ]; @endphp
    @foreach($cards as [$l,$v,$ic,$c])
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100"><div class="card-body">
                <div class="d-flex justify-content-between"><div>
                    <small class="text-muted">{{ $l }}</small>
                    <h4 class="mt-1 text-tb-green">{{ $v }}</h4>
                </div><i class="bi bi-{{ $ic }} fs-1 text-{{ $c }} opacity-50"></i></div>
            </div></div>
        </div>
    @endforeach
</div>

<div class="card border-0 shadow-sm"><div class="card-body">
    <h6 class="mb-3">10 Pesanan Terbaru</h6>
    <div class="table-responsive"><table class="table align-middle">
        <thead class="bg-light"><tr><th>No. Pesanan</th><th>Customer</th><th>Total</th><th>Status</th><th>Tgl</th><th></th></tr></thead>
        <tbody>
            @forelse($recentOrders as $o)
            <tr>
                <td>{{ $o->order_number }}</td>
                <td>{{ $o->user->full_name }}</td>
                <td>Rp {{ number_format($o->total,0,',','.') }}</td>
                <td><span class="badge bg-{{ $o->status_color }}">{{ $o->status_label }}</span></td>
                <td>{{ $o->created_at->format('d/m/Y') }}</td>
                <td><a href="{{ route('admin.orders.show',$o) }}" class="btn btn-sm btn-tb-outline">Detail</a></td>
            </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted">Belum ada pesanan.</td></tr>
            @endforelse
        </tbody>
    </table></div>
</div></div>
@endsection
