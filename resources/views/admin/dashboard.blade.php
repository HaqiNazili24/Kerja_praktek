@extends('layouts.admin')
@section('page-title','Dashboard')
@section('content')

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    @php
        $cards = [
            [
                'label'   => 'Total Produk',
                'value'   => $totalProducts,
                'icon'    => 'bi-box-seam',
                'color'   => '#2E7D32',
                'bg'      => 'rgba(46,125,50,0.08)',
                'suffix'  => 'item',
            ],
            [
                'label'   => 'Total Pesanan',
                'value'   => $totalOrders,
                'icon'    => 'bi-receipt',
                'color'   => '#1565C0',
                'bg'      => 'rgba(21,101,192,0.08)',
                'suffix'  => 'pesanan',
            ],
            [
                'label'   => 'Pembayaran Pending',
                'value'   => $pendingPayments,
                'icon'    => 'bi-clock-history',
                'color'   => '#E65100',
                'bg'      => 'rgba(230,81,0,0.08)',
                'suffix'  => 'menunggu',
            ],
            [
                'label'   => 'Total Pendapatan',
                'value'   => 'Rp '.number_format($totalRevenue,0,',','.'),
                'icon'    => 'bi-cash-coin',
                'color'   => '#2E7D32',
                'bg'      => 'rgba(46,125,50,0.08)',
                'suffix'  => null,
            ],
        ];
    @endphp

    @foreach($cards as $card)
    <div class="col-6 col-lg-3">
        <div class="card admin-stat-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <p class="admin-stat-label">{{ $card['label'] }}</p>
                        <h3 class="admin-stat-value">{{ $card['value'] }}</h3>
                        @if($card['suffix'])
                            <span class="admin-stat-suffix">{{ $card['suffix'] }}</span>
                        @endif
                    </div>
                    <div class="admin-stat-icon" style="background:{{ $card['bg'] }}; color:{{ $card['color'] }};">
                        <i class="bi {{ $card['icon'] }}"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Recent Orders --}}
<div class="card">
    <div class="card-body pb-0">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h6 class="mb-0 fw-bold">Pesanan Terbaru</h6>
                <small class="text-muted">{{ $recentOrders->count() }} pesanan terakhir masuk</small>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-tb-outline">
                Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table admin-table mb-0 align-middle">
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $o)
                <tr>
                    <td><span class="fw-semibold text-tb-green">{{ $o->order_number }}</span></td>
                    <td>{{ $o->user->full_name }}</td>
                    <td class="fw-semibold">Rp {{ number_format($o->total,0,',','.') }}</td>
                    <td><span class="admin-badge bg-{{ $o->status_color }}">{{ $o->status_label }}</span></td>
                    <td class="text-muted">{{ $o->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show',$o) }}" class="btn btn-sm btn-tb-outline">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="bi bi-inbox fs-2 d-block mb-2 opacity-25"></i>
                        Belum ada pesanan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
