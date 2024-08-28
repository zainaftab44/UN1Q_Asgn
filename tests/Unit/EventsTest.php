<?php

namespace Tests\Unit;

use Database\Factories\EventFactory;
use Tests\TestCase;

class EventsTest extends TestCase
{
    public function test_display_event(): void
    {
        $event = EventFactory::new()->raw();
        $created_resp = $this->postJson(route('create-event'), $event);
        $created_resp->assertStatus(200);

        $this->assertDatabaseHas('events', ['id' => $created_resp['id']]);
        $this->getJson(route('detail-event', $created_resp['id']))->assertJson(['title' => $event['title']]);
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


        $update_resp = $this->postJson(route('update-event', $created_resp['id']), [
            'title' => fake()->words(asText: true),
        ]);
        $update_resp->assertJson(['message' => 'Event updated'])->assertStatus(200);
    }



    public function test_get_events_list()
    {
        $event = EventFactory::new()->raw();

        $this->postJson(route('create-event'), $event)->assertStatus(200);

        $this->assertDatabaseHas('events', $event);


        $this->getJson(route('index-events'))->assertJsonFragment(['title' => $event['title']]);
    }

}
