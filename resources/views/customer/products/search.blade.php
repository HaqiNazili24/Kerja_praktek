@extends('layouts.customer')
@section('title','Pencarian')
@section('content')
<h4 class="mb-4">Hasil Pencarian: <span class="text-success">"{{ $keyword }}"</span></h4>

@if($products->isEmpty())
    <div class="card border-0 shadow-sm rounded-4 text-center py-5">
        <div class="card-body">
            <i class="bi bi-search display-1 text-muted mb-3 d-block"></i>
            <h5 class="text-muted">Tidak ada produk yang cocok dengan pencarian Anda.</h5>
            <a href="{{ route('home') }}" class="btn btn-tb-primary mt-3">Kembali Belanja</a>
        </div>
    </div>
@else
    <div class="row g-2 g-md-3 mt-2">
        @foreach($products as $p)
            <div class="col-4 col-md-4 col-lg-3">
                <a href="{{ route('products.show', $p->slug) }}" class="text-decoration-none">
                    <div class="card-product card h-100 border-0 shadow-sm rounded-4">
                        <div class="product-img-wrap">
                            <img src="{{ $p->primary_image_url }}"
                                 class="product-thumb"
                                 alt="{{ $p->name }}"
                                 onerror="this.src='https://placehold.co/400x400/e8f5e9/2D5016?text=Beras'">
                        </div>
                        <div class="product-card-body">
                            <span class="badge bg-success-subtle text-success mb-1 align-self-start" style="font-size: 0.65rem; padding: 0.25em 0.5em;">{{ $p->weight_label }}</span>
                            <h6 class="fw-bold text-dark product-title">{{ $p->name }}</h6>
                            <div class="product-price">Rp {{ number_format($p->price,0,',','.') }}</div>
                            <div class="d-none d-md-flex align-items-center justify-content-between mt-auto pt-2">
                                <small class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-box-seam"></i> Stok: {{ $p->stock }}</small>
                                @if($p->stock > 0)
                                    <span class="badge bg-success-subtle text-success" style="font-size:.65rem">Tersedia</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger" style="font-size:.65rem">Habis</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    <div class="mt-4 d-flex justify-content-center">{{ $products->links() }}</div>
@endif
@endsection
