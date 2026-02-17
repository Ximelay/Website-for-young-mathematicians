<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RegionalStageTeam extends Pivot
{
    protected $table = 'regional_stage_teams';

    protected $fillable = [
        'regional_stage_id',
        'team_id',
        'score',
        'rank',
    ];

    protected $casts = [
        'score' => 'integer',
        'rank' => 'integer',
    ];

    public $timestamps = true;

    /**
     * Региональный этап
     */
    public function regionalStage(): BelongsTo
    {
        return $this->belongsTo(RegionalStage::class);
    }

    /**
     * Команда
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
