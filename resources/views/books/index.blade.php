<x-app-layout>
    <x-slot name="header">
        <h1 class="h3 mb-0">All books</h1>
    </x-slot>

    <div class="row g-4">
        @forelse ($books as $book)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0">
                    @if ($book->cover_url)
                        <img src="{{ $book->cover_url }}" class="card-img-top book-card-cover" alt="">
                    @else
                        <div class="book-card-cover bg-secondary d-flex align-items-center justify-content-center text-white small">No cover</div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h2 class="card-title h5">{{ $book->title }}</h2>
                        <p class="card-text text-muted small">by {{ $book->author }}</p>
                        <p class="small text-muted mb-2">Uploaded by {{ $book->uploadedBy->name ?? 'Unknown' }}</p>
                        <p class="small mb-3">
                            @if ($book->ratings_count)
                                <span class="text-warning">&#9733;</span> {{ number_format((float) $book->ratings_avg_score, 1) }} — {{ $book->ratings_count }} rating(s)
                            @else
                                No ratings yet
                            @endif
                        </p>
                        <a href="{{ route('books.show', $book) }}" class="btn btn-outline-primary mt-auto">View & read</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">No books have been uploaded yet.</p>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $books->links() }}
    </div>
</x-app-layout>
