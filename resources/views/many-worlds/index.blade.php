<x-many-worlds :tabs="$tabs" :bg="$bg" :world="$world" :worldActive="$worldActive">
    @if(!$worldActive)
        <section>
            <div class="section-header">
                <h1>And, lo, there were many worlds before me</h1>
            </div>
            <h3>Beyond the gates of this realm lie portals to realities beyond our own. Realities that do not heed to the rules established by what we now consider home.</h3>
            <p>Welcome to the repository of worlds I have created as campaign settings for any Table Top RPG of your choice, but mostly D&D 5e. Here you can read up on characters, places, organizations, items, and whatever else you need to keep track of as either a player or GM of these games. Click on one of the world tabs above to get started.</p>
        </section>
    @else
        <section>
            <div class="section-header">
                {{ $world->summary ?? 'This world has not been given a summary.' }}
            </div>
        </section>
        <div class="section-wrapper">
            <section>
                <h3 class="section-header">
                    Locations
                </h3>
                @foreach ($world->locations as $location)
                    <section>
                        <div style="display:flex;">
                            <img class="section-img"
                                src="{{ isset($location->image) ? asset('storage/images/'.$location->image) : asset('storage/images/default_location.jpg') }}"
                                alt="{{ $world->name }}"
                                style="width:150px;height:150px" />
                            <div style="width:100%">
                                <h3 class="section-header">
                                    {{ $location->name ?? 'Unnamed Location' }}
                                </h3>
                                <p>{{ $location->description ?? 'This seems to be a place' }}</p>
                            </div>
                        </div>
                    </section>
                @endforeach
                    <section>
                        <div style="display:flex;">
                            <img class="section-img"
                                src="{{ isset($location->image) ? asset('storage/images/'.$location->image) : asset('storage/images/default_location.jpg') }}"
                                alt="{{ $world->name }}"
                                style="width:150px;height:150px" />
                            <div style="width:100%">
                                <h3 class="section-header">
                                    {{ $location->name ?? 'Unnamed Location' }}
                                </h3>
                                <p>{{ $location->description ?? 'This seems to be a place' }}</p>
                            </div>
                        </div>
                    </section>
            </section>
            <section>
                <h3 class="section-header">
                    Organizations
                </h3>
                @foreach ($world->organizations as $organization)
                    <section>
                        <div style="display:flex;">
                            <img class="section-img"
                                src="{{ isset($organization->image) ? asset('storage/images/'.$organization->image) : asset('storage/images/default_organization.jpg') }}"
                                alt="{{ $world->name }}"
                                style="width:150px;height:150px" />
                            <div style="width:100%">
                                <h3 class="section-header">
                                    {{ $organization->name ?? 'Unnamed Organization' }}
                                </h3>
                                <p>{{ $organization->description ?? 'This seems to be an organization' }}</p>
                            </div>
                        </div>
                    </section>
                @endforeach
                    <section>
                        <div style="display:flex;">
                            <img class="section-img"
                                src="{{ isset($organization->image) ? asset('storage/images/'.$organization->image) : asset('storage/images/default_organization.jpg') }}"
                                alt="{{ $world->name }}"
                                style="width:150px;height:150px" />
                            <div style="width:100%">
                                <h3 class="section-header">
                                    {{ $organization->name ?? 'Unnamed Organization' }}
                                </h3>
                                <p>{{ $organization->description ?? 'This seems to be an organization' }}</p>
                            </div>
                        </div>
                    </section>
            </section>
            <hr style="width:100%;" />
            <section>
                <h3 class="section-header">
                    Characters
                </h3>
                @foreach ($world->characters as $character)
                    <section>
                        <div style="display:flex;">
                            <img class="section-img"
                                src="{{ isset($character->image) ? asset('storage/images/'.$character->image) : asset('storage/images/default_character.jpg') }}"
                                alt="{{ $world->name }}"
                                style="width:150px;height:150px" />
                            <div style="width:100%">
                                <h3 class="section-header">
                                    {{ $character->name ?? 'Unnamed character' }}
                                </h3>
                                <p>{{ $character->description ?? 'This seems to be an character' }}</p>
                            </div>
                        </div>
                    </section>
                @endforeach
                    <section>
                        <div style="display:flex;">
                            <img class="section-img"
                                src="{{ isset($character->image) ? asset('storage/images/'.$character->image) : asset('storage/images/default_character.jpg') }}"
                                alt="{{ $world->name }}"
                                style="width:150px;height:150px" />
                            <div style="width:100%">
                                <h3 class="section-header">
                                    {{ $character->name ?? 'Unnamed character' }}
                                </h3>
                                <p>{{ $character->description ?? 'This seems to be an character' }}</p>
                            </div>
                        </div>
                    </section>
            </section>
            <section>
                <h3 class="section-header">
                    Items
                </h3>
                @foreach ($world->items as $item)
                    <section>
                        <div style="display:flex;">
                            <img class="section-img"
                                src="{{ isset($item->image) ? asset('storage/images/'.$item->image) : asset('storage/images/default_item.png') }}"
                                alt="{{ $world->name }}"
                                style="width:150px;height:150px" />
                            <div style="width:100%">
                                <h3 class="section-header">
                                    {{ $item->name ?? 'Unnamed item' }}
                                </h3>
                                <p>{{ $item->description ?? 'This seems to be an item' }}</p>
                            </div>
                        </div>
                    </section>
                @endforeach
                    <section>
                        <div style="display:flex;">
                            <img class="section-img"
                                src="{{ isset($item->image) ? asset('storage/images/'.$item->image) : asset('storage/images/default_item.png') }}"
                                alt="{{ $world->name }}"
                                style="width:150px;height:150px" />
                            <div style="width:100%">
                                <h3 class="section-header">
                                    {{ $item->name ?? 'Unnamed item' }}
                                </h3>
                                <p>{{ $item->description ?? 'This seems to be an item' }}</p>
                            </div>
                        </div>
                    </section>
            </section>
            <hr style="width:100%;" />
            <section>
                <h3 class="section-header">
                    Events
                </h3>
                @foreach ($world->events as $event)
                    <section>
                        <div style="display:flex;">
                            <img class="section-img"
                                src="{{ isset($event->image) ? asset('storage/images/'.$event->image) : asset('storage/images/default_event.jpg') }}"
                                alt="{{ $world->name }}"
                                style="width:150px;height:150px" />
                            <div style="width:100%">
                                <h3 class="section-header">
                                    {{ $event->name ?? 'Unnamed event' }}
                                </h3>
                                <p>{{ $event->description ?? 'This seems to be an event' }}</p>
                            </div>
                        </div>
                    </section>
                @endforeach
                    <section>
                        <div style="display:flex;">
                            <img class="section-img"
                                src="{{ isset($event->image) ? asset('storage/images/'.$event->image) : asset('storage/images/default_event.jpg') }}"
                                alt="{{ $world->name }}"
                                style="width:150px;height:150px" />
                            <div style="width:100%">
                                <h3 class="section-header">
                                    {{ $event->name ?? 'Unnamed event' }}
                                </h3>
                                <p>{{ $event->description ?? 'This seems to be an event' }}</p>
                            </div>
                        </div>
                    </section>
            </section>
        </div>
    @endif
</x-many-worlds>