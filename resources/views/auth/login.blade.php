@extends('layouts.auth')

@section('card-title', 'Silakan masuk ke akun Anda.')

@section('content')

<!-- Session Status -->
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

<!-- Validation Errors -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email -->
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" class="form-control" name="email" placeholder="Masukkan alamat email" value="{{ old('email') }}" required autofocus>
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label for="password" class="form-label">Kata Sandi</label>
        <input type="password" id="password" class="form-control" name="password" placeholder="**************" required>
    </div>

    <!-- Checkbox -->
    <div class="d-lg-flex justify-content-between align-items-center mb-4">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
            <label class="form-check-label" for="remember_me">Ingat saya</label>
        </div>
    </div>

    <div>
        <!-- Button -->
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Masuk</button>
        </div>

        <div class="d-md-flex justify-content-between mt-4">
            <div class="mb-2 mb-md-0">
                <a href="{{ route('register') }}" class="fs-5">Buat Akun Baru</a>
            </div>
            <div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-inherit fs-5">Lupa kata sandi Anda?</a>
                @endif
            </div>
        </div>
    </div>
</form>
@endsection

