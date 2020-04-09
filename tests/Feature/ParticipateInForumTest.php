<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->be($user = factory('App\Models\User')->create());
        $thread = factory('App\Models\Thread')->create();
        $reply = factory('App\Models\Reply')->make();
        $this->post('/threads/'.$thread->id.'/replies',$reply->toArray());
        $this->assertDatabaseHas('replies',['body' => $reply->body]);
//        $this->get(route('threads.show',[$thread->channel,$thread]))
//            ->assertSee($reply->body);
    }

    /** @test */
    public function unauthenticated_user_may_no_add_replies()
    {
        $thread = factory('App\Models\Thread')->create();
        $reply = factory('App\Models\Reply')->make();
        $this->withExceptionHandling()
            ->post('/threads/'.$thread->id.'/replies', $reply->toArray())
            ->assertRedirect('/login');
    }

    public function test_a_reply_require_a_body()
    {
        $this->be($user = factory('App\Models\User')->create());

        $thread = factory('App\Models\Thread')->create();
        $reply = factory('App\Models\Reply')->make(['body'=>null]);

        $this->post('/threads/'.$thread->id.'/replies',$reply->toArray())
            ->assertSessionHasErrors('body');



    }

    public function test_unauth_user_cannot_delete_reply()
    {
        $this->withExceptionHandling();
        $reply = factory('App\Models\Reply')->create();
        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('login');
        $this->signIn()
            ->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    public function test_authorized_users_can_delete_replies()
    {
        $this->signIn();

        $reply = factory('App\Models\Reply')->create(['user_id' => auth()->id()]);
        $this->delete("/replies/{$reply->id}")->assertStatus(302);

        $this->assertDatabaseMissing('replies',['id' => $reply->id]);
    }

    public function test_unauthorized_users_cannot_update_replies()
    {
        $this->withExceptionHandling();

        $reply = factory('App\Models\Reply')->create();

        $this->patch("/replies/{$reply->id}")
            ->assertRedirect('login');

        $this->signIn()
            ->patch("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    /** @test */
    public function test_authorized_users_can_update_replies()
    {
        $this->signIn();

        $reply = factory('App\Models\Reply')->create(['user_id' => auth()->id()]);
        $updatedReply = 'You have been changed,foo.';
        $this->patch(route('reply.update',$reply->id),
            ['body' => $updatedReply]);

        $this->assertDatabaseHas('replies',['id' => $reply->id,'body' => $updatedReply]);
    }
}
