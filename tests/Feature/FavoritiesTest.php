<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoritiesTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_an_authenticated_user_can_favorite_any_reply()
    {
        $this->be($user = factory('App\Models\User')->create());
        $reply = factory('App\Models\Reply')->create();
        $this->post('/replies/'.$reply->id.'/favorite');
        $this->assertCount(1,$reply->favorites);

    }

    public function test_a_guest_can_not_favorite_reply()
    {
        $reply = factory('App\Models\Reply')->create();
        $this->withExceptionHandling()
            ->post('/replies/'.$reply->id.'/favorite')
            ->assertRedirect('/login');
    }

    public function test_an_authenticated_user_may_only_favorite_a_reply_once()
    {
        $this->be($user = factory('App\Models\User')->create());
        $reply = factory('App\Models\Reply')->create();
        try {
            $this->post('/replies/'.$reply->id.'/favorite');
            $this->post('/replies/'.$reply->id.'/favorite');


        } catch (\Exception $exception)
        {
            $this->fail('Did not expect to insert the same record set twice.');
        }
        $this->assertCount(1,$reply->favorites);
    }

    public function test_an_authenticated_user_can_unfavorite_a_reply()
    {
        $this->signIn();

        $reply = factory('App\Models\Reply')->create();

        $reply->favorite();

        $this->delete('replies/' . $reply->id . '/favorite');
        $this->assertCount(0,$reply->favorites);
    }
}
