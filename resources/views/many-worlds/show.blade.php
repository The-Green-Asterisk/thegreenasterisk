<x-many-worlds :tabs="$tabs" :bg="$bg" :world="$world">
    <section>
        @admin
            <div class="edit-link">
                <a href="{{ route('many-worlds.edit', $world->short_name) }}">Edit World</a>
                <form method="POST" action="{{ route('many-worlds.destroy', $world->short_name) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link">Delete World</button>
                </form>
            </div>
        @endadmin
        {!! $world->article ?? 'This world has not been given an article.' !!}
    </section>
    <div class="section-wrapper">
        <section>
            <h3 class="section-header">
                <a href="{{ route('many-worlds.locations.index', [$world->short_name]) }}">Locations</a>
            </h3>
            @if($world->locations->count() > 0)
                @foreach ($world->locations as $location)
                    <section>
                        <div style="display:flex;">
                            <img class="section-img"
                                src="{{ isset($location->image) ? asset('storage/'.$location->image) : asset('storage/images/default_location.jpg') }}"
                                alt="{{ $location->name }}" />
                            <div style="width:100%">
                                <h3 class="section-header">
                                    @if(isset($location->name))
                                        <a href="{{ route('many-worlds.locations.show', [$world->short_name, $location->id]) }}">
                                            {{ $location->name }}
                                        </a>
                                    @else
                                        Unnamed Location
                                    @endif
                                </h3>
                                <p>{{  $location->summary ?? 'This seems to be a place'  }}</p>
                            </div>
                        </div>
                    </section>
                @endforeach
            @else
                <section style="text-align: center;">
                    There aren't any locations yet.
                </section>
            @endif
        </section>
        <section>
            <h3 class="section-header">
                <a href="{{ route('many-worlds.organizations.index', [$world->short_name]) }}">Organizations</a>
            </h3>
            @if($world->organizations->count() > 0)
                @foreach ($world->organizations as $organization)
                    <section>
                        <div style="display:flex;">
                            <img class="section-img"
                                src="{{ isset($organization->image) ? asset('storage/'.$organization->image) : asset('storage/images/default_organization.jpg') }}"
                                alt="{{ $organization->name }}" />
                            <div style="width:100%">
                                <h3 class="section-header">
                                    @if(isset($organization->name))
                                        <a href="{{ route('many-worlds.organizations.show', [$world->short_name, $organization->id]) }}">
                                            {{ $organization->name }}
                                        </a>
                                    @else
                                        Unnamed Organization
                                    @endif
                                </h3>
                                <p>{{ $organization->summary ?? 'This seems to be an organization' }}</p>
                            </div>
                        </div>
                    </section>
                @endforeach
            @else
                <section style="text-align: center;">
                    There aren't any organizations yet.
                </section>
            @endif
        </section>
        <hr style="width:100%;" />
        <section>
            <h3 class="section-header">
                <a href="{{ route('many-worlds.characters.index', [$world->short_name]) }}">Characters</a>
            </h3>
            @if($world->characters->count() > 0)
                @foreach ($world->characters as $character)
                    <section>
                        <div style="display:flex;">
                            <img class="section-img"
                                src="{{ isset($character->image) ? asset('storage/'.$character->image) : asset('storage/images/default_character.jpg') }}"
                                alt="{{ $world->name }}" />
                            <div style="width:100%">
                                <h3 class="section-header">
                                    @if(isset($character->name))
                                        <a href="{{ route('many-worlds.characters.show', [$world->short_name, $character->id]) }}">
                                            {{ $character->name }}
                                        </a>
                                    @else
                                        Unnamed Character
                                    @endif
                                </h3>
                                <p>{{ $character->summary ?? 'This seems to be an character' }}</p>
                            </div>
                        </div>
                    </section>
                @endforeach
            @else
                <section style="text-align: center;">
                    There aren't any characters yet.
                </section>
            @endif
        </section>
        <section>
            <h3 class="section-header">
                <a href="{{ route('many-worlds.items.index', [$world->short_name]) }}">Items</a>
            </h3>
            @if($world->items->count() > 0)
                @foreach ($world->items as $item)
                    <section>
                        <div style="display:flex;">
                            <img class="section-img"
                                src="{{ isset($item->image) ? asset('storage/'.$item->image) : asset('storage/images/default_item.png') }}"
                                alt="{{ $world->name }}" />
                            <div style="width:100%">
                                <h3 class="section-header">
                                    @if(isset($item->name))
                                        <a href="{{ route('many-worlds.items.show', [$world->short_name, $item->id]) }}">
                                            {{ $item->name }}
                                        </a>
                                    @else
                                        Unnamed Item
                                    @endif
                                </h3>
                                <p>{{ $item->summary ?? 'This seems to be an item' }}</p>
                            </div>
                        </div>
                    </section>
                @endforeach
            @else
                <section style="text-align: center;">
                    There aren't any items yet.
                </section>
            @endif
        </section>
        <hr style="width:100%;" />
        <section>
            <h3 class="section-header">
                <a href="{{ route('many-worlds.events.index', [$world->short_name]) }}">Events</a>
            </h3>
            @if($world->events->count() > 0)
                @foreach ($world->events as $event)
                    <section>
                        <div style="display:flex;">
                            <img class="section-img"
                                src="{{ isset($event->image) ? asset('storage/'.$event->image) : asset('storage/images/default_event.jpg') }}"
                                alt="{{ $world->name }}"/>
                            <div style="width:100%">
                                <h3 class="section-header">
                                    @if(isset($event->name))
                                        <a href="{{ route('many-worlds.events.show', [$world->short_name, $event->id]) }}">
                                            {{ $event->name }}
                                        </a>
                                    @else
                                        Unnamed Event
                                    @endif
                                </h3>
                                <p>{{ $event->summary ?? 'This seems to be an event' }}</p>
                            </div>
                        </div>
                    </section>
                @endforeach
            @else
                <section style="text-align: center;">
                    There aren't any events yet.
                </section>
            @endif
        </section>
    </div>
    <div class="comment-form">
        @if (auth()->check())
            <h2>Leave a Comment</h2>
            <form method="POST" action="/many-worlds/{{ $world->short_name }}/comment">
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
    @if ($world->comments->count())
        <div class="comments">
            <h2>Comments</h2>
            @foreach ($world->comments as $comment)
                <div class="comment">
                    <section>
                        <img class="section-img comment-avatar" src="{{ $comment->user->avatar }}" alt="user image">
                        @if ((auth()->check() && auth()->user()->id == $comment->user_id) || auth()->user()?->is_admin)
                            @if ($comment->id != 0)
                                <div style="float: right">
                                    <button class="btn btn-link delete-comment-button" name="{{ $world->short_name }}" value={{ $comment->id }}>
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
</x-many-worlds>