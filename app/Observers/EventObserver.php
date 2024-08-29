<?php

namespace App\Observers;

use App\Exceptions\EventOverlappingException;
use App\Models\Event;
use App\Models\EventOccurrence;
use Carbon\Carbon;
use DB;
use Exception;

class EventObserver
{
    /**
     * Handle the Event "created" event. 
     * This will create occurrences for the event.
     */
    public function created(Event $event): void
    {
        $this->save($event);
    }

    /**
     * Handle the Event "updated" event.
     */
    public function updated(Event $event): void
    {
        $intersect = array_intersect(array_keys($event->getDirty()), ['start_datetime', 'end_datetime', 'until_datetime']);
        if (count($intersect) == 0)
            return;
        try {
            DB::beginTransaction();
            $occurrences = explode(',', $event->occurrences()->implode('id', ','));
            if (count($occurrences) > 0)
                DB::table('event_occurrences')->whereIn('id', $occurrences)->delete();
            $this->save($event);
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
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


    private function save(Event $event)
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
            $until = Carbon::parse($event->until_datetime);
            DB::beginTransaction();
            try {
                while ($end < $until) {
                    EventOccurrence::createEventOccurrence($start, $end, $event->id);
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


}
