@extends('layouts.admin')
@section('page-title','Detail Pesanan')
@section('content')

{{-- Page Header --}}
<div class="d-flex align-items-start justify-content-between mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-tb-outline py-1 px-2">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h5 class="mb-0 fw-bold text-tb-green">{{ $order->order_number }}</h5>
        </div>
        <div class="d-flex align-items-center gap-2 ms-1">
            <small class="text-muted"><i class="bi bi-calendar3 me-1"></i>{{ $order->created_at->format('d M Y, H:i') }}</small>
            <span class="admin-badge bg-secondary">
                {{ $order->payment_method === 'cod' ? 'COD' : 'Transfer Bank' }}
            </span>
        </div>
    </div>
    <span class="admin-badge bg-{{ $order->status_color }}" style="font-size:13px; padding:8px 16px;">
        {{ $order->status_label }}
    </span>
</div>

<div class="row g-3">

    {{-- LEFT COLUMN --}}
    <div class="col-md-7">

        {{-- Order Items --}}
        <div class="card mb-3">
            <div class="card-body pb-0">
                <h6 class="fw-bold mb-0"><i class="bi bi-bag-check me-2 text-tb-green"></i>Item Pesanan</h6>
            </div>
            <div class="table-responsive mt-3">
                <table class="table admin-table mb-0">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $i)
                        <tr>
                            <td class="fw-semibold">{{ $i->product_name_snapshot }}</td>
                            <td class="text-center">{{ $i->quantity }}</td>
                            <td class="text-end text-muted">Rp {{ number_format($i->price_snapshot,0,',','.') }}</td>
                            <td class="text-end fw-semibold">Rp {{ number_format($i->subtotal,0,',','.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-body">
                <div class="admin-order-total-box">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Subtotal</span>
                        <span>Rp {{ number_format($order->subtotal,0,',','.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Ongkos Kirim</span>
                        <span>Rp {{ number_format($order->shipping_cost,0,',','.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between pt-2 border-top">
                        <span class="fw-bold">Total Pembayaran</span>
                        <span class="fw-bold text-tb-green fs-5">Rp {{ number_format($order->total,0,',','.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Customer & Shipping --}}
        <div class="card">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="bi bi-person-lines-fill me-2 text-tb-green"></i>Customer & Pengiriman</h6>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <p class="text-muted small mb-1 fw-semibold text-uppercase" style="font-size:11px; letter-spacing:.05em;">Pelanggan</p>
                        <p class="fw-semibold mb-0">{{ $order->user->full_name }}</p>
                        <p class="text-muted small mb-0">{{ $order->user->email }}</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="text-muted small mb-1 fw-semibold text-uppercase" style="font-size:11px; letter-spacing:.05em;">Penerima</p>
                        <p class="fw-semibold mb-0">{{ $order->shipping_recipient }}</p>
                        <p class="text-muted small mb-0">{{ $order->shipping_phone }}</p>
                    </div>
                    <div class="col-12">
                        <p class="text-muted small mb-1 fw-semibold text-uppercase" style="font-size:11px; letter-spacing:.05em;">Alamat Pengiriman</p>
                        <p class="mb-0">{{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postal_code }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT COLUMN --}}
    <div class="col-md-5">

        {{-- Payment Proof --}}
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="bi bi-credit-card me-2 text-tb-green"></i>Bukti Pembayaran</h6>

                @if($order->payment_method === 'cod')
                    <div class="admin-info-box">
                        <i class="bi bi-cash-coin fs-4 text-tb-green mb-2 d-block"></i>
                        <strong>Cash On Delivery (COD)</strong>
                        <p class="mb-0 small text-muted mt-1">Pembayaran dilakukan saat barang diterima oleh customer.</p>
                    </div>
                @elseif($order->payment_proof_url)
                    @if(str_ends_with($order->payment_proof_url, '.pdf'))
                        <div class="admin-info-box text-center">
                            <i class="bi bi-file-pdf fs-3 text-danger d-block mb-2"></i>
                            <a href="{{ asset('storage/'.$order->payment_proof_url) }}" target="_blank" class="btn btn-sm btn-tb-outline">
                                <i class="bi bi-box-arrow-up-right me-1"></i> Buka PDF
                            </a>
                        </div>
                    @else
                        <img src="{{ asset('storage/'.$order->payment_proof_url) }}"
                             class="img-fluid rounded-3 w-100"
                             style="max-height:280px; object-fit:contain; background:#f8f8f8;"
                             alt="Bukti Pembayaran">
                    @endif
                @else
                    <div class="admin-info-box text-center text-muted">
                        <i class="bi bi-image fs-3 d-block mb-2 opacity-25"></i>
                        <small>Belum ada bukti pembayaran diunggah.</small>
                    </div>
                @endif

                {{-- Payment Confirmation Actions --}}
                @if($order->status === 'pembayaran_dikirim')
                <hr class="my-3">
                <p class="fw-semibold small mb-2 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">Tindakan</p>
                <form action="{{ route('admin.orders.confirm-payment',$order) }}" method="POST" class="mb-2">
                    @csrf
                    <button class="btn btn-tb-primary w-100">
                        <i class="bi bi-check-circle me-2"></i>Konfirmasi Pembayaran
                    </button>
                </form>
                <form action="{{ route('admin.orders.reject-payment',$order) }}" method="POST">
                    @csrf
                    <textarea name="rejection_reason" class="form-control mb-2" rows="2" placeholder="Alasan penolakan (wajib diisi)" required></textarea>
                    <button class="btn btn-outline-danger w-100">
                        <i class="bi bi-x-circle me-2"></i>Tolak Pembayaran
                    </button>
                </form>
                @endif
            </div>
        </div>

        {{-- Status Update --}}
        @if(in_array($order->status, ['pembayaran_dikonfirmasi','diproses','dikirim']))
        <div class="card">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="bi bi-arrow-repeat me-2 text-tb-green"></i>Update Status Pesanan</h6>
                <form action="{{ route('admin.orders.update-status',$order) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Status Baru</label>
                        <select name="status" class="form-select">
                            <option value="diproses" @selected($order->status==='pembayaran_dikonfirmasi')>Diproses</option>
                            <option value="dikirim" @selected($order->status==='diproses')>Dikirim</option>
                            <option value="selesai" @selected($order->status==='dikirim')>Selesai</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">No. Resi <span class="text-muted fw-normal">(opsional)</span></label>
                        <input name="tracking_number" class="form-control" placeholder="Masukkan nomor resi" value="{{ $order->tracking_number }}">
                    </div>
                    <button class="btn btn-tb-primary w-100">
                        <i class="bi bi-send me-2"></i>Update Status
                    </button>
                </form>
            </div>
        </div>
        @endif

    </div>
</div>

@endsection
