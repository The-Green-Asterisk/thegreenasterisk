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
                                src="{{ isset($organization->image) ? asset('storage/images/'.$organization->image) : asset('storage/images/default_organization.jpg') }}"
                                alt="{{ $organization->name }}" />
                            <div style="width:100%">
                                <h3 class="section-header">
                                    {{ $organization->name ?? 'Unnamed Organization' }}
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
                                src="{{ isset($character->image) ? asset('storage/images/'.$character->image) : asset('storage/images/default_character.jpg') }}"
                                alt="{{ $world->name }}" />
                            <div style="width:100%">
                                <h3 class="section-header">
                                    {{ $character->name ?? 'Unnamed character' }}
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
                                src="{{ isset($item->image) ? asset('storage/images/'.$item->image) : asset('storage/images/default_item.png') }}"
                                alt="{{ $world->name }}" />
                            <div style="width:100%">
                                <h3 class="section-header">
                                    {{ $item->name ?? 'Unnamed item' }}
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
                                src="{{ isset($event->image) ? asset('storage/images/'.$event->image) : asset('storage/images/default_event.jpg') }}"
                                alt="{{ $world->name }}"/>
                            <div style="width:100%">
                                <h3 class="section-header">
                                    {{ $event->name ?? 'Unnamed event' }}
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
</x-many-worlds>