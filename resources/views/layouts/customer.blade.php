@extends('layouts.base')
@section('body')
<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="bi bi-shop"></i> {{ config('app.store.name') }}
        </a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="nav">
            <form action="{{ route('search') }}" class="d-flex mx-lg-3 my-2 my-lg-0 flex-grow-1" method="GET">
                <input class="form-control" type="search" name="q" placeholder="Cari beras…" value="{{ request('q') }}">
                <button class="btn btn-tb-outline ms-2"><i class="bi bi-search"></i></button>
            </form>
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                @auth
                    <li class="nav-item"><a class="nav-link position-relative" href="{{ route('cart.index') }}"><i class="bi bi-cart3 fs-5"></i>
                        @if(($globalCartCount ?? 0) > 0)<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $globalCartCount }}</span>@endif
                    </a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('orders.index') }}"><i class="bi bi-bag-check"></i> Pesanan</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="bi bi-person-circle"></i> {{ auth()->user()->full_name }}</a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @if(auth()->user()->isAdmin())
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Panel</a></li><li><hr class="dropdown-divider"></li>
                            @endif
                            <li><form action="{{ route('logout') }}" method="POST">@csrf<button class="dropdown-item">Logout</button></form></li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="btn btn-tb-primary btn-sm" href="{{ route('register') }}">Daftar</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<main class="container py-4">
    @include('partials.alerts')
    @yield('content')
</main>

<footer class="py-4 mt-5">
    <div class="container text-center">
        <strong>{{ config('app.store.name') }}</strong> &middot; Beras berkualitas untuk keluarga Indonesia<br>
        <small>&copy; {{ date('Y') }} {{ config('app.store.name') }}</small>
    </div>
</footer>
@endsection
