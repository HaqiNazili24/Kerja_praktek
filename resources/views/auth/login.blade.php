@extends('layouts.customer')
@section('title','Login')
@section('content')
<div class="row justify-content-center"><div class="col-md-5">
    <div class="card border-0 shadow-sm"><div class="card-body p-4">
        <h4 class="text-tb-green mb-3">Masuk ke {{ config('app.store.name') }}</h4>
        <form method="POST">@csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="passwordLogin" class="form-control" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('passwordLogin', this)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="remember" class="form-check-input" id="rm">
                <label class="form-check-label" for="rm">Ingat saya</label>
            </div>
            <button class="btn btn-tb-primary w-100">Login</button>
        </form>
        <p class="text-center mt-3 small">Belum punya akun? <a href="{{ route('register') }}" class="text-tb-green">Daftar</a></p>
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