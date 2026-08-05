<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;

class BookPolicy
{
    public function create(User $user): bool
    {
        return $user->canPublishBooks();
    }

    public function update(User $user, Book $book): bool
    {
        if ($user->isAdmin()) {
            return false;
        }

        return $book->uploaded_by === $user->id;
    }

    public function delete(User $user, Book $book): bool
    {
        return $user->isAdmin() || $book->uploaded_by === $user->id;
    }
}
