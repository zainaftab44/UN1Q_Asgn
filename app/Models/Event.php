<?php

namespace App\Models;

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
        'occurrence',
    ];

    public function occurrences()
    {
        return $this->hasMany(EventOccurrence::class);
    }
}
