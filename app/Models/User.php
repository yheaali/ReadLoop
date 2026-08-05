<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'banned_at' => 'datetime',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isAuthor(): bool
    {
        return $this->role === 'author';
    }

    public function isBanned(): bool
    {
        return $this->banned_at !== null;
    }

    /** مستخدم عادي (قراءة، تعليقات، تقييم، ملفه الشخصي) */
    public function isReader(): bool
    {
        return $this->role === 'user';
    }

    /** لوحة إحصائيات المحتوى (للكاتب فقط) */
    public function canAccessAuthorStats(): bool
    {
        return $this->isAuthor();
    }

    /** نشر كتب جديدة — للكاتب فقط */
    public function canPublishBooks(): bool
    {
        return $this->isAuthor();
    }

    public function roleLabelAr(): string
    {
        return match ($this->role) {
            'admin' => 'مدير',
            'author' => 'كاتب',
            default => 'مستخدم',
        };
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'uploaded_by');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }
}
