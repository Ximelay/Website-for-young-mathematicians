<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class MunicipalStage extends Model
{
    protected $fillable = [
        'municipality_id',
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
    ];

    /**
     * Муниципалитет этапа
     */
    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class);
    }

    /**
     * Команды участвующие в этапе
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'municipal_stage_teams')
            ->using(MunicipalStageTeam::class)
            ->withPivot('score', 'rank', 'qualified_for_regional')
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
}
