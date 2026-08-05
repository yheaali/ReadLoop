<x-guest-layout>
    <h1 class="h4 mb-4">تسجيل الدخول</h1>

    @if (session('status'))
        <div class="alert alert-success small">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">البريد الإلكتروني</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required autofocus autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">كلمة المرور</label>
            <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="remember" id="remember">
            <label class="form-check-label" for="remember">تذكرني</label>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            @if (Route::has('password.request'))
                <a class="small" href="{{ route('password.request') }}">نسيت كلمة المرور؟</a>
            @endif
            <button type="submit" class="btn btn-primary">دخول</button>
        </div>
    </form>
    <p class="small text-muted mt-4 mb-0">لا تملك حساباً؟ <a href="{{ route('register') }}">سجّل هنا</a></p>
</x-guest-layout>
