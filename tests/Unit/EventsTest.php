<?php

namespace Tests\Unit;

use Database\Factories\EventFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventsTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_daily_event()
    {
        $event = EventFactory::new(['interval' => 'daily'])->raw();

        $this->postJson(route('create-event'), $event)->assertStatus(200);
        $this->assertDatabaseHas('events', $event);
    }

    public function test_create_monthly_event()
    {
        $event = EventFactory::new(['interval' => 'monthly'])->raw();

        $this->postJson(route('create-event'), $event)->assertStatus(200);
        $this->assertDatabaseHas('events', $event);

    }

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
    public function test_fail_invalid_interval_events()
    {
        $event = EventFactory::new(['interval' => 'weekly'])->raw();

        $this->postJson(route('create-event'), $event)->assertStatus(422);
        $this->assertDatabaseEmpty('events');
    }

    public function test_failure_with_no_title(): void
    {
        $event = EventFactory::new(['title' => null])->raw();

        $this->postJson(route('create-event'), $event)->assertStatus(422);
        $this->assertDatabaseMissing('events', $event);
    }

    public function test_display_event(): void
    {

        $event = EventFactory::new()->raw();

        $created_resp = $this->postJson(route('create-event'), $event);
        $created_resp->assertStatus(200);

        $this->assertDatabaseCount('events', 1);
        $this->assertDatabaseHas('events', $event);


        $this->getJson(route('detail-event', $created_resp['id']))->assertJson(['title' => $event['title']]);
    }


    public function test_create_multiple_non_overlapping_events()
    {

        $event = EventFactory::new([
            'start_datetime' => now()->addDay()->toDateTimeString(),
            'end_datetime' => now()->addDay()->addHour()->toDateTimeString(),
        ])->raw();
        $this->postJson(route('create-event'), $event)->assertStatus(200);

        $event1 = EventFactory::new([
            'start_datetime' => now()->addDay()->addHours(2)->toDateTimeString(),
            'end_datetime' => now()->addDay()->addHours(3)->toDateTimeString(),
        ])->raw();
        $this->postJson(route('create-event'), $event1)->assertStatus(200);


        $this->assertDatabaseCount('events', 2);
    }


    public function test_delete_event(): void
    {

        $event = EventFactory::new()->raw();
        $created_resp = $this->postJson(route('create-event'), $event);
        $created_resp->assertStatus(200);

        $this->assertDatabaseCount('events', 1);
        $this->assertDatabaseHas('events', $event);


        $this->deleteJson(route('delete-event', $created_resp['id']))->assertStatus(200);

        $this->assertDatabaseEmpty('events');

    }


    public function test_update_event_title(): void
    {
        $event = EventFactory::new()->raw();

        $created_resp = $this->postJson(route('create-event'), $event);
        $created_resp->assertStatus(200);

        $this->assertDatabaseCount('events', 1);
        $this->assertDatabaseHas('events', $event);


        $update_resp = $this->putJson(route('update-event', $created_resp['id']), [
            'title' => fake()->words(asText: true),
        ]);
        $update_resp->assertStatus(200);
    }



    public function test_get_events_list()
    {
        $event = EventFactory::new()->raw();

        $this->postJson(route('create-event'), $event)->assertStatus(200);

        $this->assertDatabaseHas('events', $event);


        $this->getJson(route('index-events'))->assertJson(['pages' => 1])->assertJsonFragment(['title' => $event['title']]);
    }

}
