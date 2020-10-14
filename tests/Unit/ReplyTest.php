<?php

namespace Tests\Unit;

use App\Models\Reply;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    /** @test */
    public function reply_has_an_owner()
    {
        $reply = create(Reply::class);

        $this->assertInstanceOf(User::class, $reply->owner);
    }
}
