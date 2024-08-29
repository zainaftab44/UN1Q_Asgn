<?php

namespace Tests\Unit;

use Database\Factories\EventFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventsTest extends TestCase
{
    use RefreshDatabase;
    public function test_display_event(): void
    {
        $event = EventFactory::new()->raw();
        $created_resp = $this->postJson(route('create-event'), $event);

        $this->assertDatabaseHas('events', $created_resp->json());

        $response = $this->getJson(route('detail-event', $created_resp['id']));
        $response->assertJsonFragment(['title' => $event['title']]);
    }


    public function test_delete_event(): void
    {
        $event = EventFactory::new()->raw();
        $created_resp = $this->postJson(route('create-event'), $event);

        $this->assertDatabaseHas('events', $created_resp->json());

        $this->deleteJson(route('delete-event', $created_resp['id']));

        $this->assertDatabaseMissing('events', ['id' => $created_resp['id']]);
    }


    public function test_update_event_title(): void
    {
        $event = EventFactory::new()->raw();
        $created_resp = $this->postJson(route('create-event'), $event);

        $this->assertDatabaseHas('events', $created_resp->json());

        $update_data = [
            'title' => fake()->words(asText: true),
        ];

        $update_resp = $this->postJson(route('update-event', $created_resp['id']), $update_data);
        $update_resp->assertJson(['message' => 'Event updated']);

        $response = $this->getJson(route('detail-event', $created_resp['id']));
        $response->assertJsonFragment($update_data);
    }


    public function test_update_event_summary_only(): void
    {
        $event = EventFactory::new()->raw();
        $created_resp = $this->postJson(route('create-event'), $event);

        $this->assertDatabaseHas('events', $created_resp->json());

        $update_data = [
            'summary' => fake()->sentences(asText: true),
        ];

        $update_resp = $this->postJson(route('update-event', $created_resp['id']), $update_data);
        $update_resp->assertJson(['message' => 'Event updated']);

        $response = $this->getJson(route('detail-event', $created_resp['id']));
        $this->assertEquals($created_resp->json()['title'], $response->json()['title']);
        $this->assertNotEquals($created_resp->json()['summary'], $response->json()['summary']);
        $this->assertEquals($update_data['summary'], $response->json()['summary']);
        $response->assertJsonFragment($update_data);
    }



    public function test_get_events_list()
    {
        $event = EventFactory::new()->raw();
        $created_resp = $this->postJson(route('create-event'), $event);

        $this->assertDatabaseHas('events', ['id' => $created_resp['id']]);

        $events_list = $this->getJson(route('index-events'));
        $events_list->assertJsonFragment(['title' => $event['title']]);
    }

}
