@extends('layouts.customer')
@section('title','Pesanan Saya')
@section('content')
<h3 class="fw-bold mb-4 text-success"><i class="bi bi-bag-check"></i> Pesanan Saya</h3>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead class="table-light border-0">
                    <tr>
                        <th class="py-3 px-4" style="color: var(--color-text-secondary); font-weight: 600;">No. Pesanan</th>
                        <th class="py-3" style="color: var(--color-text-secondary); font-weight: 600;">Tanggal</th>
                        <th class="py-3" style="color: var(--color-text-secondary); font-weight: 600;">Total</th>
                        <th class="py-3" style="color: var(--color-text-secondary); font-weight: 600;">Status</th>
                        <th class="py-3 px-4 text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $o)
                    <tr class="border-bottom" style="border-color: #f1eeeb !important;">
                        <td class="py-3 px-4"><strong class="text-dark">{{ $o->order_number }}</strong></td>
                        <td class="py-3 text-muted small">{{ $o->created_at->format('d M Y H:i') }}</td>
                        <td class="py-3 text-dark fw-semibold">Rp {{ number_format($o->total,0,',','.') }}</td>
                        <td class="py-3"><span class="badge bg-{{ $o->status_color }} status-badge">{{ $o->status_label }}</span></td>
                        <td class="py-3 px-4 text-end"><a href="{{ route('orders.show',$o) }}" class="btn btn-sm btn-tb-outline py-1 px-3">Detail</a></td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-receipt display-1 d-block mb-3 text-muted" style="opacity: 0.5;"></i>
                                Belum ada riwayat pesanan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-4 d-flex justify-content-center">{{ $orders->links() }}</div>
@endsection
