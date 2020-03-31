<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChannelTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_channel_consists_of_threads()
    {
        $channel = factory('App\Models\Channel')->create();
        $thread = factory('App\Models\Thread')->create(['channel_id'=>$channel->id]);
        $this->assertTrue($channel->threads->contains($thread));
    }
}
