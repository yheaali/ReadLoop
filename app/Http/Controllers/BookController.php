<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(): View
    {
        $books = Book::query()
            ->with('uploadedBy')
            ->withAvg('ratings', 'score')
            ->withCount('ratings')
            ->latest()
            ->paginate(12);

        return view('books.index', compact('books'));
    }

    public function show(Book $book): View
    {
        $book->load([
            'uploadedBy',
            'comments.user',
        ]);
        $book->loadAvg('ratings', 'score');
        $book->loadCount('ratings');

        $userRating = null;
        if (auth()->check()) {
            $userRating = $book->ratings()->where('user_id', auth()->id())->value('score');
        }

        return view('books.show', [
            'book' => $book,
            'userRating' => $userRating,
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Book::class);

        return view('books.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Book::class);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:10000'],
            'cover' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'pdf' => ['required', 'file', 'mimes:pdf', 'max:2048'],
        ]);

        $pdfPath = $request->file('pdf')->store('books', 'public');
        $coverPath = $request->file('cover')->store('covers', 'public');

        Book::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'description' => $validated['description'] ?? null,
            'file_path' => $pdfPath,
            'cover_image' => $coverPath,
            'uploaded_by' => $request->user()->id,
        ]);

        return redirect()->route('books.index')->with('success', 'تم إضافة الكتاب.');
    }

    public function edit(Book $book): View
    {
        $this->authorize('update', $book);

        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book): RedirectResponse
    {
        $this->authorize('update', $book);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:10000'],
            'cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'pdf' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
        ]);

        $book->fill([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'description' => $validated['description'] ?? null,
        ]);

        if ($request->hasFile('cover')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $book->cover_image = $request->file('cover')->store('covers', 'public');
        }

        if ($request->hasFile('pdf')) {
            Storage::disk('public')->delete($book->file_path);
            $book->file_path = $request->file('pdf')->store('books', 'public');
        }

        $book->save();

        return redirect()->route('books.show', $book)->with('success', 'Book updated.');
    }

    public function destroy(Book $book): RedirectResponse
    {
        $this->authorize('delete', $book);

        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }
        Storage::disk('public')->delete($book->file_path);
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book removed.');
    }
}
