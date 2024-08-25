<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $page = $request->get('page', 0);
            return response()->json(Event::getEventsPaginated($page), 200);
        } catch (Exception $ex) {
            return response()->json($ex);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(EventRequest $request)
    {
        try {
            return response()->json(Event::createEvent($request->all()), 200);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], $ex->getCode());
        }
    }

    public function detail(Event $event)
    {
        try {
            return response()->json($event, 200);
        } catch (\Throwable $th) {
            return response()->json(["error" => "Event not found"], 404);
        }
    }

    public function update(UpdateEventRequest $request)
    {
        try {
            $event = Event::findOrFail($request->get('id'))->first();
            $event->update($request->only(['title', 'summary']));
            return response()->json($event, 200);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], $ex->getCode());
        }
    }

    public function delete(Event $event)
    {
        $event->delete();
        return response(null, 200);
    }

    public function home()
    {
        return view('events.index')->with('list', Event::getEventsPaginated());
    }


    public function new()
    {
        return view('events.new');
    }
    public function createNew(EventRequest $request)
    {
        try {
            Event::createEvent($request->all());
            return redirect(route('index'));
        } catch (Exception $ex) {
            return redirect()->back()->withErrors(["error" => $ex->getMessage()])->withInput();
        }
    }

    public function event_detail(Event $event)
    {
        try {
            return view('events.detail', compact('event'));
        } catch (Exception $ex) {
            return redirect()->back()->withErrors(["error" => $ex->getMessage()]);
        }
    }

}
