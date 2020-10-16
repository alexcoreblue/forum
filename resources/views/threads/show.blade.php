@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-8">
            <div class="card">


                <div class="card-header mt-1" style="background-color: white;">


                    <div class="level">
                        <h5 class="flex">
                            <a href="/profiles/{{ $thread->creator->name }}"> {{ $thread->creator->name }} </a> posted:
                            {{ $thread->title }}
                        </h5>

                        <div>
                            <form method="POST" action="{{ $thread->path() }}">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>

                        </div>
                    </div>
                </div>

                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>
            <br>

            @foreach ($replies as $reply)
            @include ('threads.reply')
            @endforeach

            <?php echo $replies->render(); ?>

            <br>

            @if (auth()->check())
            <form method="POST" action="{{ $thread->path() . '/replies' }}">
                @csrf
                <div class="form-group">
                    <textarea name="body" id="body" class="form-control" placeholder="Have something to say?" rows="5"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Post</button>
            </form>
            @else
            <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p>This thread was published {{ $thread->created_at->diffForHumans() }} by
                        <a href="/profiles/{{ $thread->creator->name }}">{{ $thread->creator->name }}</a>,
                        and currently has {{ $thread->replies_count }} {{ Str::plural('comment', $thread->replies_count) }}.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection