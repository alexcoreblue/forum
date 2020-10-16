<div class="card">
    <div class="card-header">

        <div class="level">
            <h5 class="flex">
                <a href="#"> {{ $reply->owner->name }} </a> said {{ $reply->created_at->diffForHumans() }}...
            </h5>

            <div>
                <form method="POST" action="/replies/{{ $reply->id }}/favourites">
                    @csrf
                    <button type="submit" class="btn btn-dark" {{ $reply->isFavourited() ? 'disabled' : '' }}>{{ $reply->favourites()->count() }} {{ Str::plural('Favourite', $reply->favourites()->count())}}</button>
                </form>

            </div>
        </div>

    </div>
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
<br>