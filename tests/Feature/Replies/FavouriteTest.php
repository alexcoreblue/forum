<?php

namespace Tests\Feature\Replies;

use App\Models\Favourite;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FavouriteTest extends TestCase
{
    /** @test */
    public function an_unauthenticated_user_cannot_favourite_anything()
    {
        $this->post('replies/1/favourites')
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_favourite_any_reply()
    {
        $reply = create(Reply::class);

        $this->signIn();

        $this->post('replies/' . $reply->id . '/favourites');

        $this->assertCount(1, $reply->favourites);
    }

    /** @test */
    public function an_authenticated_user_may_only_favourite_a_reply_once()
    {
        $reply = create(Reply::class);

        $this->signIn();

        $this->post('replies/' . $reply->id . '/favourites');
        $this->post('replies/' . $reply->id . '/favourites');

        $this->assertCount(1, $reply->favourites);
    }
}
