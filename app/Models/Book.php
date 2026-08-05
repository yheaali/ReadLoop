<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'description',
        'file_path',
        'cover_image',
        'uploaded_by',
    ];

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function averageRating(): float
    {
        return round((float) $this->ratings()->avg('score'), 1);
    }

    public function ratingsCount(): int
    {
        return (int) $this->ratings()->count();
    }

    public function getCoverUrlAttribute(): ?string
    {
        if (! $this->cover_image) {
            return null;
        }

        return route('media.public', ['path' => $this->cover_image]);
    }

    public function getPdfUrlAttribute(): ?string
    {
        if (! $this->file_path) {
            return null;
        }

        return route('media.public', ['path' => $this->file_path]);
    }
}
