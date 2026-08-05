<section>
    <h2 class="h5">Profile information</h2>
    <p class="text-muted small">Update your name and email address.</p>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-3">
        @csrf
        @method('patch')
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autocomplete="name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="form-text text-warning">
                    Your email is unverified.
                    <button form="send-verification" type="submit" class="btn btn-link btn-sm p-0 align-baseline">Resend verification email</button>
                </div>
                @if (session('status') === 'verification-link-sent')
                    <div class="form-text text-success">A new verification link was sent.</div>
                @endif
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        @if (session('status') === 'profile-updated')
            <span class="text-success small ms-2">Saved.</span>
        @endif
    </form>
</section>
