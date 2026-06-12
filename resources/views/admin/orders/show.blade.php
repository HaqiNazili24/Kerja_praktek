@extends('layouts.admin')
@section('page-title','Detail Pesanan')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <div><h4 class="mb-0 text-tb-green">{{ $order->order_number }}</h4>
        <small>{{ $order->created_at->format('d M Y H:i') }}</small></div>
    <span class="badge bg-{{ $order->status_color }} fs-6 align-self-center">{{ $order->status_label }}</span>
</div>

<div class="row g-3">
<div class="col-md-7">
    <div class="card border-0 shadow-sm mb-3"><div class="card-body">
        <h6>Item</h6>
        <table class="table mb-0"><thead><tr><th>Produk</th><th>Qty</th><th>Harga</th><th>Subtotal</th></tr></thead><tbody>
            @foreach($order->items as $i)
                <tr><td>{{ $i->product_name_snapshot }}</td><td>{{ $i->quantity }}</td>
                <td>Rp {{ number_format($i->price_snapshot,0,',','.') }}</td><td>Rp {{ number_format($i->subtotal,0,',','.') }}</td></tr>
            @endforeach
        </tbody></table>
        <div class="text-end mt-2">
            Subtotal: Rp {{ number_format($order->subtotal,0,',','.') }}<br>
            Ongkir: Rp {{ number_format($order->shipping_cost,0,',','.') }}<br>
            <strong class="text-tb-green fs-5">Total: Rp {{ number_format($order->total,0,',','.') }}</strong>
        </div>
    </div></div>

    <div class="card border-0 shadow-sm"><div class="card-body">
        <h6>Customer & Pengiriman</h6>
        <p class="mb-1"><strong>{{ $order->user->full_name }}</strong> — {{ $order->user->email }}</p>
        <p class="mb-0">{{ $order->shipping_recipient }} ({{ $order->shipping_phone }})<br>
        {{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postal_code }}</p>
    </div></div>
</div>

<div class="col-md-5">
    <div class="card border-0 shadow-sm mb-3"><div class="card-body">
        <h6>Bukti Pembayaran</h6>
        @if($order->payment_proof_url)
            @if(str_ends_with($order->payment_proof_url, '.pdf'))
                <a href="{{ asset('storage/'.$order->payment_proof_url) }}" target="_blank" class="btn btn-sm btn-tb-outline">Buka PDF</a>
            @else
                <img src="{{ asset('storage/'.$order->payment_proof_url) }}" class="img-fluid rounded">
            @endif
        @else <p class="text-muted small">Belum ada bukti.</p> @endif

        @if($order->status === 'pembayaran_dikirim')
            <hr>
            <form action="{{ route('admin.orders.confirm-payment',$order) }}" method="POST" class="mb-2">@csrf
                <button class="btn btn-success w-100"><i class="bi bi-check-circle"></i> Konfirmasi Pembayaran</button>
            </form>
            <form action="{{ route('admin.orders.reject-payment',$order) }}" method="POST">@csrf
                <textarea name="rejection_reason" class="form-control mb-2" rows="2" placeholder="Alasan penolakan" required></textarea>
                <button class="btn btn-outline-danger w-100"><i class="bi bi-x-circle"></i> Tolak Pembayaran</button>
            </form>
        @endif
    </div></div>

    @if(in_array($order->status, ['pembayaran_dikonfirmasi','diproses','dikirim']))
    <div class="card border-0 shadow-sm"><div class="card-body">
        <h6>Update Status</h6>
        <form action="{{ route('admin.orders.update-status',$order) }}" method="POST">@csrf
            <select name="status" class="form-select mb-2">
                <option value="diproses" @selected($order->status==='pembayaran_dikonfirmasi')>Diproses</option>
                <option value="dikirim" @selected($order->status==='diproses')>Dikirim</option>
                <option value="selesai" @selected($order->status==='dikirim')>Selesai</option>
            </select>
            <input name="tracking_number" class="form-control mb-2" placeholder="No. Resi (opsional)" value="{{ $order->tracking_number }}">
            <button class="btn btn-tb-primary w-100">Update Status</button>
        </form>
    </div></div>
    @endif
</div>
</div>
@endsection
