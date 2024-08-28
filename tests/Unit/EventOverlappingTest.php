<?php

namespace Tests\Unit;

use Database\Factories\EventFactory;
use Tests\TestCase;

class EventOverlappingTest extends TestCase
{
    /**
     * A basic unit test example.
     */
     public function test_fail_on_overlapping_events_same_time()
     {
         $start = now()->addDay()->toDateTimeString();
         $end = now()->addDay()->addHours(2)->toDateTimeString();
         $event = EventFactory::new([
             'start_datetime' => $start,
             'end_datetime' => $end,
         ])->raw();
         $this->postJson(route('create-event'), $event)->assertStatus(200);
 
         $event1 = EventFactory::new([
             'start_datetime' => $start,
             'end_datetime' => $end,
         ])->raw();
         $this->postJson(route('create-event'), $event1)->assertStatus(403);
 
         $this->assertDatabaseCount('events', 1);
 
     }
 
     public function test_fail_on_overlapping_events_end_time_overlap()
     {
 
         $event = EventFactory::new([
             'start_datetime' => now()->addDay()->toDateTimeString(),
             'end_datetime' => now()->addDay()->addHours(2)->toDateTimeString(),
         ])->raw();
         $this->postJson(route('create-event'), $event)->assertStatus(200);
 
         $event1 = EventFactory::new([
             'start_datetime' => now()->addDay()->subHour()->toDateTimeString(),
             'end_datetime' => now()->addDay()->addHour()->toDateTimeString(),
         ])->raw();
         $this->postJson(route('create-event'), $event1)->assertStatus(403);
 
         $this->assertDatabaseCount('events', 1);
 
     }
 
 
     public function test_fail_on_overlapping_events_overlap_start_time()
     {
 
         $event = EventFactory::new([
             'start_datetime' => now()->addDay()->toDateTimeString(),
             'end_datetime' => now()->addDay()->addHours(2)->toDateTimeString(),
         ])->raw();
 
         $this->postJson(route('create-event'), $event)->assertStatus(200);
 
         $event1 = EventFactory::new([
             'start_datetime' => now()->addDay()->addHour()->toDateTimeString(),
             'end_datetime' => now()->addDay()->addHours(3)->toDateTimeString(),
         ])->raw();
 
         $this->postJson(route('create-event'), $event1)->assertStatus(403);
 
         $this->assertDatabaseCount('events', 1);
 
     }
}
