<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Auth;
use Illuminate\Http\Request;
use Validator;

class EventController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'text' => 'required|string',
        ]);

        if($validator->fails()){

            return Response(['error' => $validator->errors(), 'result' => null],401);
        }

        $user = Auth::user();

        $event = Event::query()->create([
            'title' => $request['title'],
            'text' => $request['text'],
            'creator_id' => $user->id,
        ]);

        $event->members()->attach($user);

        return Response(['error' => null, 'result' => ['id' => $event->id, 'title' => $event->title, 'text' => $event->text]],200);
    }

    public function getEvents()
    {
        $events = Event::all();

        return Response(['error' => null, 'result' => $events],200);
    }

    public function participate(Event $event)
    {
        $user = Auth::user();

        $event->members()->syncWithoutDetaching($user);

        return Response(['error' => null, 'result' => 'success'],200);
    }

    public function removeParticipant(Event $event)
    {
        $user = Auth::user();

        $event->members()->detach($user);

        return response()->json(['error' => null, 'result' => 'success'], 200);
    }

    public function delete(Event $event)
    {
        $user = Auth::user();

        if ($user->id === $event->creator_id) {
            $event->delete();
            return response()->json(['error' => null, 'result' => 'success'], 200);
        } else {
            return response()->json(['error' => 'You are not creator event for delete this event.'], 403);
        }
    }

}
