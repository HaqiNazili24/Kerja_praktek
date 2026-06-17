@extends('layouts.base')
@section('body')
<div id="adminApp" class="d-flex flex-column flex-lg-row min-vh-100">

    {{-- ===== SIDEBAR ===== --}}
    <div class="offcanvas-lg offcanvas-start sidebar-admin p-0 flex-shrink-0" tabindex="-1" id="adminSidebar" style="width: 260px;" aria-labelledby="adminSidebarLabel">

        {{-- Brand / Logo --}}
        <div class="sidebar-brand px-4 py-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <div class="sidebar-brand-icon">
                    <i class="bi bi-shop-window"></i>
                </div>
                <div>
                    <div class="sidebar-brand-name" id="adminSidebarLabel">Admin Panel</div>
                    <div class="sidebar-brand-sub">{{ config('app.store.name') }}</div>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white d-lg-none" data-bs-dismiss="offcanvas" data-bs-target="#adminSidebar" aria-label="Close"></button>
            {{-- Desktop collapse toggle --}}
            <button type="button" class="admin-sidebar-toggle d-none d-lg-flex" onclick="adminToggle()" id="adminToggleBtn" aria-label="Toggle sidebar">
                <i class="bi bi-chevron-left"></i>
            </button>
        </div>

        {{-- Navigation --}}
        @php $r = request()->route()->getName(); @endphp
        <nav class="sidebar-nav px-3 pb-3 flex-grow-1">
            <div class="sidebar-section-label">MENU UTAMA</div>

            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ $r==='admin.dashboard' ? 'active' : '' }}" data-tooltip="Dashboard">
                <span class="sidebar-link-icon"><i class="bi bi-speedometer2"></i></span>
                <span class="sidebar-link-text">Dashboard</span>
            </a>

            <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ str_starts_with($r,'admin.categories') ? 'active' : '' }}" data-tooltip="Kategori">
                <span class="sidebar-link-icon"><i class="bi bi-tags"></i></span>
                <span class="sidebar-link-text">Kategori</span>
            </a>

            <a href="{{ route('admin.sub-categories.index') }}" class="sidebar-link {{ str_starts_with($r,'admin.sub-categories') ? 'active' : '' }}" data-tooltip="Sub Kategori">
                <span class="sidebar-link-icon"><i class="bi bi-tag"></i></span>
                <span class="sidebar-link-text">Sub Kategori</span>
            </a>

            <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ str_starts_with($r,'admin.products') ? 'active' : '' }}" data-tooltip="Produk">
                <span class="sidebar-link-icon"><i class="bi bi-box-seam"></i></span>
                <span class="sidebar-link-text">Produk</span>
            </a>

            <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ str_starts_with($r,'admin.orders') ? 'active' : '' }}" data-tooltip="Pesanan">
                <span class="sidebar-link-icon"><i class="bi bi-receipt"></i></span>
                <span class="sidebar-link-text">Pesanan</span>
            </a>

            <a href="{{ route('admin.reports.index') }}" class="sidebar-link {{ str_starts_with($r,'admin.reports') ? 'active' : '' }}" data-tooltip="Laporan">
                <span class="sidebar-link-icon"><i class="bi bi-bar-chart-line"></i></span>
                <span class="sidebar-link-text">Laporan</span>
            </a>

            <div class="sidebar-divider my-3"></div>
            <div class="sidebar-section-label">LAINNYA</div>

            <a href="{{ route('home') }}" class="sidebar-link" target="_blank" data-tooltip="Lihat Toko">
                <span class="sidebar-link-icon"><i class="bi bi-house"></i></span>
                <span class="sidebar-link-text">Lihat Toko</span>
                <i class="bi bi-box-arrow-up-right ms-auto opacity-50 sidebar-link-text" style="font-size:11px;"></i>
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-link w-100 border-0 bg-transparent text-start" data-tooltip="Logout">
                    <span class="sidebar-link-icon"><i class="bi bi-box-arrow-right"></i></span>
                    <span class="sidebar-link-text">Logout</span>
                </button>
            </form>
        </nav>

        {{-- Admin user footer --}}
        <div class="sidebar-footer px-4 py-3">
            <div class="d-flex align-items-center gap-2">
                <div class="sidebar-avatar">{{ strtoupper(substr(auth()->user()->full_name, 0, 1)) }}</div>
                <div>
                    <div class="sidebar-user-name">{{ auth()->user()->full_name }}</div>
                    <div class="sidebar-user-role">Administrator</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="flex-grow-1 w-100 admin-main" style="min-width: 0; background: #F5F3EE;">

        {{-- Topbar --}}
        <header class="admin-topbar px-4 py-0 d-flex justify-content-between align-items-center sticky-top">
            <div class="d-flex align-items-center gap-3">
                <button class="btn admin-topbar-toggle d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebar" aria-controls="adminSidebar">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <button class="btn admin-topbar-toggle d-none d-lg-flex" type="button" onclick="adminToggle()" aria-label="Toggle sidebar">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <div>
                    <h5 class="mb-0 text-tb-green fw-bold">@yield('page-title', 'Admin')</h5>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="admin-topbar-date d-none d-md-block">
                    <i class="bi bi-calendar3 me-1"></i>
                    {{ now()->translatedFormat('l, d F Y') }}
                </span>
                <div class="admin-topbar-user d-flex align-items-center gap-2">
                    <div class="topbar-avatar">{{ strtoupper(substr(auth()->user()->full_name, 0, 1)) }}</div>
                    <span class="d-none d-md-block">{{ auth()->user()->full_name }}</span>
                </div>
            </div>
        </header>

        <main class="admin-content p-3 p-lg-4">
            @include('partials.alerts')
            @yield('content')
        </main>
    </div>
</div>

@push('scripts')
<script>
    function adminToggle() {
        var app = document.getElementById('adminApp');
        var icon = document.querySelector('#adminToggleBtn i');
        if (!app) return;

        app.classList.toggle('admin-sidebar-collapsed');

        if (icon) {
            icon.className = app.classList.contains('admin-sidebar-collapsed')
                ? 'bi bi-chevron-right'
                : 'bi bi-chevron-left';
        }

        localStorage.setItem('adminSidebarCollapsed', app.classList.contains('admin-sidebar-collapsed'));
    }

    document.addEventListener('DOMContentLoaded', function() {
        var app = document.getElementById('adminApp');
        var icon = document.querySelector('#adminToggleBtn i');
        if (!app) return;

        // Restore saved state on desktop
        if (window.innerWidth >= 992 && localStorage.getItem('adminSidebarCollapsed') === 'true') {
            app.classList.add('admin-sidebar-collapsed');
            if (icon) icon.className = 'bi bi-chevron-right';
        }
    });
</script>
@endpush
@endsection
