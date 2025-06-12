<section>
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Perbarui Password</h4>
            <p class="mb-0">Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.</p>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('password.update') }}">
                @csrf
                @method('put')

                <!-- Current Password -->
                <div class="mb-3">
                    <label for="update_password_current_password" class="form-label">Password Saat Ini</label>
                    <input id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password">
                    @error('current_password', 'updatePassword')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- New Password -->
                <div class="mb-3">
                    <label for="update_password_password" class="form-label">Password Baru</label>
                    <input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password">
                    @error('password', 'updatePassword')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="update_password_password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
                    @error('password_confirmation', 'updatePassword')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex align-items-center">
                    <button type="submit" class="btn btn-primary">Simpan Password</button>

                    @if (session('status') === 'password-updated')
                        <p class="ms-3 text-sm text-muted mb-0">Tersimpan.</p>
                    @endif
                </div>
            </form>
        </div>
    </div>
</section>