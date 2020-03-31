<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReplyTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function a_reply_has_an_owner()
    {
        $reply = factory('App\Models\Reply')->create();

        $this->assertInstanceOf('App\Models\User',$reply->owner);
    }
}
