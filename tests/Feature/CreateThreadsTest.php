<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        // Given we have a signed in user
        $this->be($user = factory('App\Models\User')->create());
        // When we hit the endpoint to cteate a new thread
        $thread = factory('App\Models\Thread')->make();
        $response = $this->post('/threads',$thread->toArray());
        // Then,when we visit the thread
        $this->get($response->headers->get('Location'))->assertSee($thread->body)
            ->assertSee($thread->title);
        // We should see the new thread
    }

    /** @test */
    public function guests_may_not_create_threads()
    {
        $thread = factory('App\Models\Thread')->make();
        $this->withExceptionHandling()
            ->post('/threads',$thread->toArray())
            ->assertRedirect('/login');
    }

    public function test_guests_may_not_see_the_thread_create_page()
    {
        $this->get('/threads/create')->assertRedirect('/login');
    }

    public function test_a_thread_reuqire_title()
    {

        $this->publishThread(['title'=>null])->assertSessionHasErrors('title');

    }

    public function test_a_thread_require_body()
    {
        $this->publishThread(['body'=>null])->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        $channel = factory('App\Models\Channel',2)->create(); // 新建两个 Channel，id 分别为 1 跟 2

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])  // channle_id 为 999，是一个不存在的 Channel
            ->assertSessionHasErrors('channel_id');
    }

    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->be($user = factory('App\Models\User')->create());

        $thread = factory('App\Models\Thread')->make($overrides);

        return $this->post('/threads',$thread->toArray());
    }


}
