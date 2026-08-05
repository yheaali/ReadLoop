<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Rating;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request, Book $book): RedirectResponse
    {
        if ($request->user()->isAdmin()) {
            return redirect()->route('books.show', $book)
                ->with('error', 'حساب المدير لا يمكنه تقييم الكتب.');
        }

        $validated = $request->validate([
            'score' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        Rating::query()->updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'book_id' => $book->id,
            ],
            ['score' => $validated['score']]
        );

        return redirect()->route('books.show', $book)->with('success', 'Your rating was saved.');
    }
}
