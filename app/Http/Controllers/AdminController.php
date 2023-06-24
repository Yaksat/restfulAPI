<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Auth;

class AdminController extends Controller
{
    public function index()
    {
        $events = Event::all();

        $user = Auth::user();

        $myEvents = Event::whereHas('members', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

//        $myEvents = $events->filter(function ($event) use ($user) {
//            return $event->creator_id == $user->id;
//        });

        return view('main', compact('events', 'myEvents'));
    }
}
