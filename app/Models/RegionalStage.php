<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class RegionalStage extends Model
{
    protected $fillable = [
        'year',
        'event_date',
        'event_time',
        'venue',
        'venue_address',
        'contact_info',
        'status',
        'results',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'event_time' => 'datetime',
        'year' => 'integer',
    ];

    /**
     * Команды участвующие в этапе
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'regional_stage_teams')
            ->using(RegionalStageTeam::class)
            ->withPivot('score', 'rank')
            ->withTimestamps();
    }

    /**
     * Отзывы об этапе
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    /**
     * Scope для завершенных этапов
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope для текущих этапов
     */
    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing');
    }

    /**
     * Scope для запланированных этапов
     */
    public function scopePlanned($query)
    {
        return $query->where('status', 'planned');
    }

    /**
     * Scope для определенного года
     */
    public function scopeForYear($query, int $year)
    {
        return $query->where('year', $year);
    }
}
