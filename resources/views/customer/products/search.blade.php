@extends('layouts.customer')
@section('title','Pencarian')
@section('content')
<h4>Hasil Pencarian: <span class="text-tb-green">"{{ $keyword }}"</span></h4>
@if($products->isEmpty())
    <div class="alert alert-warning mt-3">Tidak ada produk yang cocok.</div>
@else
    <div class="row g-3 mt-2">
        @foreach($products as $p)
            <div class="col-6 col-md-3">
                <a href="{{ route('products.show',$p->slug) }}" class="text-decoration-none text-dark">
                    <div class="card-product card h-100">
                        <img src="{{ $p->primary_image_url }}" class="product-thumb">
                        <div class="p-3"><h6>{{ $p->name }}</h6><div class="price">{{ $p->formatted_price }}</div></div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    <div class="mt-4">{{ $products->links() }}</div>
@endif
@endsection
