<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use DB;
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
        $page = $request->get('page', 0);
        $eventList = Event::all();
        try {
            $page_count = ceil($eventList->count() / 5);
            $page = min($page_count, $page);
            return response()->json(['events' => $eventList->forPage($page, 5), 'pages' => $page_count], 200);
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
            DB::beginTransaction();
            $event = Event::create($request->all());
            DB::commit();
            return response()->json($event, 200);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json(['error' => $ex->getMessage()], $ex->getCode());
        }
    }

    public function detail($event_id)
    {
        try {
            return response()->json(Event::findOrFail($event_id)->first(), 200);
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

    public function delete($event_id)
    {
        Event::destroy($event_id);
        return response(null, 200);
    }
}
