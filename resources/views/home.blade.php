@php($title = __('ui.home'))
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} — {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="{{ asset('css/bookforum.css') }}" rel="stylesheet">
</head>
<body>
    @include('partials.navbar')

    <header class="bg-primary text-white py-5">
        <div class="container">
            <h1 class="display-5 fw-bold">{{ __('ui.welcome', ['app' => config('app.name')]) }}</h1>
            <p class="lead mb-0 opacity-90">{{ __('ui.hero') }}</p>
        </div>
    </header>

    <main class="py-5">
        <div class="container">
            @include('partials.flash')
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 mb-0">{{ __('ui.recent') }}</h2>
                <a href="{{ route('books.index') }}" class="btn btn-outline-primary btn-sm">{{ __('ui.view_all') }}</a>
            </div>
            @if ($featuredBooks->isEmpty())
                <p class="text-muted">{{ __('ui.no_books') }}</p>
            @else
                <div class="row g-4">
                    @foreach ($featuredBooks as $book)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm border-0">
                                @if ($book->cover_url)
                                    <img src="{{ $book->cover_url }}" class="card-img-top book-card-cover" alt="Cover of {{ $book->title }}">
                                @else
                                    <div class="book-card-cover bg-secondary d-flex align-items-center justify-content-center text-white small">{{ __('ui.no_cover') }}</div>
                                @endif
                                <div class="card-body d-flex flex-column">
                                    <h3 class="card-title h5">{{ $book->title }}</h3>
                                    <p class="card-text text-muted small mb-2">{{ __('ui.by') }} {{ $book->author }}</p>
                                    <p class="small mb-3">
                                        @if ($book->ratings_count)
                                            <span class="text-warning">&#9733;</span> {{ number_format((float) $book->ratings_avg_score, 1) }} ({{ $book->ratings_count }} ratings)
                                        @else
                                            <span class="text-muted">{{ __('ui.no_ratings') }}</span>
                                        @endif
                                    </p>
                                    <a href="{{ route('books.show', $book) }}" class="btn btn-primary mt-auto">{{ __('ui.open_book') }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </main>

    @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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
            const initial = (stored === 'dark' || stored === 'light')
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
