<section>
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Informasi Profil</h4>
            <p class="mb-0">Perbarui informasi profil dan alamat email akun Anda.</p>
        </div>
        <div class="card-body">
            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <form method="post" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                    @error('name')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="email">
                    @error('email')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="mt-2">
                            <p class="text-sm text-muted">
                                Alamat email Anda belum terverifikasi.
                                <button form="send-verification" class="btn btn-link p-0 m-0 align-baseline">
                                    Klik di sini untuk mengirim ulang email verifikasi.
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 fw-medium text-success">
                                    Link verifikasi baru telah dikirim ke alamat email Anda.
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="d-flex align-items-center">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>

                    @if (session('status') === 'profile-updated')
                        <p class="ms-3 text-sm text-muted mb-0">Tersimpan.</p>
                    @endif
                </div>
            </form>
        </div>
    </div>
</section>