<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'type',
        'municipality_id',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Муниципалитет события
     */
    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class);
    }

    /**
     * Создатель события
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope для получения предстоящих событий
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now())->orderBy('start_date');
    }
    /**
     * Возвращает название типа события
     */
    public function getTypeName()
    {
        $types = [
            'municipal_stage' => 'Муниципальный этап',
            'regional_stage' => 'Региональный этап',
            'meeting' => 'Внутриколледжный этап',
            'school' => 'Внутришкольный этап',
            'other' => 'Другое'
        ];

        return $types[$this->type] ?? 'Неизвестный тип';
    }
}
