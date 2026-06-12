@extends('layouts.admin')
@section('page-title','Produk')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h5 class="mb-0">Daftar Produk</h5>
    <a href="{{ route('admin.products.create') }}" class="btn btn-tb-primary"><i class="bi bi-plus"></i> Produk Baru</a>
</div>
<div class="card border-0 shadow-sm"><div class="card-body p-0">
    <table class="table align-middle mb-0">
        <thead class="bg-light"><tr><th></th><th>Nama</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Aktif</th><th></th></tr></thead>
        <tbody>
            @forelse($products as $p)
            <tr>
                <td><img src="{{ $p->primary_image_url }}" width="48" height="48" class="rounded" style="object-fit:cover;"></td>
                <td><strong>{{ $p->name }}</strong><br><small class="text-muted">{{ $p->weight_label }}</small></td>
                <td><small>{{ $p->subCategory->category->name }} / {{ $p->subCategory->name }}</small></td>
                <td>Rp {{ number_format($p->price,0,',','.') }}</td>
                <td>{{ $p->stock }}</td>
                <td>@if($p->is_active)<span class="badge bg-success">Aktif</span>@else<span class="badge bg-secondary">Nonaktif</span>@endif</td>
                <td>
                    <a href="{{ route('admin.products.edit',$p) }}" class="btn btn-sm btn-tb-outline"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.products.destroy',$p) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus produk?')">@csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                </td>
            </tr>
            @empty <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada produk.</td></tr> @endforelse
        </tbody>
    </table>
</div></div>
<div class="mt-3">{{ $products->links() }}</div>
@endsection
