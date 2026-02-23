<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('start_date')->get();
        return view('calendar', compact('events'));
    }
}
