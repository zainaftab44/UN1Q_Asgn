<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\Request;

class EventsAPIController
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
    public function create_event(EventRequest $request)
    {
        try {
            return response()->json(Event::createEvent($request->all()), 200);
        } catch (Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], $ex->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function detail_event(Event $event)
    {
        try {
            return response()->json($event, 200);
        } catch (\Throwable $th) {
            return response()->json(["error" => "Event not found"], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_event(UpdateEventRequest $request, string $event_id)
    {
        try {
            DB::beginTransaction();
            $event = Event::findOrFail($event_id);
            foreach ($request->all() as $key => $attr) {
                if (in_array($key, array_keys($event->toArray()))) {
                    if (in_array($key, ['start_datetime', 'end_datetime', 'until_datetime']))
                        $attr = Carbon::parse($attr)->toDateTimeString();
                    $event->$key = $attr;
                }
            }
            $res = $event->update();
            DB::commit();
            return response()->json(['message' => $res ? 'Event updated' : 'Failed to update event'], $res ? 200 : 400);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json(['error' => $ex->getMessage()], $ex->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete_event(Event $event)
    {
        $event->delete();
        return response()->json(["message" => "Event deleted successfully"], 200);
    }

    public function search_event(Request $request)
    {
        try {
            $search_term = $request->all()['search_term'];
            $events_list = Event::whereLike('title', '%' . $search_term . '%')
                ->orWhereLike('summary', '%' . $search_term . '%')
                ->groupBy(['id'])->get();
            return response()->json(['events' => $events_list ?? []], 200);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], $ex->getCode());
        }
    }
}
