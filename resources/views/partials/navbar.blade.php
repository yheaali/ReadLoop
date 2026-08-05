<nav class="navbar navbar-expand-lg navbar-dark navbar-readloop shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">{{ __('ui.home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('books.index') ? 'active' : '' }}" href="{{ route('books.index') }}">{{ __('ui.books') }}</a>
                </li>
                @auth
                    @if (auth()->user()->canPublishBooks())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('books.create') ? 'active' : '' }}" href="{{ route('books.create') }}">{{ __('ui.add_book') }}</a>
                        </li>
                    @endif
                    @if (auth()->user()->canAccessAuthorStats())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('author.stats') ? 'active' : '' }}" href="{{ route('author.stats') }}">{{ __('ui.author_stats') }}</a>
                        </li>
                    @endif
                @endauth
                @auth
                    @if (auth()->user()->isAdmin())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ __('ui.admin') }}</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">{{ __('ui.users') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.books.index') }}">{{ __('ui.books') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.comments.index') }}">{{ __('ui.comments') }}</a></li>
                            </ul>
                        </li>
                    @endif
                @endauth
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ __('ui.language') }}</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('locale.switch', 'en') }}">{{ __('ui.english') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('locale.switch', 'ar') }}">{{ __('ui.arabic') }}</a></li>
                    </ul>
                </li>
                <li class="nav-item d-flex align-items-center ms-2">
                    <button class="btn btn-sm btn-light theme-toggle-btn" type="button" id="theme-toggle-btn">🌙 {{ __('ui.theme_dark') }}</button>
                </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('ui.login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('ui.register') }}</a>
                    </li>
                @else
                    <li class="nav-item d-flex align-items-center me-2">
                        <span class="badge badge-role-readloop text-wrap">{{ Auth::user()->roleLabelAr() }}</span>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ Auth::user()->name }}</a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('ui.profile') }}</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">{{ __('ui.logout') }}</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
