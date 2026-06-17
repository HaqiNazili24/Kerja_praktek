@extends('layouts.customer')
@section('title','Beranda')
@section('content')

{{-- HERO SECTION --}}
<div class="hero-section rounded-4 mb-5 overflow-hidden shadow-sm bg-white">
    <div class="row g-0 align-items-center">
        <div class="col-lg-5 p-4 p-md-5">
            <span class="badge bg-success-subtle text-success fw-semibold mb-3 px-3 py-2" style="border-radius: 50px; font-size: 0.8rem;">
                🌾 Langsung dari Petani Terbaik
            </span>
            <h1 class="fw-bold display-6 mb-3 text-tb-green" style="font-size: 2.2rem; line-height: 1.2;">
                Beras Berkualitas<br>untuk Keluarga Indonesia
            </h1>
            <p class="mb-4 text-muted fs-6" style="line-height: 1.6;">
                Nikmati beras Premium dan Medium pilihan terbaik, dikemas higienis mulai dari 5kg hingga 25kg dengan layanan pengiriman cepat langsung ke rumah Anda.
            </p>
            <a href="#produk" class="btn btn-tb-primary btn-lg px-4 shadow-sm">
                Lihat Produk
            </a>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div style="background: url('https://images.unsplash.com/photo-1586201375761-83865001e31c?w=1400&q=80') center/cover no-repeat; min-height: 400px; height: 100%;">
            </div>
        </div>
        <div class="col-12 d-lg-none">
            <div style="background: url('https://images.unsplash.com/photo-1586201375761-83865001e31c?w=1400&q=80') center/cover no-repeat; aspect-ratio: 21/9; width: 100%;">
            </div>
        </div>
    </div>
</div>

{{-- PRODUK SECTION --}}
<div id="produk" class="row g-4">

    {{-- SIDEBAR FILTER --}}
    <aside class="col-lg-3 d-none d-lg-block">
        <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top:100px">
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
        
        {{-- Mobile Filter & Categories (d-lg-none) --}}
        <div class="d-lg-none mb-4">
            <form method="GET" id="mobileSortForm" class="d-flex gap-2 align-items-center justify-content-between mb-3 bg-white p-3 rounded-4 shadow-sm border-0">
                @foreach(request()->except('sort') as $k=>$v)
                    <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                @endforeach
                <span class="text-muted small fw-semibold"><i class="bi bi-sliders text-success me-1"></i> Urutkan Beras:</span>
                <select name="sort" class="form-select form-select-sm" style="width: auto; border-radius: 8px;" onchange="this.form.submit()">
                    <option value="">Terbaru</option>
                    <option value="price_asc" @selected(request('sort')==='price_asc')>Harga Terendah</option>
                    <option value="price_desc" @selected(request('sort')==='price_desc')>Harga Tertinggi</option>
                </select>
            </form>
            
            <div class="d-flex gap-2 overflow-x-auto pb-2" style="scrollbar-width: none; -ms-overflow-style: none;">
                <style>
                    .overflow-x-auto::-webkit-scrollbar { display: none; }
                </style>
                <a href="{{ route('home') }}" class="btn btn-sm px-3 py-2 {{ !request('category') && !request('sub_category') ? 'btn-tb-primary text-white' : 'btn-light text-dark' }}" style="font-size: 13px; border-radius: 50px; white-space: nowrap;">
                    Semua
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('home', ['category'=>$cat->slug]) }}" class="btn btn-sm px-3 py-2 {{ request('category')===$cat->slug ? 'btn-tb-primary text-white' : 'btn-light text-dark' }}" style="font-size: 13px; border-radius: 50px; white-space: nowrap;">
                        {{ $cat->name }}
                    </a>
                    @foreach($cat->subCategories as $sc)
                        <a href="{{ route('home', ['sub_category'=>$sc->slug]) }}" class="btn btn-sm px-3 py-2 {{ request('sub_category')===$sc->slug ? 'btn-tb-primary text-white' : 'btn-light text-dark' }}" style="font-size: 13px; border-radius: 50px; white-space: nowrap;">
                            {{ $sc->name }}
                        </a>
                    @endforeach
                @endforeach
            </div>
        </div>

        @if($products->isEmpty())
            <div class="text-center py-5 bg-white rounded-4 shadow-sm">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <p class="mt-3 text-muted">Belum ada produk ditemukan.</p>
            </div>
        @else
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted small">Menampilkan <strong>{{ $products->total() }}</strong> produk</span>
            </div>
            <div class="row g-2 g-md-3">
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
    </div>
</div>

@push('scripts')
<script>
    function loadProducts(url, shouldPush = true) {
        const produkDiv = document.getElementById('produk');
        if (!produkDiv) return;
        
        // Tampilkan transisi loading
        produkDiv.style.opacity = '0.4';
        produkDiv.style.transition = 'opacity 0.15s ease';
        
        fetch(url)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newProduk = doc.getElementById('produk');
                
                if (newProduk) {
                    // Update konten produk & filter
                    produkDiv.innerHTML = newProduk.innerHTML;
                    produkDiv.style.opacity = '1';
                    
                    // Update URL browser tanpa refresh
                    if (shouldPush) {
                        history.pushState(null, '', url);
                    }
                    
                    // Inisialisasi ulang event listener
                    initAjaxFilters();
                }
            })
            .catch(err => {
                console.error('AJAX load error:', err);
                produkDiv.style.opacity = '1';
            });
    }

    function initAjaxFilters() {
        // 1. Intercept link filter kategori (Desktop & Mobile)
        const filterLinks = document.querySelectorAll('.filter-link, .d-lg-none .overflow-x-auto a');
        filterLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                loadProducts(this.href);
            });
        });

        // 2. Intercept link paginasi halaman
        const paginationLinks = document.querySelectorAll('.pagination a');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                loadProducts(this.href);
                // Scroll halus kembali ke atas produk
                document.getElementById('produk').scrollIntoView({ behavior: 'smooth' });
            });
        });
        
        // 3. Intercept form pengurutan (Sort select)
        const sortSelects = document.querySelectorAll('select[name="sort"]');
        sortSelects.forEach(select => {
            const form = select.closest('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(form);
                    const params = new URLSearchParams(formData);
                    const actionUrl = form.action || window.location.pathname;
                    const targetUrl = actionUrl + '?' + params.toString();
                    loadProducts(targetUrl);
                });
                
                // Override onchange default form submit
                select.onchange = function(e) {
                    form.dispatchEvent(new Event('submit'));
                };
            }
        });
    }

    // Tangani tombol Back / Forward browser
    window.addEventListener('popstate', function() {
        loadProducts(window.location.href, false);
    });

    document.addEventListener('DOMContentLoaded', function() {
        initAjaxFilters();
    });
</script>
@endpush
@endsection