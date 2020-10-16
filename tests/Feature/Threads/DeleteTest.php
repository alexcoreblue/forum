<?php

namespace Tests\Feature\Threads;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    /** @test */
    public function authorised_users_can_delete_threads()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $thread = create(Thread::class, ['user_id' => auth()->id()]);
        $reply = create(Reply::class, ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());
        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    /** @test */
    public function unauhtorised_users_cannot_delete_threads()
    {
        $thread = create(Thread::class);

        $this->delete($thread->path())
            ->assertRedirect('/login');

        $this->assertDatabaseHas('threads', ['id' => $thread->id]);

        $this->signIn();

        $this->delete($thread->path())
            ->assertStatus(403);

        $this->assertDatabaseHas('threads', ['id' => $thread->id]);
    }
}
