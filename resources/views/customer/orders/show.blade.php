@extends('layouts.customer')
@section('title','Detail Pesanan '.$order->order_number)
@section('content')
@php
    $steps = ['menunggu_pembayaran','pembayaran_dikirim','pembayaran_dikonfirmasi','diproses','dikirim','selesai'];
    $currentIdx = array_search($order->status, $steps);
@endphp

<div class="d-flex justify-content-between flex-wrap gap-2 mb-3">
    <div><h4 class="mb-0 text-tb-green">{{ $order->order_number }}</h4>
        <small class="text-muted">{{ $order->created_at->format('d M Y H:i') }}</small></div>
    <span class="badge bg-{{ $order->status_color }} fs-6 align-self-center">{{ $order->status_label }}</span>
</div>

@if($order->status !== 'dibatalkan')
<div class="card border-0 shadow-sm mb-3"><div class="card-body">
    <div class="d-flex justify-content-between flex-wrap">
        @foreach($steps as $i=>$s)
            <div class="text-center flex-grow-1">
                <div class="rounded-circle d-inline-flex justify-content-center align-items-center mb-1"
                    style="width:36px;height:36px;background:{{ $i<=$currentIdx?'#2D5016':'#dee2e6' }};color:#fff;">
                    @if($i<$currentIdx)<i class="bi bi-check"></i>@else{{ $i+1 }}@endif
                </div>
                <small class="d-block">{{ \App\Models\Order::STATUSES[$s] }}</small>
            </div>
            @if(!$loop->last)<div class="flex-grow-1 align-self-center" style="height:2px;background:{{ $i<$currentIdx?'#2D5016':'#dee2e6' }};margin:0 -10px 18px;"></div>@endif
        @endforeach
    </div>
</div></div>
@endif

<div class="row g-3">
<div class="col-md-7">
    <div class="card border-0 shadow-sm mb-3"><div class="card-body">
        <h6>Item Pesanan</h6>
        @foreach($order->items as $it)
            <div class="d-flex justify-content-between border-bottom py-2">
                <div><strong>{{ $it->product_name_snapshot }}</strong><br><small>{{ $it->quantity }} × Rp {{ number_format($it->price_snapshot,0,',','.') }}</small></div>
                <strong>Rp {{ number_format($it->subtotal,0,',','.') }}</strong>
            </div>
        @endforeach
        <div class="d-flex justify-content-between mt-3"><span>Subtotal</span><span>Rp {{ number_format($order->subtotal,0,',','.') }}</span></div>
        <div class="d-flex justify-content-between"><span>Ongkir</span><span>Rp {{ number_format($order->shipping_cost,0,',','.') }}</span></div>
        <div class="d-flex justify-content-between fs-5 mt-2"><strong>Total</strong><strong class="text-tb-green">Rp {{ number_format($order->total,0,',','.') }}</strong></div>
    </div></div>

    <div class="card border-0 shadow-sm"><div class="card-body">
        <h6>Alamat Pengiriman</h6>
        <p class="mb-0">{{ $order->shipping_recipient }} ({{ $order->shipping_phone }})<br>
        {{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postal_code }}</p>
        @if($order->tracking_number)
            <hr><strong>No. Resi:</strong> {{ $order->tracking_number }}
        @endif
    </div></div>
</div>

<div class="col-md-5">
    <div class="card border-0 shadow-sm mb-3"><div class="card-body">
        <h6>Pembayaran</h6>
        <div class="small">
            Bank: <strong>{{ config('app.store.bank_name') }}</strong><br>
            No.Rek: <strong>{{ config('app.store.bank_account') }}</strong><br>
            Atas Nama: <strong>{{ config('app.store.bank_holder') }}</strong>
        </div>

        @if($order->rejection_reason && $order->status==='menunggu_pembayaran')
            <div class="alert alert-warning mt-3 small">Pembayaran sebelumnya ditolak: {{ $order->rejection_reason }}. Silakan upload ulang.</div>
        @endif

        @if($order->status==='menunggu_pembayaran')
            <form action="{{ route('orders.upload-proof',$order) }}" method="POST" enctype="multipart/form-data" class="mt-3">@csrf
                <label class="form-label">Upload Bukti Transfer (JPG/PNG/PDF, max 5MB)</label>
                <input type="file" name="payment_proof" class="form-control mb-2" accept=".jpg,.jpeg,.png,.pdf" required>
                <button class="btn btn-tb-primary w-100"><i class="bi bi-upload"></i> Upload</button>
            </form>
            <form action="{{ route('orders.cancel',$order) }}" method="POST" class="mt-2" onsubmit="return confirm('Batalkan pesanan ini?')">@csrf
                <button class="btn btn-outline-danger btn-sm w-100">Batalkan Pesanan</button>
            </form>

        @elseif($order->status==='dikirim')
            <div class="alert alert-info mt-3 small">
                <i class="bi bi-truck"></i> Pesanan sedang dalam pengiriman.
            </div>
            <form action="{{ route('orders.received', $order) }}" method="POST" class="mt-2"
                  onsubmit="return confirm('Konfirmasi pesanan sudah diterima?')">@csrf
                <button class="btn btn-success w-100">
                    <i class="bi bi-check-circle"></i> Pesanan Sudah Diterima
                </button>
            </form>

        @elseif($order->payment_proof_url)
            <hr><strong>Bukti Pembayaran:</strong><br>
            @if(str_ends_with($order->payment_proof_url, '.pdf'))
                <a href="{{ asset('storage/'.$order->payment_proof_url) }}" target="_blank" class="btn btn-sm btn-tb-outline mt-2">Lihat PDF</a>
            @else
                <img src="{{ asset('storage/'.$order->payment_proof_url) }}" class="img-fluid rounded mt-2">
            @endif
        @endif
    </div></div>
</div>
</div>
@endsection