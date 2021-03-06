<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->signIn();

        $this->thread = factory('App\Models\Thread')->create(['user_id'=>auth()->id()]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_user_can_view_all_threads ()
    {
        $response = $this->get('/threads');
        $response->assertSee($this->thread->title);

    }

    /** @test */
    public function a_user_can_read_a_single_thread()
    {
        $response = $this->get('/threads/' . $this->thread->channel .'/'. $this->thread->id);
        $response->assertSee($this->thread->title);
    }

    public function a_user_can_read_thread_reply()
    {
        $reply = factory('App\Models\Reply')
            ->create(['thread_id'=>$this->thread->id]);
        $this->get('/threads/'.$this->thread->id)
            ->assertSee($reply->body);
    }

    public function test_authorized_users_can_delete_threads()
    {

        $reply = factory('App\Models\Reply')->create(['thread_id'=>auth()->id()]);

        $response =  $this->json('DELETE',route('threads.destroy',$this->thread->id));

        $response->assertStatus(204);
        $this->assertDatabaseMissing('threads',['id'=>$this->thread->id]);
        $this->assertDatabaseMissing('replies',['id'=>$this->thread->id]);
        $this->assertDatabaseMissing('activities',[
            'subject_id' => $this->thread->id,
            'subject_type' => get_class($this->thread)
        ]);
        $this->assertDatabaseMissing('activities',[
            'subject_id' => $this->thread->id,
            'subject_type' => get_class($reply)
        ]);
    }

    /** @test */
    public function test_unauthorized_users_may_not_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = factory('App\Models\Thread')->create();
        $this->be($user=factory('App\Models\User')->create());

        $this->delete('/threads/'.$thread->id)->assertStatus(403);

    }
}
