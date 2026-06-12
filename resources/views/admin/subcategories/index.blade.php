@extends('layouts.admin')
@section('page-title','Sub Kategori')
@section('content')
<div class="row g-3">
<div class="col-md-4">
    <div class="card border-0 shadow-sm"><div class="card-body">
        <h6>Tambah Sub Kategori</h6>
        <form action="{{ route('admin.sub-categories.store') }}" method="POST">@csrf
            <select name="category_id" class="form-select mb-2" required>
                <option value="">— Pilih Kategori —</option>
                @foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
            </select>
            <input name="name" class="form-control mb-2" placeholder="Nama sub kategori" required>
            <button class="btn btn-tb-primary w-100">Tambah</button>
        </form>
    </div></div>
</div>
<div class="col-md-8">
    <div class="card border-0 shadow-sm"><div class="card-body p-0">
        <table class="table mb-0 align-middle">
            <thead class="bg-light"><tr><th>Kategori</th><th>Sub</th><th></th></tr></thead>
            <tbody>
                @forelse($subCategories as $s)
                    <tr>
                        <td>{{ $s->category->name }}</td>
                        <td>{{ $s->name }}</td>
                        <td><form action="{{ route('admin.sub-categories.destroy',$s) }}" method="POST" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form></td>
                    </tr>
                @empty <tr><td colspan="3" class="text-center text-muted py-3">Belum ada.</td></tr> @endforelse
            </tbody>
        </table>
    </div></div>
    <div class="mt-2">{{ $subCategories->links() }}</div>
</div>
</div>
@endsection
