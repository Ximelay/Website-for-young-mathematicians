<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:organizer'])->except('index');
    }

    public function index()
    {
        $events = Event::orderBy('start_date')->get();
        return view('calendar', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules());

        Event::create([
            ...$validated,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('calendar')->with('success', 'Событие успешно создано!');
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate($this->validationRules());

        $event->update($validated);

        return redirect()->route('calendar')->with('success', 'Событие успешно обновлено!');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('calendar')->with('success', 'Событие успешно удалено!');
    }

    private function validationRules(): array
    {
        return [
            'title'           => 'required|string|max:255',
            'description'     => 'required|string',
            'start_date'      => 'required|date',
            'end_date'        => 'required|date|after:start_date',
            'location'        => 'required|string|max:255',
            'type'            => 'required|in:municipal_stage,regional_stage,meeting,deadline,other',
            'municipality_id' => 'nullable|exists:municipalities,id',
        ];
    }
}
