<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\View\View;

class AuthorStatsController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        if (! $user->canAccessAuthorStats()) {
            abort(403);
        }

        $books = Book::query()
            ->where('uploaded_by', $user->id)
            ->withCount('comments')
            ->withAvg('ratings', 'score')
            ->withCount('ratings')
            ->latest()
            ->get();

        return view('author.stats', compact('books'));
    }
}
