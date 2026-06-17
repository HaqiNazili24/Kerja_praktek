@extends('layouts.customer')
@section('title','Checkout')
@section('content')
<h3 class="fw-bold mb-4 text-success"><i class="bi bi-bag-check"></i> Checkout</h3>
<form action="{{ route('checkout.place') }}" method="POST">@csrf
<div class="row g-4">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white p-4">
            <h5 class="fw-bold text-dark mb-4">Alamat Pengiriman</h5>
            @if($addresses->isNotEmpty())
                <div class="mb-4">
                    @foreach($addresses as $a)
                        <div class="form-check border rounded-3 p-3 mb-2 d-flex align-items-center">
                            <input class="form-check-input me-3 ms-0" type="radio" name="address_id" value="{{ $a->id }}" id="a{{$a->id}}" @checked($loop->first)>
                            <label class="form-check-label w-100" for="a{{$a->id}}">
                                <div class="d-flex justify-content-between mb-1">
                                    <strong class="text-dark">{{ $a->label }} — {{ $a->recipient_name }}</strong>
                                    <span class="text-muted small">{{ $a->phone }}</span>
                                </div>
                                <span class="text-muted small d-block">{{ $a->full_address }}, {{ $a->city }}, {{ $a->province }} {{ $a->postal_code }}</span>
                            </label>
                        </div>
                    @endforeach
                    <hr class="my-4" style="border-color: #f1eeeb;">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="small text-muted fw-semibold mb-0">Butuh alamat pengiriman lain?</p>
                        <button type="button" class="btn btn-sm btn-tb-outline px-3" data-bs-toggle="collapse" data-bs-target="#new-address-form-wrapper" aria-expanded="false" aria-controls="new-address-form-wrapper" onclick="toggleNewAddressLabel(this)">
                            Tambah Alamat Baru
                        </button>
                    </div>
                </div>
            @endif
            
            <div id="new-address-form-wrapper" class="collapse {{ $addresses->isEmpty() ? 'show' : '' }}">
                <div class="row g-3 pt-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="recipient_name" class="form-control" id="rn" placeholder="Nama Penerima" {{ $addresses->isNotEmpty() ? 'disabled' : '' }}>
                            <label for="rn">Nama Penerima</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="phone" class="form-control" id="ph" placeholder="No. HP" {{ $addresses->isNotEmpty() ? 'disabled' : '' }}>
                            <label for="ph">No. HP</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating">
                            <textarea name="full_address" class="form-control" id="fa" placeholder="Alamat lengkap" style="height: 100px;" {{ $addresses->isNotEmpty() ? 'disabled' : '' }}></textarea>
                            <label for="fa">Alamat Lengkap</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" name="city" class="form-control" id="ct" placeholder="Kota" {{ $addresses->isNotEmpty() ? 'disabled' : '' }}>
                            <label for="ct">Kota</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" name="province" class="form-control" id="pr" placeholder="Provinsi" {{ $addresses->isNotEmpty() ? 'disabled' : '' }}>
                            <label for="pr">Provinsi</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" name="postal_code" class="form-control" id="pc" placeholder="Kode Pos" {{ $addresses->isNotEmpty() ? 'disabled' : '' }}>
                            <label for="pc">Kode Pos</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-check ms-1 mt-2">
                            <input type="checkbox" name="save_address" value="1" class="form-check-input" id="sa" {{ $addresses->isNotEmpty() ? 'disabled' : '' }}>
                            <label class="form-check-label text-muted small" for="sa">Simpan alamat ini ke daftar alamat saya</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
            <h5 class="fw-bold text-dark mb-4">Metode Pembayaran</h5>
            
            <div class="form-check border rounded-3 p-3 mb-2 d-flex align-items-center">
                <input class="form-check-input me-3 ms-0" type="radio" name="payment_method" value="transfer" id="pm_transfer" checked onchange="togglePaymentInfo()">
                <label class="form-check-label w-100" for="pm_transfer">
                    <strong class="d-block text-dark"><i class="bi bi-bank text-success me-2"></i> Transfer Bank</strong>
                    <span class="text-muted small">Pembayaran transfer manual ke rekening bank kami</span>
                </label>
            </div>
            
            <div class="form-check border rounded-3 p-3 mb-3 d-flex align-items-center">
                <input class="form-check-input me-3 ms-0" type="radio" name="payment_method" value="cod" id="pm_cod" onchange="togglePaymentInfo()">
                <label class="form-check-label w-100" for="pm_cod">
                    <strong class="d-block text-dark"><i class="bi bi-cash-coin text-success me-2"></i> Cash On Delivery (COD)</strong>
                    <span class="text-muted small">Bayar langsung secara tunai saat beras tiba di tempat Anda</span>
                </label>
            </div>
            
            <div id="bank-info" class="rounded-3 mt-3 overflow-hidden" style="border: 1.5px solid #e0e7ef;">
                {{-- Header BCA --}}
                <div class="d-flex align-items-center gap-3 px-4 py-3" style="background: #f0f6ff; border-bottom: 1.5px solid #e0e7ef;">
                    <img src="{{ asset('assets/images/Logo-BCA.jpeg') }}" alt="Bank BCA" style="height: 28px; object-fit: contain;">
                    <strong class="text-dark small">Informasi Rekening Transfer</strong>
                </div>
                {{-- Body --}}
                <div class="px-4 py-3 bg-white">
                    <div class="small text-muted mb-1">Bank</div>
                    <div class="fw-bold text-dark mb-3">{{ config('app.store.bank_name') }}</div>

                    <div class="small text-muted mb-1">No. Rekening</div>
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="fw-bold text-dark fs-5 tracking-wide" id="rekening-number" style="letter-spacing: 0.06em;">{{ config('app.store.bank_account') }}</span>
                        <button type="button" onclick="copyRekening()" id="copy-btn"
                            class="btn btn-sm d-flex align-items-center gap-1"
                            style="background:#e8f5e9; color:#2E7D32; border:1px solid #c8e6c9; border-radius:8px; font-size:12px; padding:4px 10px; font-weight:600;">
                            <i class="bi bi-copy" id="copy-icon"></i>
                            <span id="copy-label">Salin</span>
                        </button>
                    </div>

                    <div class="small text-muted mb-1">Atas Nama</div>
                    <div class="fw-bold text-dark">{{ config('app.store.bank_holder') }}</div>
                </div>
                <div class="px-4 py-2" style="background:#fffbf0; border-top:1px solid #fde8a0;">
                    <small class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-info-circle me-1 text-warning"></i>Setelah transfer, unggah bukti pembayaran di menu riwayat pesanan.</small>
                </div>
            </div>

        </div>
        
        <script>
            function togglePaymentInfo() {
                document.getElementById('bank-info').style.display =
                    document.getElementById('pm_transfer').checked ? 'block' : 'none';
            }
            function copyRekening() {
                const num = document.getElementById('rekening-number').innerText.trim();
                navigator.clipboard.writeText(num).then(function() {
                    const label = document.getElementById('copy-label');
                    const icon  = document.getElementById('copy-icon');
                    const btn   = document.getElementById('copy-btn');
                    label.textContent = 'Tersalin!';
                    icon.className = 'bi bi-check-lg';
                    btn.style.background = '#c8e6c9';
                    btn.style.color = '#1B5E20';
                    setTimeout(function() {
                        label.textContent = 'Salin';
                        icon.className = 'bi bi-copy';
                        btn.style.background = '#e8f5e9';
                        btn.style.color = '#2E7D32';
                    }, 2000);
                });
            }
        </script>
    </div>

    <div class="col-md-5">
        <div class="card border-0 shadow-sm rounded-4 sticky-top p-4 bg-white" style="top:100px">
            <h5 class="fw-bold text-dark mb-4">Ringkasan Pesanan</h5>
            <div class="mb-4" style="max-height: 240px; overflow-y: auto;">
                @foreach($items as $i)
                    <div class="d-flex justify-content-between mb-3 align-items-center">
                        <div style="max-width: 70%;">
                            <strong class="text-dark d-block" style="font-size: 0.95rem;">{{ $i->product->name }}</strong>
                            <small class="text-muted">{{ $i->quantity }} x Rp {{ number_format($i->product->price,0,',','.') }}</small>
                        </div>
                        <span class="fw-semibold text-dark">Rp {{ number_format($i->subtotal,0,',','.') }}</span>
                    </div>
                @endforeach
            </div>
            
            <hr class="my-3" style="border-color: #f1eeeb;">
            
            <div class="d-flex justify-content-between mb-2 small">
                <span class="text-muted">Subtotal</span>
                <span class="text-dark font-medium">Rp {{ number_format($subtotal,0,',','.') }}</span>
            </div>
            <div class="d-flex justify-content-between mb-3 small">
                <span class="text-muted">Ongkir</span>
                <span class="text-dark font-medium">Rp {{ number_format($shipping,0,',','.') }}</span>
            </div>
            
            <hr class="my-3" style="border-color: #f1eeeb;">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <strong class="text-dark fs-5">Total</strong>
                <strong class="text-success fs-4">Rp {{ number_format($total,0,',','.') }}</strong>
            </div>
            
            <button class="btn btn-tb-primary w-100 py-3 fs-6 d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-lock-fill"></i> Buat Pesanan
            </button>
    </div>
