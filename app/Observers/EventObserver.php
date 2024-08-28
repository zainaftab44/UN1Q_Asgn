<?php

namespace App\Observers;

use App\Exceptions\EventOverlappingException;
use App\Models\Event;
use App\Models\EventOccurrence;
use Carbon\Carbon;
use DB;

class EventObserver
{
    /**
     * Handle the Event "created" event. 
     * This will create occurrences for the event.
     */
    public function created(Event $event): void
    {
        if ($event->interval && $event->until_datetime) {
            switch ($event->interval) {
                case 'daily':
                    $func = 'addDay';
                    break;
                case 'monthly':
                    $func = 'addMonth';
                    break;
            }
            $start = Carbon::parse($event->start_datetime);
            $end = Carbon::parse($event->end_datetime);
            DB::beginTransaction();
            try {
                // for ($i = 0; $i < $recurrences; $i++) {
                while ($end < Carbon::parse($event->until_datetime)) {
                    if (!EventOccurrence::checkEventOverlapping($start->toDateTimeString(), $end->toDateTimeString())) {
                        throw new EventOverlappingException();
                    }
                    EventOccurrence::create([
                        'start_datetime' => $start->toDateTimeString(),
                        'end_datetime' => $end->toDateTimeString(),
                        'event_id' => $event->id,
                    ]);
                    $start = $start->$func();
                    $end = $end->$func();
                }
                DB::commit();
            } catch (\Exception $ex) {
                DB::rollBack();
                throw $ex;
            }
        }
    }

    /**
     * Handle the Event "updated" event.
     */
    public function updated(Event $event): void
    {
    }

    /**
     * Handle the Event "deleted" event.
     */
    public function deleted(Event $event): void
    {
        //
    }

    /**
     * Handle the Event "restored" event.
     */
    public function restored(Event $event): void
    {
        //
    }

    /**
     * Handle the Event "force deleted" event.
     */
    public function forceDeleted(Event $event): void
    {
        //
    }


}
