<?php

namespace Tests\Unit;

use Database\Factories\EventFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventCreationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */

    public function test_create_daily_event()
    {
        $event = EventFactory::new(['interval' => 'daily'])->raw();

        $created_resp = $this->postJson(route('create-event'), $event);
        $created_resp->assertStatus(200);
     
        $this->assertDatabaseCount('events', 1);
        $this->assertDatabaseHas('events', $created_resp->json());
        $this->assertDatabaseHas('events', ['interval' => 'daily']);
    }

    public function test_create_monthly_event()
    {
        $event = EventFactory::new(['interval' => 'monthly'])->raw();


        $created_resp = $this->postJson(route('create-event'), $event);
        $created_resp->assertStatus(200);
        $this->assertDatabaseCount('events', 1);
        $this->assertDatabaseHas('events', $created_resp->json());
        $this->assertDatabaseHas('events', ['interval' => 'monthly']);
    }


    public function test_create_multiple_non_overlapping_events()
    {
        $event = EventFactory::new([
            'start_datetime' => now()->addDay()->toDateTimeString(),
            'end_datetime' => now()->addDay()->addHour()->toDateTimeString(),
            'until_datetime' => now()->addDays(10)->addHour()->toDateTimeString(),
        ])->raw();
        $created_resp = $this->postJson(route('create-event'), $event);
        $created_resp->assertJsonFragment(['title' => $event['title']]);
        $created_resp->assertStatus(200);

        $event1 = EventFactory::new([
            'start_datetime' => now()->addDay()->addHours(2)->toDateTimeString(),
            'end_datetime' => now()->addDay()->addHours(3)->toDateTimeString(),
            'until_datetime' => now()->addDays(10)->addHours(4)->toDateTimeString(),
        ])->raw();
        $created_resp1 = $this->postJson(route('create-event'), $event1);
        $created_resp1->assertJsonFragment(['title' => $event1['title']]);
        $created_resp1->assertStatus(200);

        $this->assertDatabaseHas('events', $created_resp->json());
        $this->assertDatabaseHas('events', $created_resp1->json());
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


    public function test_event_creation_without_summary(): void
    {
        $event = EventFactory::new(['summary' => null])->raw();
        $response = $this->postJson(route('create-event'), $event);
        $response->assertJsonFragment(['summary' => null]);
        $this->assertDatabaseHas('events', ['id' => $response['id']]);
    }

}
