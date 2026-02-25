<?php

namespace App\Http\Controllers;

use App\Models\MunicipalStage;
use App\Models\Municipality;
use App\Models\RegionalStage;
use App\Models\Team;
use Illuminate\Http\Request;

class StageController extends Controller
{
    // ─── ОБЩИЙ СПИСОК ──────────────────────────────────────────────────────────

    public function index()
    {
        $municipalStages = MunicipalStage::with('municipality')
            ->withCount('teams')
            ->orderByDesc('event_date')
            ->get();

        $regionalStages = RegionalStage::withCount('teams')
            ->orderByDesc('event_date')
            ->get();

        return view('stages.index', compact('municipalStages', 'regionalStages'));
    }

    // ─── МУНИЦИПАЛЬНЫЙ ЭТАП ────────────────────────────────────────────────────

    public function municipalCreate()
    {
        $this->authorizeOrganizer();
        $municipalities = Municipality::orderBy('name')->get();
        return view('stages.municipal.create', compact('municipalities'));
    }

    public function municipalStore(Request $request)
    {
        $this->authorizeOrganizer();

        $validated = $request->validate([
            'municipality_id' => 'required|exists:municipalities,id',
            'event_date'      => 'required|date',
            'event_time'      => 'nullable|date_format:H:i',
            'venue'           => 'required|string|max:255',
            'venue_address'   => 'nullable|string|max:255',
            'contact_info'    => 'nullable|string|max:1000',
            'status'          => 'required|in:planned,ongoing,completed',
        ]);

        MunicipalStage::create($validated);

        return redirect()->route('stages.index')
            ->with('success', '✅ Муниципальный этап создан!');
    }

    public function municipalShow(MunicipalStage $stage)
    {
        $stage->load('municipality', 'teams.members', 'teams.organization');

        // Команды этого муниципалитета, ещё не добавленные на этап
        $availableTeams = Team::where('municipality_id', $stage->municipality_id)
            ->where('is_active', true)
            ->whereNotIn('id', $stage->teams->pluck('id'))
            ->orderBy('name')
            ->get();

        return view('stages.municipal.show', compact('stage', 'availableTeams'));
    }

    public function municipalEdit(MunicipalStage $stage)
    {
        $this->authorizeOrganizer();
        $municipalities = Municipality::orderBy('name')->get();
        return view('stages.municipal.edit', compact('stage', 'municipalities'));
    }

    public function municipalUpdate(Request $request, MunicipalStage $stage)
    {
        $this->authorizeOrganizer();

        $validated = $request->validate([
            'municipality_id' => 'required|exists:municipalities,id',
            'event_date'      => 'required|date',
            'event_time'      => 'nullable|date_format:H:i',
            'venue'           => 'required|string|max:255',
            'venue_address'   => 'nullable|string|max:255',
            'contact_info'    => 'nullable|string|max:1000',
            'status'          => 'required|in:planned,ongoing,completed',
            'results'         => 'nullable|string',
        ]);

        $stage->update($validated);

        return redirect()->route('stages.municipal.show', $stage)
            ->with('success', '✅ Этап обновлён!');
    }

    public function municipalDestroy(MunicipalStage $stage)
    {
        $this->authorizeOrganizer();
        $stage->delete();
        return redirect()->route('stages.index')
            ->with('success', '🗑️ Муниципальный этап удалён');
    }

    /**
     * Добавить команду на муниципальный этап
     */
    public function municipalAddTeam(Request $request, MunicipalStage $stage)
    {
        $this->authorizeOrganizer();

        $validated = $request->validate([
            'team_id' => 'required|exists:teams,id',
        ]);

        // Не добавлять дважды
        if ($stage->teams()->where('team_id', $validated['team_id'])->exists()) {
            return back()->with('error', '❌ Команда уже добавлена на этот этап');
        }

        $stage->teams()->attach($validated['team_id']);

        return back()->with('success', '✅ Команда добавлена на этап');
    }

    /**
     * Обновить результаты команды на муниципальном этапе
     */
    public function municipalUpdateTeam(Request $request, MunicipalStage $stage, Team $team)
    {
        $this->authorizeOrganizer();

        $validated = $request->validate([
            'score'                  => 'nullable|integer|min:0',
            'rank'                   => 'nullable|integer|min:1',
            'qualified_for_regional' => 'boolean',
        ]);

        $validated['qualified_for_regional'] = $request->boolean('qualified_for_regional');

        $stage->teams()->updateExistingPivot($team->id, $validated);

        return back()->with('success', '✅ Результат обновлён');
    }