</form>
@push('scripts')
<script>
    function toggleNewAddressLabel(btn) {
        // Cek jika collapse sedang terbuka atau tertutup
        const wrapper = document.getElementById('new-address-form-wrapper');
        const isOpening = !wrapper.classList.contains('show'); // BS class before transition
        const inputs = wrapper.querySelectorAll('input, textarea');
        
        inputs.forEach(input => {
            input.disabled = !isOpening;
        });

        if (isOpening) {
            // Deselect semua radio alamat tersimpan
            document.querySelectorAll('input[name="address_id"]').forEach(radio => {
                radio.checked = false;
            });
            btn.textContent = 'Gunakan Alamat Tersimpan';
            btn.classList.replace('btn-tb-outline', 'btn-secondary');
        } else {
            // Re-select radio pertama jika ada
            const firstRadio = document.querySelector('input[name="address_id"]');
            if (firstRadio) {
                firstRadio.checked = true;
                firstRadio.dispatchEvent(new Event('change'));
            }
            btn.textContent = 'Tambah Alamat Baru';
            btn.classList.replace('btn-secondary', 'btn-tb-outline');
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        const radios = document.querySelectorAll('input[name="address_id"]');
        const collapseEl = document.getElementById('new-address-form-wrapper');
        const btn = document.querySelector('[data-bs-target="#new-address-form-wrapper"]');
        if (!collapseEl) return;
        
        const bsCollapse = new bootstrap.Collapse(collapseEl, { toggle: false });
        
        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    bsCollapse.hide();
                    const inputs = collapseEl.querySelectorAll('input, textarea');
                    inputs.forEach(input => {
                        input.disabled = true;
                        input.value = ''; // Reset nilai form baru jika menggunakan alamat tersimpan
                    });
                    if (btn) {
                        btn.textContent = 'Tambah Alamat Baru';
                        btn.classList.replace('btn-secondary', 'btn-tb-outline');
                    }
                }
            });
        });
    });
</script>
@endpush
@endsection