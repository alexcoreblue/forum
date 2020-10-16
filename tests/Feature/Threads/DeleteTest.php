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
    public function a_thread_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $thread = create(Thread::class);
        $reply = create(Reply::class, ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());
        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    /** @test */
    public function threads_may_only_be_deleted_by_those_who_have_permission()
    {
        // TODO
    }

    /** @test */
    public function guests_cannot_delete_threads()
    {
        $thread = create(Thread::class);

        $response = $this->delete($thread->path());
        $response->assertRedirect('/login');

        $this->assertDatabaseHas('threads', ['id' => $thread->id]);
    }
}
