@extends('layouts.admin')
@section('page-title','Kategori')
@section('content')
<div class="row g-3">
<div class="col-md-4">
    <div class="card border-0 shadow-sm"><div class="card-body">
        <h6>Tambah Kategori</h6>
        <form action="{{ route('admin.categories.store') }}" method="POST">@csrf
            <input name="name" class="form-control mb-2" placeholder="Nama kategori" required>
            <button class="btn btn-tb-primary w-100">Tambah</button>
        </form>
    </div></div>
</div>
<div class="col-md-8">
    <div class="card border-0 shadow-sm"><div class="card-body p-0">
        <table class="table mb-0 align-middle">
            <thead class="bg-light"><tr><th>Nama</th><th>Sub Kategori</th><th></th></tr></thead>
            <tbody>
                @forelse($categories as $c)
                    <tr>
                        <td>
                            <form action="{{ route('admin.categories.update',$c) }}" method="POST" class="d-flex gap-1">@csrf @method('PATCH')
                                <input name="name" value="{{ $c->name }}" class="form-control form-control-sm">
                                <button class="btn btn-sm btn-tb-outline"><i class="bi bi-check"></i></button>
                            </form>
                        </td>
                        <td>{{ $c->sub_categories_count }}</td>
                        <td><form action="{{ route('admin.categories.destroy',$c) }}" method="POST" onsubmit="return confirm('Hapus kategori?')">@csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form></td>
                    </tr>
                @empty <tr><td colspan="3" class="text-center text-muted py-3">Belum ada kategori.</td></tr> @endforelse
            </tbody>
        </table>
    </div></div>
    <div class="mt-2">{{ $categories->links() }}</div>
</div>
</div>
@endsection
