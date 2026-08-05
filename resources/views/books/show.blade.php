@php
    $avg = $book->ratings_avg_score !== null ? round((float) $book->ratings_avg_score, 1) : null;
    $count = (int) $book->ratings_count;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h1 class="h3 mb-0">{{ $book->title }}</h1>
                <p class="text-muted mb-0">by {{ $book->author }}</p>
            </div>
            <div class="d-flex gap-2">
                @can('update', $book)
                    <a href="{{ route('books.edit', $book) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
                @endcan
                @can('delete', $book)
                    <form action="{{ route('books.destroy', $book) }}" method="post" onsubmit="return confirm('Delete this book permanently?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                    </form>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="row g-4">
        <div class="col-lg-4">
            @if ($book->cover_url)
                <img src="{{ $book->cover_url }}" class="img-fluid rounded shadow-sm w-100" alt="Cover">
            @endif
            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body">
                    <h2 class="h6 text-uppercase text-muted">About this book</h2>
                    <div class="small mb-0">{!! $book->description ? nl2br(e($book->description)) : 'No description provided.' !!}</div>
                    <hr>
                    <p class="small mb-1"><strong>Average rating:</strong>
                        @if ($count)
                            <span class="text-warning">&#9733;</span> {{ $avg }} / 5 ({{ $count }} rating(s))
                        @else
                            <span class="text-muted">No ratings yet</span>
                        @endif
                    </p>
                    <p class="small mb-0 text-muted">Uploaded by {{ $book->uploadedBy->name ?? 'Unknown' }} on {{ $book->created_at->format('M j, Y') }}</p>
                </div>
            </div>

            @if ($book->pdf_url)
                <div class="mt-3 d-grid gap-2">
                    <a href="{{ $book->pdf_url }}" class="btn btn-secondary" download>Download PDF</a>
                </div>
            @endif

            @auth
                @if (auth()->user()->isAdmin())
                    <p class="small text-muted mt-3 mb-0">حساب المدير لا يمكنه تقييم الكتب.</p>
                @else
                    <div class="card border-0 shadow-sm mt-3">
                        <div class="card-body">
                            <h2 class="h6">Your rating</h2>
                            <p class="small text-muted mb-2">One rating per book; submitting again updates your score.</p>
                            <form action="{{ route('ratings.store', $book) }}" method="post" id="rating-form">
                                @csrf
                                <div class="mb-2" id="star-picker" role="group" aria-label="Star rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <input type="radio" class="btn-check" name="score" id="score{{ $i }}" value="{{ $i }}" autocomplete="off" @checked((int) $userRating === $i) required>
                                        <label class="btn btn-outline-warning btn-sm" for="score{{ $i }}">{{ $i }} &#9733;</label>
                                    @endfor
                                </div>
                                @error('score')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                                <button type="submit" class="btn btn-primary btn-sm">Save rating</button>
                            </form>
                        </div>
                    </div>
                @endif
            @else
                <p class="small text-muted mt-3"><a href="{{ route('login') }}">Log in</a> to rate this book.</p>
            @endauth
        </div>

        <div class="col-lg-8">
            <h2 class="h5 mb-3">Read online</h2>
            @if ($book->pdf_url)
                <p class="small text-muted">If the preview does not load in your browser, use the download button.</p>
                <embed class="pdf-reader w-100 rounded" src="{{ $book->pdf_url }}#toolbar=1" type="application/pdf">
            @else
                <div class="alert alert-warning">PDF file is not available for this book.</div>
            @endif

            <section id="comments" class="mt-5">
                <h2 class="h5 mb-3">تعليقات على الكتاب</h2>
                <p class="small text-muted mb-3">شارك رأيك أو استفسارك حول هذا الكتاب. يظهر اسمك مع التعليق.</p>

                @auth
                    @if (auth()->user()->isAdmin())
                        <div class="alert alert-light border mb-4" role="alert">
                            حساب المدير لا يمكنه إضافة تعليقات؛ يمكنك حذف التعليقات من لوحة الإدارة.
                        </div>
                    @else
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h3 class="h6 card-title">أضف تعليقك</h3>
                                <form action="{{ route('comments.store', $book) }}" method="post">
                                    @csrf
                                    <div class="mb-2">
                                        <label for="content" class="form-label">نص التعليق</label>
                                        <textarea name="content" id="content" rows="4" class="form-control @error('content') is-invalid @enderror" required maxlength="5000" placeholder="اكتب تعليقك هنا…">{{ old('content') }}</textarea>
                                        @error('content')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">نشر التعليق</button>
                                </form>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="alert alert-light border mb-4" role="alert">
                        <a href="{{ route('login') }}" class="alert-link">سجّل الدخول</a> لكتابة تعليق على هذا الكتاب.
                    </div>
                @endauth

                <h3 class="h6 text-muted text-uppercase mb-2">التعليقات السابقة</h3>
                <ul class="list-group list-group-flush shadow-sm rounded border">
                    @forelse ($book->comments as $comment)
                        <li class="list-group-item py-3">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                <div>
                                    <strong>{{ $comment->user->name }}</strong>
                                    <span class="text-muted small ms-2">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <p class="mb-0 mt-2">{{ $comment->content }}</p>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">لا توجد تعليقات بعد. كن أول من يعلّق.</li>
                    @endforelse
                </ul>
            </section>
        </div>
    </div>
</x-app-layout>
