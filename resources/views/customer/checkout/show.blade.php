@extends('layouts.customer')
@section('title','Checkout')
@section('content')
<h3 class="text-tb-green mb-3"><i class="bi bi-bag-check"></i> Checkout</h3>
<form action="{{ route('checkout.place') }}" method="POST">@csrf
<div class="row g-3">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm mb-3"><div class="card-body">
            <h6>Alamat Pengiriman</h6>
            @if($addresses->isNotEmpty())
                @foreach($addresses as $a)
                    <div class="form-check border rounded p-2 mb-2">
                        <input class="form-check-input" type="radio" name="address_id" value="{{ $a->id }}" id="a{{$a->id}}" @checked($loop->first)>
                        <label class="form-check-label" for="a{{$a->id}}">
                            <strong>{{ $a->label }} — {{ $a->recipient_name }}</strong> ({{ $a->phone }})<br>
                            <small>{{ $a->full_address }}, {{ $a->city }}, {{ $a->province }} {{ $a->postal_code }}</small>
                        </label>
                    </div>
                @endforeach
                <hr><p class="small text-muted">Atau isi alamat baru di bawah:</p>
            @endif
            <div class="row g-2">
                <div class="col-md-6"><input name="recipient_name" class="form-control" placeholder="Nama Penerima"></div>
                <div class="col-md-6"><input name="phone" class="form-control" placeholder="No. HP"></div>
                <div class="col-12"><textarea name="full_address" class="form-control" placeholder="Alamat lengkap" rows="2"></textarea></div>
                <div class="col-md-4"><input name="city" class="form-control" placeholder="Kota"></div>
                <div class="col-md-4"><input name="province" class="form-control" placeholder="Provinsi"></div>
                <div class="col-md-4"><input name="postal_code" class="form-control" placeholder="Kode Pos"></div>
                <div class="col-12"><div class="form-check"><input type="checkbox" name="save_address" value="1" class="form-check-input" id="sa">
                    <label class="form-check-label" for="sa">Simpan alamat ini</label></div></div>
            </div>
        </div></div>

        <div class="card border-0 shadow-sm"><div class="card-body">
            <h6>Metode Pembayaran</h6>
            <div class="alert alert-light border mt-2 mb-0">
                <strong>Transfer Bank</strong><br>
                Bank: <strong>{{ config('app.store.bank_name') }}</strong><br>
                No. Rekening: <strong>{{ config('app.store.bank_account') }}</strong><br>
                Atas Nama: <strong>{{ config('app.store.bank_holder') }}</strong><br>
                <small class="text-muted">Setelah pesanan dibuat, upload bukti transfer di halaman detail pesanan.</small>
            </div>
        </div></div>
    </div>

    <div class="col-md-5">
        <div class="card border-0 shadow-sm sticky-top" style="top:80px"><div class="card-body">
            <h6>Ringkasan</h6>
            @foreach($items as $i)
                <div class="d-flex justify-content-between small mb-1"><span>{{ $i->product->name }} × {{ $i->quantity }}</span><span>Rp {{ number_format($i->subtotal,0,',','.') }}</span></div>
            @endforeach
            <hr>
            <div class="d-flex justify-content-between"><span>Subtotal</span><span>Rp {{ number_format($subtotal,0,',','.') }}</span></div>
            <div class="d-flex justify-content-between"><span>Ongkir</span><span>Rp {{ number_format($shipping,0,',','.') }}</span></div>
            <hr>
            <div class="d-flex justify-content-between fs-5 text-tb-green"><strong>Total</strong><strong>Rp {{ number_format($total,0,',','.') }}</strong></div>
            <button class="btn btn-tb-primary w-100 mt-3">Buat Pesanan</button>
        </div></div>
    </div>
</div>
</form>
@endsection
