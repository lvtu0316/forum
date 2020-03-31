<?php

namespace Tests\Unit;

use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_records_activity_when_a_thread_is_created()
    {
        $this->be($user = factory('App\Models\User')->create());
        $thread = factory('App\Models\Thread')->create(['user_id'=>$user->id]);
        $this->assertDatabaseHas('activities',[
            'type' => 'created_thread',
            'user_id' => $user->id,
            'subject_id' => $thread->id,
            'subject_type' => 'App\Models\Thread'
        ]);
        $activity = Activity::first();
        $this->assertEquals($activity->subject_id,$thread->id);
    }

    public function test_it_records_activity_when_a_reply_is_created()
    {
        $this->be($user = factory('App\Models\User')->create());
        $thread = factory('App\Models\Thread')->create(['user_id'=>$user->id]);
        $reply = factory('App\Models\Reply')->create(['thread_id'=>$thread->id]);
        $this->assertEquals(2,Activity::count());



    }

    public function test_it_fetches_a_feed_for_any_user()
    {
        $this->be($user = factory('App\Models\User')->create());
        $thread = factory('App\Models\Thread')->create(['user_id'=>$user->id],2);
        factory('App\Models\Thread')->create([
            'user_id'=>$user->id,
            'created_at' => Carbon::now()->subWeek()
        ]);
        auth()->user()->activity()->first()->update(['created_at' => Carbon::now()->subWeek()]);
        $feed = Activity::feed(auth()->user());
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));


    }
}
