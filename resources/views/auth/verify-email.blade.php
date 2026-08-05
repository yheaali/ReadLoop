<x-guest-layout>
    <h1 class="h4 mb-3">Verify your email</h1>
    <p class="small text-muted mb-4">Please click the link in the email we sent you. If you did not receive it, you can request another.</p>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success small mb-3">A new verification link has been sent.</div>
    @endif

    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Resend email</button>
        </form>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link">Log out</button>
        </form>
    </div>
</x-guest-layout>
