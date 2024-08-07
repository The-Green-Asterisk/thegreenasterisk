<x-many-worlds :tabs="$tabs" :bg="$bg" :world="$world">
    <section class="asset-view">
        <section class="section-header">
        @admin
            <div class="edit-link">
                <a href="{{ route('many-worlds.'.$type.'.edit', [$world->short_name, $asset->id]) }}">Edit</a>
                <form method="POST" action="{{ route('many-worlds.'.$type.'.destroy', [$world->short_name, $asset->id]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link">Delete</button>
                </form>                
            </div>
        @endadmin
            <h1>{{  $asset->name  }}</h1>
        </section>
        <section class="asset-view">
            @if(isset($asset->image))
                <img src="{{ asset('/storage/'.$asset->image) }}" alt="{{ $asset->name }}" class="asset-article-img">
            @endif
            <h3>{{ $asset->summary }}</h3>
            <p>{!! $asset->description !!}</p>
            @if(isset($asset->location))
                <h3>Located In:</h3>
                <p><a href="{{ route('many-worlds.locations.show', [$world->short_name, $asset->location->id]) }}">{{ $asset->location->name }}</a></p>
            @endif
            @if(isset($asset->leader))
                <h3>Leader:</h3>
                <p><a href="{{ route('many-worlds.characters.show', [$world->short_name, $asset->leader->id]) }}">{{ $asset->leader->name }}</a></p>
            @endif
            @if(isset($asset->members) && $asset->members->count() > 0)
                <h3>Members:</h3>
                <ul>
                    @foreach($asset->members as $member)
                        <li><a href="{{ route('many-worlds.characters.show', [$world->short_name, $member->id]) }}">{{ $member->name }}</a></li>
                    @endforeach
                </ul>
            @endif
            @if(isset($asset->organization))
                <h3>Member Of:</h3>
                <p><a href="{{ route('many-worlds.organizations.show', [$world->short_name, $asset->organization->id]) }}">{{ $asset->organization->name }}</a></p>
            @endif
        </section>
    </section>
    <div class="comment-form">
        @if (auth()->check())
            <h2>Leave a Comment</h2>
            <form method="POST" action="/many-worlds/{{ $world->short_name }}/{{ $type }}/{{ $asset->id }}/comment">
                @csrf
                <div class="form-group">
                    <input type="hidden" name="world_id" value="{{ $world->short_name }}" />
                    <label for="content" hidden>Comment</label>
                    <textarea id="comment_content" name="comment_content" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        @else
            <p><a href="#" id="log-in-button">Login</a> to leave a comment.</p>
        @endif
    </div>
    <hr>
    @if ($asset->comments->count())
        <div class="comments">
            <h2>Comments</h2>
            @foreach ($asset->comments as $comment)
                <div class="comment">
                    <section>
                        <img class="section-img comment-avatar" src="{{ $comment->user->avatar }}" alt="user image">
                        @if ((auth()->check() && auth()->user()?->id == $comment->user_id) || auth()->user()?->is_admin)
                            @if ($comment->id != 0)
                                <div style="float: right">
                                    <button class="btn btn-link delete-comment-button" name="{{ $asset->id }}" value={{ $comment->id }}>
                                        Delete
                                    </button>
                                </div>
                            @endif
                        @endif
                        <p class="comment-user">{{ $comment->user->name }}</p>
                        <p class="dateline">{{ $comment->getCreatedAtAttribute($comment->created_at) }}</p>
                        <p class="comment-content">{!! $comment->content !!}</p>
                        <div class="end-section"></div>
                    </section>
                </div>
            @endforeach
        </div>
    @endif
    <input hidden name="world_id" id="world_id" value="{{ $world->short_name }}" />
    <input hidden name="asset_type" id="asset_type" value="{{ $type }}" />
</x-many-worlds>