@extends('layouts.auth')

@section('card-title', 'Silakan isi informasi untuk mendaftar.')

@section('content')

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

<form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Name -->
    <div class="mb-3">
        <label for="name" class="form-label">Nama</label>
        <input type="text" id="name" class="form-control" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required autofocus>
    </div>

    <!-- Email -->
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" class="form-control" name="email" placeholder="Alamat email" value="{{ old('email') }}" required>
    </div>

    <!-- Role -->
    <div class="mb-3">
        <label for="role_id" class="form-label">Daftar sebagai</label>
        <select class="form-select @error('role_id') is-invalid @enderror" id="role_id" name="role_id" required>
            <option value="" disabled selected>Pilih peran...</option>
            @foreach ($roles as $role)
                {{-- Jangan tampilkan Admin sebagai pilihan pendaftaran publik --}}
                @if ($role->name !== 'Admin')
                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endif
            @endforeach
        </select>
        @error('role_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label for="password" class="form-label">Kata Sandi</label>
        <input type="password" id="password" class="form-control" name="password" placeholder="**************" required>
    </div>

    <!-- Confirm Password -->
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
        <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="**************" required>
    </div>

    <div>
        <!-- Button -->
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Daftar</button>
        </div>

        <div class="d-md-flex justify-content-between mt-4">
            <div class="mb-2 mb-md-0">
                <a href="{{ route('login') }}" class="fs-5">Sudah punya akun? Masuk</a>
            </div>
        </div>
    </div>
</form>
@endsection

