@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('card-title')
    Jangan khawatir, kami akan mengirimkan email untuk mereset password Anda.
@endsection

@section('content')
    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success mb-4" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form -->
    <form id="forgot-password-form" method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Masukkan alamat email Anda">
        </div>

        <!-- Button -->
        <div class="mb-3 d-grid">
            <button type="submit" id="submit-button" class="btn btn-primary">
                Kirim Link Reset Password
            </button>
        </div>
        <span>
            Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
        </span>
    </form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('forgot-password-form');
        const submitButton = document.getElementById('submit-button');
        const COOLDOWN_SECONDS = 60;
        const localStorageKey = 'password_reset_timestamp';

        let intervalId;

        function startCooldown(endTime) {
            submitButton.disabled = true;

            intervalId = setInterval(() => {
                const now = new Date().getTime();
                const remaining = Math.round((endTime - now) / 1000);

                if (remaining <= 0) {
                    clearInterval(intervalId);
                    submitButton.disabled = false;
                    submitButton.textContent = 'Kirim Link Reset Password';
                    localStorage.removeItem(localStorageKey);
                } else {
                    submitButton.textContent = `Tunggu ${remaining} detik...`;
                }
            }, 1000);
        }

        const lastRequestTime = localStorage.getItem(localStorageKey);
        if (lastRequestTime) {
            const endTime = parseInt(lastRequestTime) + (COOLDOWN_SECONDS * 1000);
            if (new Date().getTime() < endTime) {
                startCooldown(endTime);
            }
        }

        form.addEventListener('submit', function () {
            const now = new Date().getTime();
            localStorage.setItem(localStorageKey, now);
            startCooldown(now + (COOLDOWN_SECONDS * 1000));
        });
    });
</script>
@endpush