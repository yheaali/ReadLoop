<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="{{ asset('css/bookforum.css') }}" rel="stylesheet">
</head>
<body>
    @include('partials.navbar')

    @isset($header)
        <div class="page-header-readloop border-bottom py-3 mb-0">
            <div class="container">
                {{ $header }}
            </div>
        </div>
    @endisset

    <main class="py-4">
        <div class="container">
            @include('partials.flash')
            {{ $slot }}
        </div>
    </main>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @stack('scripts')
    <script>
    (function () {
        const root = document.documentElement;
        const storageKey = 'readloop-theme';
        const btn = document.getElementById('theme-toggle-btn');

        const applyTheme = (theme) => {
            root.setAttribute('data-theme', theme);
            if (btn) {
                const isDark = theme === 'dark';
                btn.textContent = isDark ? '☀️ {{ __('ui.theme_light') }}' : '🌙 {{ __('ui.theme_dark') }}';
            }
        };

        const stored = localStorage.getItem(storageKey);
        const initial = stored === 'dark' || stored === 'light'
            ? stored
            : (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        applyTheme(initial);

        if (btn) {
            btn.addEventListener('click', function () {
                const next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
                localStorage.setItem(storageKey, next);
                applyTheme(next);
            });
        }
    })();
    </script>
</body>
</html>
