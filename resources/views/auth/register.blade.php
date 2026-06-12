@extends('layouts.customer')
@section('title','Daftar')
@section('content')
<div class="row justify-content-center"><div class="col-md-6">
    <div class="card border-0 shadow-sm"><div class="card-body p-4">
        <h4 class="text-tb-green mb-3">Daftar Akun Baru</h4>
        <form method="POST">@csrf
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input name="full_name" class="form-control" value="{{ old('full_name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">No. HP</label>
                <input name="phone" class="form-control" value="{{ old('phone') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="passwordReg" class="form-control" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('passwordReg', this)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <div class="input-group">
                    <input type="password" name="password_confirmation" id="passwordConfirm" class="form-control" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('passwordConfirm', this)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
            <button class="btn btn-tb-primary w-100">Daftar</button>
        </form>
        <p class="text-center mt-3 small">Sudah punya akun? <a href="{{ route('login') }}" class="text-tb-green">Login</a></p>
    </div></div>
</div></div>

@push('scripts')
<script>
function togglePassword(fieldId, btn) {
    const input = document.getElementById(fieldId);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}
</script>
@endpush
@endsection