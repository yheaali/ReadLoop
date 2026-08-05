<section>
    <h2 class="h5">Update password</h2>
    <p class="text-muted small">Use a long, random password to keep your account secure.</p>

    <form method="post" action="{{ route('password.update') }}" class="mt-3">
        @csrf
        @method('put')
        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">Current password</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="update_password_password" class="form-label">New password</label>
            <input id="update_password_password" name="password" type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" autocomplete="new-password">
            @error('password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">Confirm new password</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Save password</button>
        @if (session('status') === 'password-updated')
            <span class="text-success small ms-2">Saved.</span>
        @endif
    </form>
</section>
