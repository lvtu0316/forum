<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = factory('App\Models\Channel')->create();
        $threadInChannel = factory('App\Models\Thread')->create(['channel_id' => $channel->id]);
        $threadNotInChannel = factory('App\Models\Thread')->create();
        $this->get('/threads/'.$channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);

        $this->assertTrue(true);
    }

    public function test_a_user_can_filter_threads_by_username()
    {
        $this->be($user=factory('App\Models\User')->create(['name'=>'zhangsan']));
        $threadbyzhangsan = factory('App\Models\Thread')->create(['user_id'=>auth()->id()]);
        $thread = factory('App\Models\Thread')->create();
        $this->get('/threads?by=zhangsan')
            ->assertSee($threadbyzhangsan->title)
            ->assertDontSee($thread->title);
    }

    public function test_a_user_can_request_all_replies_for_a_given_thread()
    {
        $thread = factory('App\Models\Thread')->create();

        factory('App\Models\Reply',2)->create(['thread_id' => $thread->id]);
        $response = $this->getJson($thread->path() . '/replies')->json();
        $this->assertCount(1, $response['data']);
        $this->assertEquals(2, $response['total']);
    }


}
