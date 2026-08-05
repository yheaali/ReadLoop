<x-app-layout>
    <x-slot name="header">
        <h1 class="h3 mb-0">إحصائيات محتواك</h1>
        <p class="text-muted small mb-0">تعليقات القرّاء والتقييمات للكتب المرتبطة بحسابك.</p>
    </x-slot>

    @if ($books->isEmpty())
        <p class="text-muted mb-0">لا توجد كتب مرتبطة بحسابك حالياً.</p>
        @if (auth()->user()->canPublishBooks())
            <p class="mt-2"><a href="{{ route('books.create') }}" class="btn btn-primary btn-sm">إضافة كتاب</a></p>
        @endif
    @else
        <div class="table-responsive shadow-sm rounded border bg-white">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>العنوان</th>
                        <th>التعليقات</th>
                        <th>متوسط التقييم</th>
                        <th>عدد التقييمات</th>
                        <th class="text-end">عرض</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $book)
                        @php
                            $avg = $book->ratings_avg_score !== null ? round((float) $book->ratings_avg_score, 1) : null;
                        @endphp
                        <tr>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->comments_count }}</td>
                            <td>
                                @if ($book->ratings_count)
                                    <span class="text-warning">&#9733;</span> {{ $avg }} / 5
                                @else
                                    —
                                @endif
                            </td>
                            <td>{{ $book->ratings_count }}</td>
                            <td class="text-end">
                                <a href="{{ route('books.show', $book) }}" class="btn btn-sm btn-outline-primary">صفحة الكتاب</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</x-app-layout>
