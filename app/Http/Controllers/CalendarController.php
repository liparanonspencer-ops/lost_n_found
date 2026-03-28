<?php
namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        return view('calendar');
    }

    public function getEvents()
    {
        $events = Event::all()->map(function ($event) {
            return [
                'title' => $event->title,
                'start' => $event->start,
                'end'   => $event->end,
            ];
        });

        return response()->json($events);
    }
}