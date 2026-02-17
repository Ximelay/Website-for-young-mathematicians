<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Review extends Model
{
    protected $fillable = [
        'content',
        'author_id',
        'reviewable_type',
        'reviewable_id',
        'is_approved',
        'is_published',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'is_published' => 'boolean',
    ];

    /**
     * Автор отзыва
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Объект, к которому относится отзыв (муниципальный или региональный этап)
     */
    public function reviewable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope для одобренных отзывов
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope для опубликованных отзывов
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
