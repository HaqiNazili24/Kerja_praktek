@php $isEdit = isset($product); @endphp
<div class="row g-3">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm"><div class="card-body">
            <div class="mb-3"><label class="form-label">Nama Produk</label>
                <input name="name" class="form-control" value="{{ old('name', $product->name ?? '') }}" required></div>
            <div class="mb-3"><label class="form-label">Deskripsi</label>
                <textarea name="description" rows="4" class="form-control">{{ old('description', $product->description ?? '') }}</textarea></div>
            <div class="row g-2">
                <div class="col-md-4"><label class="form-label">Harga (Rp)</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price', isset($product) ? (int) $product->price : '') }}" required min="0" step="1"></div>
                <div class="col-md-4"><label class="form-label">Kemasan</label>
                    <input name="weight_label" class="form-control" value="{{ old('weight_label', $product->weight_label ?? '5kg') }}" required></div>
                <div class="col-md-4"><label class="form-label">Stok</label>
                    <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock ?? 0) }}" required min="0"></div>
            </div>
        </div></div>

        <div class="card border-0 shadow-sm mt-3"><div class="card-body">
            <h6>Foto Produk</h6>
            <input type="file" name="image" accept="image/jpg,image/jpeg,image/png" class="form-control mb-2">
            <small class="text-muted">Format: JPG, PNG. Maksimal 2MB.</small>
            @if($isEdit && $product->image_url)
                <div class="mt-3">
                    <p class="small text-muted mb-1">Foto saat ini:</p>
                    <img src="{{ asset('storage/'.$product->image_url) }}"
                         class="img-fluid rounded"
                         style="max-height:150px; object-fit:contain;"
                         onerror="this.src='https://placehold.co/400x400/e8f5e9/2D5016?text=Beras'">
                </div>
            @endif
        </div></div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm"><div class="card-body">
            <div class="mb-3"><label class="form-label">Sub Kategori</label>
                <select name="sub_category_id" class="form-select" required>
                    <option value="">— Pilih —</option>
                    @foreach($subCategories as $sc)
                        <option value="{{ $sc->id }}" @selected(old('sub_category_id', $product->sub_category_id ?? '') == $sc->id)>{{ $sc->category->name }} / {{ $sc->name }}</option>
                    @endforeach
                </select></div>
            <div class="form-check form-switch mb-3">
                <input type="hidden" name="is_active" value="0">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="ia"
                       @checked(old('is_active', $isEdit ? $product->is_active : true))>
                <label class="form-check-label" for="ia">Aktif (terlihat di toko)</label>
            </div>
            <button class="btn btn-tb-primary w-100">{{ $isEdit ? 'Simpan Perubahan' : 'Buat Produk' }}</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-link w-100 mt-1">Batal</a>
        </div></div>
    </div>
</div>