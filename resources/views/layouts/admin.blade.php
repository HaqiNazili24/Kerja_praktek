@extends('layouts.base')
@section('body')
<div class="d-flex">
    <aside class="sidebar-admin p-3" style="width:240px; flex-shrink:0;">
        <h5 class="text-white mb-4"><i class="bi bi-shop-window"></i> {{ config('app.store.name') }}</h5>
        @php $r = request()->route()->getName(); @endphp
        <nav class="d-flex flex-column gap-1">
            <a href="{{ route('admin.dashboard') }}" class="{{ $r==='admin.dashboard'?'active':'' }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="{{ route('admin.categories.index') }}" class="{{ str_starts_with($r,'admin.categories')?'active':'' }}"><i class="bi bi-tags"></i> Kategori</a>
            <a href="{{ route('admin.sub-categories.index') }}" class="{{ str_starts_with($r,'admin.sub-categories')?'active':'' }}"><i class="bi bi-tag"></i> Sub Kategori</a>
            <a href="{{ route('admin.products.index') }}" class="{{ str_starts_with($r,'admin.products')?'active':'' }}"><i class="bi bi-box-seam"></i> Produk</a>
            <a href="{{ route('admin.orders.index') }}" class="{{ str_starts_with($r,'admin.orders')?'active':'' }}"><i class="bi bi-receipt"></i> Pesanan</a>
            <a href="{{ route('admin.reports.index') }}" class="{{ str_starts_with($r,'admin.reports')?'active':'' }}"><i class="bi bi-bar-chart"></i> Laporan</a>
            <hr class="border-light opacity-25">
            <a href="{{ route('home') }}"><i class="bi bi-house"></i> Lihat Toko</a>
            <form action="{{ route('logout') }}" method="POST">@csrf
                <button class="btn btn-link text-decoration-none text-start w-100" style="color:#e8e2d0;"><i class="bi bi-box-arrow-right"></i> Logout</button>
            </form>
        </nav>
    </aside>
    <div class="flex-grow-1">
        <header class="bg-white shadow-sm px-4 py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">@yield('page-title','Admin')</h5>
            <span class="text-muted small"><i class="bi bi-person-circle"></i> {{ auth()->user()->full_name }}</span>
        </header>
        <main class="p-4">
            @include('partials.alerts')
            @yield('content')
        </main>
    </div>
</div>
@endsection
