@extends('layouts.auth')

@section('title', 'Reset Password')

@section('card-title')
    Buat password baru untuk akun Anda.
@endsection

@section('content')

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

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email', $request->email) }}" required autofocus readonly>
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password Baru</label>
            <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password" placeholder="Masukkan password baru">
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Ketik ulang password baru">
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">
                Reset Password
            </button>
        </div>
    </form>
@endsection

