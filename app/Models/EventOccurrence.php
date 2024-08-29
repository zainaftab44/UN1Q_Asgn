<?php

namespace App\Models;

use App\Exceptions\EventOverlappingException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventOccurrence extends Model
{
    use HasFactory;
    protected $fillable = [
        'start_datetime',
        'end_datetime',
        'event_id',
    ];

    public static function checkEventOverlapping($start, $end): bool
    {
        return EventOccurrence::whereBetween('start_datetime', [$start, $end])
            ->orWhereBetween('end_datetime', [$start, $end])
            ->orWhereRaw('? >= start_datetime AND ? <= end_datetime', [$start, $start])
            ->get()
            ->first() === null;
    }
    public static function createEventOccurrence($start, $end, $event_id)
    {
        if (!EventOccurrence::checkEventOverlapping($start->toDateTimeString(), $end->toDateTimeString())) {
            throw new EventOverlappingException();
        }
        EventOccurrence::create([
            'start_datetime' => $start->toDateTimeString(),
            'end_datetime' => $end->toDateTimeString(),
            'event_id' => $event_id,
        ]);
    }
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
