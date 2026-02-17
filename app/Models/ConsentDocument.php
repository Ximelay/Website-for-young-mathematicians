<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsentDocument extends Model
{
    protected $fillable = [
        'user_id',
        'file_path',
        'file_name',
        'uploaded_at',
        'is_verified',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
        'is_verified' => 'boolean',
    ];

    /**
     * Пользователь, которому принадлежит документ
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope для верифицированных документов
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Scope для неверифицированных документов
     */
    public function scopeUnverified($query)
    {
        return $query->where('is_verified', false);
    }
}
