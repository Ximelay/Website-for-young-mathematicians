<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Material extends Model
{
    protected $fillable = [
        'title',
        'description',
        'type',
        'year',
        'file_path',
        'video_url',
        'uploaded_by',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'year' => 'integer',
    ];

    /**
     * Пользователь, который загрузил материал
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Scope для опубликованных материалов
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope для материалов определенного типа
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope для материалов определенного года
     */
    public function scopeForYear($query, int $year)
    {
        return $query->where('year', $year);
    }
}
