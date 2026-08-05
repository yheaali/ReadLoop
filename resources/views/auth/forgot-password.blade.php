<x-guest-layout>
    <h1 class="h4 mb-3">Forgot password</h1>
    <p class="small text-muted mb-4">Enter your email and we will send a reset link.</p>

    @if (session('status'))
        <div class="alert alert-success small mb-3">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required autofocus>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary w-100">Email reset link</button>
    </form>
    <p class="small text-muted mt-3 mb-0"><a href="{{ route('login') }}">Back to login</a></p>
</x-guest-layout>
