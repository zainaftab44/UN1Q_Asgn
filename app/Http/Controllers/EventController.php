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
    public function event_home()
    {
        return view('events.index')->with('list', Event::getEventsPaginated());
    }

    public function event_new()
    {
        return view('events.new');
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
