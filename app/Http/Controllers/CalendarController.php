<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        $upcoming = Event::where('start_date', '>=', now())
            ->orderBy('start_date')
            ->get();

        $past = Event::where('start_date', '<', now())
            ->orderByDesc('start_date')
            ->take(10)
            ->get();

        return view('calendar', compact('upcoming', 'past'));
    }
}
