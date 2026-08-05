<x-app-layout>
    <x-slot name="header">
        <h1 class="h3 mb-0">Admin — Comments</h1>
    </x-slot>

    <div class="table-responsive shadow-sm rounded border bg-white">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>User</th>
                    <th>Book</th>
                    <th>Comment</th>
                    <th>When</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($comments as $comment)
                    <tr>
                        <td>{{ $comment->user->name ?? '—' }}</td>
                        <td>
                            <a href="{{ route('books.show', $comment->book) }}">{{ $comment->book->title ?? '—' }}</a>
                        </td>
                        <td class="small" style="max-width: 320px;">{{ \Illuminate\Support\Str::limit($comment->content, 120) }}</td>
                        <td class="small text-muted">{{ $comment->created_at->format('Y-m-d H:i') }}</td>
                        <td class="text-end">
                            <form action="{{ route('admin.comments.destroy', $comment) }}" method="post" class="d-inline" onsubmit="return confirm('Remove this comment?');">
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
        {{ $comments->links() }}
    </div>
</x-app-layout>
