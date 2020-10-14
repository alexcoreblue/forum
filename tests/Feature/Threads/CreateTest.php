<?php

namespace Tests\Feature\Threads;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateTest extends TestCase
{
    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->signIn();

        $thread = make(Thread::class);

        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function an_unauthenticated_user_may_not_create_new_forum_threads()
    {
        $this->expectException(AuthenticationException::class);
        $this->withoutExceptionHandling();

        $thread = make(Thread::class);

        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function authenticated_user_can_view_create_new_forum_threads_page()
    {
        $this->signIn();

        $this->get('threads/create')
            ->assertViewIs('threads.create');
    }

    /** @test */
    public function guests_cannot_view_create_new_forum_threads_page()
    {
        $this->get('threads/create')
            ->assertRedirect('/login');
    }
}
