<x-app-layout>
    <x-slot name="header">
        <h1 class="h3 mb-0">Admin — Books</h1>
    </x-slot>

    <div class="table-responsive shadow-sm rounded border bg-white">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Uploaded by</th>
                    <th>Rating</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->uploadedBy->name ?? '—' }}</td>
                        <td>
                            @if ($book->ratings_count)
                                {{ number_format((float) $book->ratings_avg_score, 1) }} ({{ $book->ratings_count }})
                            @else
                                —
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('books.show', $book) }}" class="btn btn-sm btn-outline-secondary">View</a>
                            <form action="{{ route('books.destroy', $book) }}" method="post" class="d-inline" onsubmit="return confirm('Delete this book?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $books->links() }}
    </div>
</x-app-layout>
