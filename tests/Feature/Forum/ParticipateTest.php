<?php

namespace Tests\Feature\Forum;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->be($user = User::factory()->create());

        $thread = Thread::factory()->create();
        $reply = Reply::factory()->make();

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function unauthenticated_user_may_not_participate_in_forum_threads()
    {
        $this->expectException(AuthenticationException::class);
        $this->withoutExceptionHandling();
        $this->post('/threads/1/replies', []);
    }
}
