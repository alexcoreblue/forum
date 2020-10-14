<?php

namespace Tests\Feature\Threads;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ViewTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = Thread::factory()->create();
    }

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_view_a_single_thread()
    {
        $this->get('/threads/' . $this->thread->id)
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_view_replies_associated_with_a_thread()
    {
        $reply = Reply::factory()->create(['thread_id' => $this->thread->id]);

        $this->get('/threads/' . $this->thread->id)
            ->assertSee($reply->body);
    }
}
