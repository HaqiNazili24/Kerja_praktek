@extends('layouts.admin')
@section('page-title','Pesanan')
@section('content')

{{-- Filter Bar --}}
<div class="card mb-4">
    <div class="card-body py-3">
        <form class="row g-2 align-items-end" method="GET">
            <div class="col-md-4">
                <label class="form-label fw-semibold small mb-1">Cari Pesanan</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted" style="font-size:13px;"></i>
                    </span>
                    <input name="search" value="{{ request('search') }}"
                           class="form-control border-start-0 ps-0"
                           placeholder="No. pesanan atau nama customer">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold small mb-1">Status</label>
                <select name="status" class="form-select">
                    <option value="">— Semua Status —</option>
                    @foreach($statuses as $k => $v)
                        <option value="{{ $k }}" @selected(request('status') === $k)>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-tb-primary w-100">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
            </div>
            @if(request()->hasAny(['search','status']))
            <div class="col-md-2">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-tb-outline w-100">Reset</a>
            </div>
            @endif
        </form>
    </div>
</div>

{{-- Orders Table --}}
<div class="card">
    <div class="card-body pb-0">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h6 class="fw-bold mb-0">Daftar Pesanan</h6>
            <small class="text-muted">{{ $orders->total() ?? '' }} total pesanan</small>
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
                @forelse($orders as $o)
                <tr>
                    <td><span class="fw-semibold text-tb-green">{{ $o->order_number }}</span></td>
                    <td>
                        <span class="fw-semibold d-block">{{ $o->user->full_name }}</span>
                        <small class="text-muted">
                            {{ $o->payment_method === 'cod' ? 'COD' : 'Transfer Bank' }}
                        </small>
                    </td>
                    <td class="fw-semibold">Rp {{ number_format($o->total,0,',','.') }}</td>
                    <td><span class="admin-badge bg-{{ $o->status_color }}">{{ $o->status_label }}</span></td>
                    <td class="text-muted small">{{ $o->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show',$o) }}" class="btn btn-sm btn-tb-outline">
                            Detail <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="bi bi-receipt fs-2 d-block mb-2 opacity-25"></i>
                        Tidak ada pesanan ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
    <div class="card-body pt-2">{{ $orders->links() }}</div>
    @endif
</div>

@endsection
