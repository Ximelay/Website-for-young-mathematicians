<?php
namespace App\Http\Controllers;
use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
        $upcomingEvents = Event::upcoming()->get();
        return view('index', compact('upcomingEvents'));
    }
}
