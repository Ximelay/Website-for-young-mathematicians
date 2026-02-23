<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:organizer')->except('index');
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
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string|max:255',
            'type' => 'required|in:municipal_stage,regional_stage,meeting,deadline,other',
            'municipality_id' => 'nullable|exists:municipalities,id',
        ]);

        $event = Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'type' => $request->type,
            'municipality_id' => $request->municipality_id,
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
        // Проверка, что пользователь является создателем события
        if ($event->created_by !== auth()->id()) {
            abort(403, 'Вы не имеете права редактировать это событие');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string|max:255',
            'type' => 'required|in:municipal_stage,regional_stage,meeting,deadline,other',
            'municipality_id' => 'nullable|exists:municipalities,id',
        ]);

        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'type' => $request->type,
            'municipality_id' => $request->municipality_id,
        ]);

        return redirect()->route('calendar')->with('success', 'Событие успешно обновлено!');
    }

    public function destroy(Event $event)
    {
        // Проверка, что пользователь является создателем события
        if ($event->created_by !== auth()->id()) {
            abort(403, 'Вы не имеете права удалять это событие');
        }

        $event->delete();
        return redirect()->route('calendar')->with('success', 'Событие успешно удалено!');
    }
}
