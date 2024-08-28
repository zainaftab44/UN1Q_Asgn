<?php

namespace App\Models;

use DB;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'summary',
        'start_datetime',
        'end_datetime',
        'interval',
        // 'occurrence',
        'until_datetime'
    ];

    public function occurrences()
    {
        return $this->hasMany(EventOccurrence::class);
    }

    public static function getEventsPaginated($page = 0, $per_page = 5)
    {
        $eventList = Event::all();
        $page_count = ceil($eventList->count() / $per_page);
        $page = min($page_count, $page);
        return ['events' => $eventList->forPage($page, $per_page), 'pages' => $page_count];
    }

    public static function createEvent($attributes)
    {
        try {
            DB::beginTransaction();
            $event = Event::create($attributes);
            DB::commit();
            return $event;
        } catch (Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
    }
}
