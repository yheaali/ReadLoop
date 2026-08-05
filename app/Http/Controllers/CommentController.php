<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Book $book): RedirectResponse
    {
        if ($request->user()->isAdmin()) {
            return redirect()->route('books.show', $book)
                ->withFragment('comments')
                ->with('error', 'حساب المدير لا يمكنه إضافة تعليقات.');
        }

        $validated = $request->validate([
            'content' => ['required', 'string', 'max:5000'],
        ]);

        Comment::create([
            'user_id' => $request->user()->id,
            'book_id' => $book->id,
            'content' => $validated['content'],
        ]);

        return redirect()->route('books.show', $book)
            ->withFragment('comments')
            ->with('success', 'تم نشر تعليقك على الكتاب.');
    }
}