    /**
     * Убрать команду с муниципального этапа
     */
    public function municipalRemoveTeam(MunicipalStage $stage, Team $team)
    {
        $this->authorizeOrganizer();
        $stage->teams()->detach($team->id);
        return back()->with('success', '✅ Команда убрана с этапа');
    }

    // ─── РЕГИОНАЛЬНЫЙ ЭТАП ─────────────────────────────────────────────────────

    public function regionalCreate()
    {
        $this->authorizeOrganizer();
        return view('stages.regional.create');
    }

    public function regionalStore(Request $request)
    {
        $this->authorizeOrganizer();

        $validated = $request->validate([
            'year'          => 'required|integer|min:2000|max:2100',
            'event_date'    => 'required|date',
            'event_time'    => 'nullable|date_format:H:i',
            'venue'         => 'required|string|max:255',
            'venue_address' => 'nullable|string|max:255',
            'contact_info'  => 'nullable|string|max:1000',
            'status'        => 'required|in:planned,ongoing,completed',
        ]);

        RegionalStage::create($validated);

        return redirect()->route('stages.index')
            ->with('success', '✅ Региональный этап создан!');
    }

    public function regionalShow(RegionalStage $stage)
    {
        $stage->load('teams.members', 'teams.municipality', 'teams.organization');

        // Команды с флагом qualified_for_regional, ещё не на этом этапе
        $availableTeams = Team::where('is_active', true)
            ->whereNotIn('id', $stage->teams->pluck('id'))
            ->whereHas('municipalStages', fn($q) =>
                $q->where('qualified_for_regional', true)
            )
            ->orderBy('name')
            ->get();

        return view('stages.regional.show', compact('stage', 'availableTeams'));
    }

    public function regionalEdit(RegionalStage $stage)
    {
        $this->authorizeOrganizer();
        return view('stages.regional.edit', compact('stage'));
    }

    public function regionalUpdate(Request $request, RegionalStage $stage)
    {
        $this->authorizeOrganizer();

        $validated = $request->validate([
            'year'          => 'required|integer|min:2000|max:2100',
            'event_date'    => 'required|date',
            'event_time'    => 'nullable|date_format:H:i',
            'venue'         => 'required|string|max:255',
            'venue_address' => 'nullable|string|max:255',
            'contact_info'  => 'nullable|string|max:1000',
            'status'        => 'required|in:planned,ongoing,completed',
            'results'       => 'nullable|string',
        ]);

        $stage->update($validated);

        return redirect()->route('stages.regional.show', $stage)
            ->with('success', '✅ Этап обновлён!');
    }

    public function regionalDestroy(RegionalStage $stage)
    {
        $this->authorizeOrganizer();
        $stage->delete();
        return redirect()->route('stages.index')
            ->with('success', '🗑️ Региональный этап удалён');
    }

    /**
     * Добавить команду на региональный этап
     */
    public function regionalAddTeam(Request $request, RegionalStage $stage)
    {
        $this->authorizeOrganizer();

        $validated = $request->validate([
            'team_id' => 'required|exists:teams,id',
        ]);

        if ($stage->teams()->where('team_id', $validated['team_id'])->exists()) {
            return back()->with('error', '❌ Команда уже добавлена на этот этап');
        }

        $stage->teams()->attach($validated['team_id']);

        return back()->with('success', '✅ Команда добавлена на этап');
    }

    /**
     * Обновить результаты команды на региональном этапе
     */
    public function regionalUpdateTeam(Request $request, RegionalStage $stage, Team $team)
    {
        $this->authorizeOrganizer();

        $validated = $request->validate([
            'score' => 'nullable|integer|min:0',
            'rank'  => 'nullable|integer|min:1',
        ]);

        $stage->teams()->updateExistingPivot($team->id, $validated);

        return back()->with('success', '✅ Результат обновлён');
    }

    /**
     * Убрать команду с регионального этапа
     */
    public function regionalRemoveTeam(RegionalStage $stage, Team $team)
    {
        $this->authorizeOrganizer();
        $stage->teams()->detach($team->id);
        return back()->with('success', '✅ Команда убрана с этапа');
    }

    // ─── HELPERS ───────────────────────────────────────────────────────────────

    private function authorizeOrganizer(): void
    {
        if (!auth()->user()->hasRole('organizer')) {
            abort(403, 'Только организатор может управлять этапами');
        }
    }
}
