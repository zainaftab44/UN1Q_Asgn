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
        'until_datetime'
    ];

    public function occurrences()
    {
        return $this->hasMany(EventOccurrence::class);
    }

    public static function getEventsPaginated($page = 0, $per_page = 5)
    {
        $eventList = Event::paginate($per_page, ['*'], 'page', $page);
        return ['events' => $eventList->items(), 'pages' => $eventList->lastPage()];
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
