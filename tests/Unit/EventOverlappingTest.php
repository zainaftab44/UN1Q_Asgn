<?php

namespace Tests\Unit;

use App\Exceptions\EventOverlappingException;
use Database\Factories\EventFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventOverlappingTest extends TestCase
{
    use RefreshDatabase;

    public function test_fail_on_overlapping_events_same_time()
    {
        $start = now()->addDay()->toDateTimeString();
        $end = now()->addDay()->addHours(2)->toDateTimeString();
        $event = EventFactory::new([
            'start_datetime' => $start,
            'end_datetime' => $end,
        ])->raw();
        $created_resp = $this->postJson(route('create-event'), $event);
        $created_resp->assertStatus(200);

        $event1 = EventFactory::new([
            'start_datetime' => $start,
            'end_datetime' => $end,
        ])->raw();
        $failed_resp = $this->postJson(route('create-event'), $event1);
        $failed_resp->assertStatus(403);
        $failed_resp->assertJson(['error' => (new EventOverlappingException())->getMessage()]);

        $this->assertDatabaseHas('events', $created_resp->json());
        $this->assertDatabaseCount('events', 1);
    }

    public function test_fail_on_overlapping_events_end_time_overlap()
    {

        $event = EventFactory::new([
            'start_datetime' => now()->addDay()->toDateTimeString(),
            'end_datetime' => now()->addDay()->addHours(2)->toDateTimeString(),
        ])->raw();
        $created_resp = $this->postJson(route('create-event'), $event);
        $created_resp->assertStatus(200);

        $event1 = EventFactory::new([
            'start_datetime' => now()->addDay()->subHour()->toDateTimeString(),
            'end_datetime' => now()->addDay()->addHour()->toDateTimeString(),
        ])->raw();

        $failed_resp = $this->postJson(route('create-event'), $event1);
        $failed_resp->assertStatus(403);
        $failed_resp->assertJson(['error' => (new EventOverlappingException())->getMessage()]);

        $this->assertDatabaseCount('events', 1);
        $this->assertDatabaseHas('events', $created_resp->json());
    }


    public function test_fail_on_overlapping_events_overlap_start_time()
    {
        $event = EventFactory::new([
            'start_datetime' => now()->addDay()->toDateTimeString(),
            'end_datetime' => now()->addDay()->addHours(2)->toDateTimeString(),
        ])->raw();
        $created_resp = $this->postJson(route('create-event'), $event);
        $created_resp->assertStatus(200);

        $event1 = EventFactory::new([
            'start_datetime' => now()->addDay()->addHour()->toDateTimeString(),
            'end_datetime' => now()->addDay()->addHours(3)->toDateTimeString(),
        ])->raw();

        $failed_resp = $this->postJson(route('create-event'), $event1);
        $failed_resp->assertStatus(403);
        $failed_resp->assertJson(['error' => (new EventOverlappingException())->getMessage()]);

        $this->assertDatabaseCount('events', 1);
        $this->assertDatabaseHas('events', $created_resp->json());
    }
}
