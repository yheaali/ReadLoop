<x-guest-layout>
    <h1 class="h4 mb-4">إنشاء حساب</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">الاسم</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required autofocus autocomplete="name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">البريد الإلكتروني</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">نوع الحساب</label>
            <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" required>
                <option value="user" @selected(old('role', 'user') === 'user')>مستخدم</option>
                <option value="author" @selected(old('role') === 'author')>كاتب</option>
            </select>
            @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">كلمة المرور</label>
            <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <a class="small" href="{{ route('login') }}">لديك حساب؟ تسجيل الدخول</a>
            <button type="submit" class="btn btn-primary">تسجيل</button>
        </div>
    </form>
</x-guest-layout>
