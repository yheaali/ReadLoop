<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function switchLocale(string $locale): RedirectResponse
    {
        abort_unless(in_array($locale, ['en', 'ar'], true), 404);
        session(['locale' => $locale]);

        return back();
    }

    public function home(): View
    {
        $featuredBooks = Book::query()
            ->withAvg('ratings', 'score')
            ->withCount('ratings')
            ->latest()
            ->take(6)
            ->get();

        return view('home', ['featuredBooks' => $featuredBooks]);
    }

    public function dashboard(): RedirectResponse
    {
        return redirect()->route('books.index');
    }
}
