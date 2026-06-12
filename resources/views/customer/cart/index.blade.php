@extends('layouts.customer')
@section('title','Keranjang')
@section('content')
<h3 class="text-tb-green mb-3"><i class="bi bi-cart3"></i> Keranjang Belanja</h3>
@if($items->isEmpty())
    <div class="alert alert-info">Keranjang masih kosong. <a href="{{ route('home') }}">Belanja sekarang</a>.</div>
@else
<div class="card border-0 shadow-sm"><div class="card-body p-0">
    <div class="table-responsive"><table class="table align-middle mb-0">
        <thead class="bg-light"><tr><th>Produk</th><th>Harga</th><th width="170">Jumlah</th><th>Subtotal</th><th></th></tr></thead>
        <tbody>
            @foreach($items as $i)
            <tr>
                <td><div class="d-flex align-items-center gap-3">
                    <img src="{{ $i->product->primary_image_url }}" width="60" height="60" class="rounded" style="object-fit:cover;">
                    <div><strong>{{ $i->product->name }}</strong><br><small class="text-muted">{{ $i->product->weight_label }}</small></div>
                </div></td>
                <td>Rp {{ number_format($i->product->price,0,',','.') }}</td>
                <td>
                    <form action="{{ route('cart.update',$i) }}" method="POST" class="d-flex gap-1">@csrf @method('PATCH')
                        <input type="number" name="quantity" value="{{ $i->quantity }}" min="1" max="{{ $i->product->stock }}" class="form-control form-control-sm" style="width:70px;">
                        <button class="btn btn-sm btn-tb-outline"><i class="bi bi-arrow-clockwise"></i></button>
                    </form>
                </td>
                <td><strong>Rp {{ number_format($i->subtotal,0,',','.') }}</strong></td>
                <td><form action="{{ route('cart.remove',$i) }}" method="POST" onsubmit="return confirm('Hapus item ini?')">@csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form></td>
            </tr>
            @endforeach
        </tbody>
        <tfoot class="bg-light"><tr><th colspan="3" class="text-end">Total</th><th colspan="2" class="text-tb-green fs-5">Rp {{ number_format($total,0,',','.') }}</th></tr></tfoot>
    </table></div>
</div></div>
<div class="text-end mt-3"><a href="{{ route('checkout.show') }}" class="btn btn-tb-primary btn-lg">Lanjut ke Checkout <i class="bi bi-arrow-right"></i></a></div>
@endif
@endsection
