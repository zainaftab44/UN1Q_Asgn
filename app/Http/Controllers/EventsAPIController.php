<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
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
            return response()->json(Event::createEvent($request->all()), 200, ['Content-Type' => 'application/json']);
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
    // UpdateEventRequest $request,
    public function update_event(Event $event)
    {
        try {
            $request = UpdateEventRequest::capture();
            $res = $event->update($request->only(['title', 'summary']));
            return response()->json(['message' => $res ? 'Event updated' : 'Failed to update event'], $res ? 200 : 400);
        } catch (Exception $ex) {
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

}
