<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Beranda') — {{ config('app.store.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root{
            --tb-green:#2D5016; --tb-green-2:#3d6b1f;
            --tb-cream:#F5F0E8; --tb-brown:#8B4513; --tb-white:#fffdf8;
        }
        body{ background: var(--tb-cream); color:#2b2b2b; font-family:'Segoe UI',system-ui,sans-serif;}
        .navbar-brand{ font-weight:700; color:var(--tb-green)!important;}
        .bg-tb-green{ background:var(--tb-green)!important; color:#fff;}
        .text-tb-green{ color:var(--tb-green)!important;}
        .btn-tb-primary{ background:var(--tb-green); color:#fff; border:none;}
        .btn-tb-primary:hover{ background:var(--tb-green-2); color:#fff;}
        .btn-tb-outline{ border:1px solid var(--tb-green); color:var(--tb-green);}
        .btn-tb-outline:hover{ background:var(--tb-green); color:#fff;}
        .card-product{ border:none; border-radius:14px; overflow:hidden; transition:transform .15s, box-shadow .15s; background:#fff;}
        .card-product:hover{ transform:translateY(-3px); box-shadow:0 10px 25px rgba(0,0,0,.08);}
        .card-product img.product-thumb{ width:100%; aspect-ratio:1/1; object-fit:cover;}
        .price{ color:var(--tb-brown); font-weight:700;}
        .sidebar-admin{ background:var(--tb-green); min-height:100vh; color:#fff;}
        .sidebar-admin a{ color:#e8e2d0; display:block; padding:.6rem 1rem; border-radius:8px; text-decoration:none;}
        .sidebar-admin a.active,.sidebar-admin a:hover{ background:rgba(255,255,255,.12); color:#fff;}
        .status-badge{ font-size:.75rem;}
        footer{ background:var(--tb-green); color:#e8e2d0;}
    </style>
    @stack('head')
</head>
<body>
    @yield('body')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
