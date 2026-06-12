@extends('layouts.customer')
@section('title',$product->name)
@section('content')
<nav class="mb-3 small"><a href="{{ route('home') }}" class="text-tb-green text-decoration-none">Beranda</a> / {{ $product->name }}</nav>

<div class="row g-4">
    <div class="col-md-6">
        <img src="{{ $product->primary_image_url }}"
             class="img-fluid rounded-4 shadow-sm w-100"
             style="aspect-ratio:1/1; object-fit:contain; background:#f8f8f8; padding:12px;"
             alt="{{ $product->name }}"
             onerror="this.src='https://placehold.co/400x400/e8f5e9/2D5016?text=Beras'">
    </div>
    <div class="col-md-6">
        <small class="text-muted">{{ $product->subCategory->category->name }} / {{ $product->subCategory->name }}</small>
        <h2 class="mt-2">{{ $product->name }}</h2>
        <div class="price fs-3 my-3">{{ $product->formatted_price }}</div>
        <p><strong>Kemasan:</strong> {{ $product->weight_label }}</p>
        <p><strong>Stok:</strong> {{ $product->stock > 0 ? $product->stock.' tersedia' : 'Habis' }}</p>
        <p class="text-muted">{{ $product->description }}</p>

        @auth
            @if($product->stock > 0 && auth()->user()->isCustomer())
                <form action="{{ route('cart.add', $product) }}" method="POST" class="d-flex gap-2 align-items-end mt-4">@csrf
                    <div><label class="form-label small">Jumlah</label>
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control" style="width:100px;"></div>
                    <button class="btn btn-tb-primary"><i class="bi bi-cart-plus"></i> Tambah ke Keranjang</button>
                </form>
            @else
                <button class="btn btn-secondary" disabled>Stok Habis</button>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn btn-tb-primary">Login untuk Membeli</a>
        @endauth
    </div>
</div>
@endsection