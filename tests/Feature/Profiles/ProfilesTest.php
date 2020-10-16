<?php

namespace Tests\Feature\Profiles;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProfilesTest extends TestCase
{
    /** @test */
    public function a_user_has_a_profile()
    {
        $this->withoutExceptionHandling();

        $user = create(User::class);

        $this->get("/profiles/{$user->name}")
            ->assertSee($user->name);
    }

    /** @test */
    public function profiles_display_all_threads_created_by_the_associated_user()
    {
        $this->withoutExceptionHandling();

        $user = create(User::class);

        $thread = create(Thread::class, ['user_id' => $user->id]);

        $this->get("/profiles/{$user->name}")
            ->assertSee($user->name)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
