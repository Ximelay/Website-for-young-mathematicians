<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MunicipalStageTeam extends Pivot
{
    protected $table = 'municipal_stage_teams';

    protected $fillable = [
        'municipal_stage_id',
        'team_id',
        'score',
        'rank',
        'qualified_for_regional',
    ];

    protected $casts = [
        'score' => 'integer',
        'rank' => 'integer',
        'qualified_for_regional' => 'boolean',
    ];

    public $timestamps = true;

    /**
     * Муниципальный этап
     */
    public function municipalStage(): BelongsTo
    {
        return $this->belongsTo(MunicipalStage::class);
    }

    /**
     * Команда
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
