<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function users(): View
    {
        $users = User::query()->orderBy('name')->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function destroyUser(Request $request, User $user): RedirectResponse
    {
        if ($user->id === $request->user()->id) {
            return redirect()->route('admin.users.index')->with('error', 'لا يمكنك حذف حسابك بهذه الطريقة.');
        }

        if ($user->isAdmin() && User::where('role', 'admin')->count() <= 1) {
            return redirect()->route('admin.users.index')->with('error', 'لا يمكن حذف آخر مدير في النظام.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'تم حذف المستخدم.');
    }

    public function updateUserRole(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', 'string', 'in:user,author,admin'],
        ]);

        if ($user->isAdmin()
            && $validated['role'] !== 'admin'
            && User::where('role', 'admin')->count() <= 1) {
            return redirect()->route('admin.users.index')->with('error', 'يجب أن يبقى مدير واحد على الأقل.');
        }

        $user->update(['role' => $validated['role']]);

        return redirect()->route('admin.users.index')->with('success', 'تم تحديث نوع المستخدم.');
    }

    public function banUser(Request $request, User $user): RedirectResponse
    {
        if ($user->id === $request->user()->id) {
            return redirect()->route('admin.users.index')->with('error', 'لا يمكنك حظر نفسك.');
        }

        $user->forceFill(['banned_at' => now()])->save();

        return redirect()->route('admin.users.index')->with('success', 'تم حظر المستخدم.');
    }

    public function unbanUser(User $user): RedirectResponse
    {
        $user->forceFill(['banned_at' => null])->save();

        return redirect()->route('admin.users.index')->with('success', 'تم إلغاء حظر المستخدم.');
    }

    public function books(): View
    {
        $books = Book::query()
            ->with('uploadedBy')
            ->withAvg('ratings', 'score')
            ->withCount('ratings')
            ->latest()
            ->paginate(20);

        return view('admin.books', compact('books'));
    }

    public function comments(): View
    {
        $comments = Comment::query()
            ->with(['user', 'book'])
            ->latest()
            ->paginate(30);

        return view('admin.comments', compact('comments'));
    }

    public function destroyComment(Comment $comment): RedirectResponse
    {
        $comment->delete();

        return redirect()->route('admin.comments.index')->with('success', 'Comment removed.');
    }
}
