@extends('layouts.customer')
@section('title','Keranjang')
@section('content')
<h3 class="fw-bold mb-4 text-success"><i class="bi bi-cart3"></i> Keranjang Belanja</h3>

@if($items->isEmpty())
    <div class="card border-0 shadow-sm rounded-4 text-center py-5 bg-white">
        <div class="card-body">
            <i class="bi bi-cart-x display-1 text-muted mb-3 d-block"></i>
            <h5 class="text-muted mb-3">Keranjang belanja Anda masih kosong.</h5>
            <a href="{{ route('home') }}" class="btn btn-tb-primary px-4 py-2">Belanja Sekarang</a>
        </div>
    </div>
@else
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light border-0">
                        <tr>
                            <th class="py-3 px-4" style="color: var(--color-text-secondary); font-weight: 600;">Produk</th>
                            <th class="py-3" style="color: var(--color-text-secondary); font-weight: 600;">Harga</th>
                            <th class="py-3" width="170" style="color: var(--color-text-secondary); font-weight: 600;">Jumlah</th>
                            <th class="py-3" style="color: var(--color-text-secondary); font-weight: 600;">Subtotal</th>
                            <th class="py-3 px-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $i)
                        <tr class="border-bottom" style="border-color: #f1eeeb !important;">
                            <td class="py-3 px-4">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $i->product->primary_image_url }}" width="64" height="64" class="rounded-3 shadow-sm border" style="object-fit:cover;" onerror="this.src='https://placehold.co/100x100/e8f5e9/2D5016?text=Beras'">
                                    <div>
                                        <strong class="text-dark d-block">{{ $i->product->name }}</strong>
                                        <span class="badge bg-light text-muted border mt-1" style="font-size: 0.75rem;">{{ $i->product->weight_label }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 text-dark">Rp {{ number_format($i->product->price,0,',','.') }}</td>
                            <td class="py-3">
                                <form action="{{ route('cart.update',$i) }}" method="POST" class="d-flex align-items-center qty-stepper-form">
                                    @csrf 
                                    @method('PATCH')
                                    <div class="input-group input-group-sm qty-stepper shadow-sm rounded-pill overflow-hidden border bg-white" style="max-width: 105px;">
                                        <button type="button" class="btn btn-light border-0 px-2 btn-minus" onclick="stepQty(this, -1)" style="font-weight: bold; width: 30px; height: 30px; line-height: 1;">−</button>
                                        <input type="number" name="quantity" value="{{ $i->quantity }}" min="1" max="{{ $i->product->stock }}" 
                                               class="form-control border-0 text-center qty-input p-0" 
                                               style="font-size: 13px; font-weight: 600; width: 35px; height: 30px; pointer-events: none; background: transparent; -moz-appearance: textfield;" readonly>
                                        <button type="button" class="btn btn-light border-0 px-2 btn-plus" onclick="stepQty(this, 1)" style="font-weight: bold; width: 30px; height: 30px; line-height: 1;">+</button>
                                    </div>
                                </form>
                            </td>
                            <td class="py-3"><strong class="text-success">Rp {{ number_format($i->subtotal,0,',','.') }}</strong></td>
                            <td class="py-3 px-4 text-end">
                                <form action="{{ route('cart.remove',$i) }}" method="POST" onsubmit="return confirm('Hapus item ini?')">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger p-0 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; border-radius: 50% !important;">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="row align-items-center justify-content-between g-3">
        <div class="col-md-6 text-center text-md-start">
            <a href="{{ route('home') }}" class="btn btn-tb-outline py-2"><i class="bi bi-arrow-left"></i> Lanjut Belanja</a>
        </div>
        <div class="col-md-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted fw-semibold">Total Belanja</span>
                    <span class="fs-4 fw-bold text-success">Rp {{ number_format($total,0,',','.') }}</span>
                </div>
                <hr class="my-3" style="border-color: #f1eeeb;">
                <a href="{{ route('checkout.show') }}" class="btn btn-tb-primary btn-lg w-100 py-2 fs-6">Lanjut ke Checkout <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
        </div>
@push('scripts')
<script>
    function stepQty(btn, amount) {
        const form = btn.closest('.qty-stepper-form');
        const input = form.querySelector('.qty-input');
        let val = parseInt(input.value) + amount;
        const min = parseInt(input.min) || 1;
        const max = parseInt(input.max) || 9999;
        
        if (val >= min && val <= max) {
            input.value = val;
            form.submit();
        }
    }
</script>
@endpush
@endif
@endsection
