@extends('layouts.customer')
@section('title','Beranda')
@section('content')

{{-- HERO SECTION --}}
<div class="hero-section rounded-4 mb-5 position-relative overflow-hidden">
    <div class="hero-overlay"></div>
    <div class="hero-content text-center text-white py-5 px-3 position-relative">
        <span class="badge bg-white text-success fw-semibold mb-3 px-3 py-2" style="font-size:.85rem;">🌾 Langsung dari Petani Terbaik</span>
        <h1 class="fw-bold display-5 mb-3">Beras Berkualitas<br>untuk Keluarga Indonesia</h1>
        <p class="mb-4 opacity-90 fs-6">Premium · Medium · Kemasan 5kg sampai 25kg · Pengiriman Cepat</p>
        <a href="#produk" class="btn btn-light btn-lg px-4 fw-semibold text-success shadow">
            🛒 Lihat Produk
        </a>
    </div>
</div>

{{-- PRODUK SECTION --}}
<div id="produk" class="row g-4">

    {{-- SIDEBAR FILTER --}}
    <aside class="col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top:80px">
            <div class="card-body p-3">

                {{-- Sort --}}
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-sliders text-success"></i> Filter & Urutkan
                </h6>
                <form method="GET" id="sortForm">
                    @foreach(request()->except('sort') as $k=>$v)
                        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                    @endforeach
                    <label class="form-label small text-muted fw-semibold">Urutkan</label>
                    <select name="sort" class="form-select form-select-sm mb-3" onchange="this.form.submit()">
                        <option value="">Terbaru</option>
                        <option value="price_asc" @selected(request('sort')==='price_asc')>Harga Terendah</option>
                        <option value="price_desc" @selected(request('sort')==='price_desc')>Harga Tertinggi</option>
                    </select>
                </form>

                <hr class="my-2">

                {{-- Kategori --}}
                <label class="form-label small text-muted fw-semibold">Kategori</label>
                <div class="d-flex flex-column gap-1">
                    <a href="{{ route('home') }}"
                       class="filter-link {{ !request('category') && !request('sub_category') ? 'active' : '' }}">
                        <i class="bi bi-grid-fill me-1"></i> Semua Produk
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('home', ['category'=>$cat->slug]) }}"
                           class="filter-link {{ request('category')===$cat->slug ? 'active' : '' }}">
                            <i class="bi bi-tag me-1"></i> {{ $cat->name }}
                        </a>
                        @foreach($cat->subCategories as $sc)
                            <a href="{{ route('home', ['sub_category'=>$sc->slug]) }}"
                               class="filter-link filter-sub {{ request('sub_category')===$sc->slug ? 'active' : '' }}">
                                └ {{ $sc->name }}
                            </a>
                        @endforeach
                    @endforeach
                </div>

            </div>
        </div>
    </aside>

    {{-- PRODUCT GRID --}}
    <div class="col-lg-9">
        @if($products->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <p class="mt-3 text-muted">Belum ada produk ditemukan.</p>
            </div>
        @else
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted small">Menampilkan <strong>{{ $products->total() }}</strong> produk</span>
            </div>
            <div class="row g-3">
                @foreach($products as $p)
                    <div class="col-6 col-md-4">
                        <a href="{{ route('products.show', $p->slug) }}" class="text-decoration-none">
                            <div class="card-product card h-100 border-0 shadow-sm rounded-4">
                                <div class="product-img-wrap">
                                    <img src="{{ $p->primary_image_url }}"
                                         class="product-thumb"
                                         alt="{{ $p->name }}"
                                         onerror="this.src='https://placehold.co/400x400/e8f5e9/2D5016?text=Beras'">
                                </div>
                                <div class="p-3">
                                    <span class="badge bg-success-subtle text-success small mb-1">{{ $p->weight_label }}</span>
                                    <h6 class="fw-bold text-dark mt-1 mb-1" style="font-size:.95rem; line-height:1.3">{{ $p->name }}</h6>
                                    <div class="price fw-bold fs-6 mb-1">{{ $p->formatted_price }}</div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <small class="text-muted"><i class="bi bi-box-seam"></i> Stok: {{ $p->stock }}</small>
                                        @if($p->stock > 0)
                                            <span class="badge bg-success-subtle text-success" style="font-size:.7rem">Tersedia</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger" style="font-size:.7rem">Habis</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">{{ $products->links() }}</div>
        @endif
    </div>
</div>

@push('head')
<style>
/* HERO */
.hero-section {
    background:
        linear-gradient(rgba(20, 50, 5, 0.72), rgba(20, 50, 5, 0.72)),
        url('https://images.unsplash.com/photo-1586201375761-83865001e31c?w=1400&q=80') center/cover no-repeat;
    min-height: 320px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.hero-content { max-width: 700px; margin: 0 auto; }
.opacity-90 { opacity: .9; }

/* FILTER LINKS */
.filter-link {
    display: block;
    padding: .4rem .75rem;
    border-radius: 8px;
    font-size: .875rem;
    text-decoration: none;
    color: #555;
    transition: all .15s;
}
.filter-link:hover { background: #f0faf0; color: #2D5016; }
.filter-link.active { background: #2D5016; color: #fff !important; font-weight: 600; }
.filter-sub { padding-left: 1.5rem; font-size: .82rem; color: #777; }
.filter-sub.active { background: #e8f5e0; color: #2D5016 !important; font-weight: 600; }

/* PRODUCT CARD */
.product-img-wrap {
    background: #f8f8f8;
    border-radius: 14px 14px 0 0;
    overflow: hidden;
}
.product-thumb {
    width: 100%;
    aspect-ratio: 1/1;
    object-fit: cover;
    transition: transform .2s;
}
.card-product:hover .product-thumb { transform: scale(1.05); }
</style>
@endpush
@endsection