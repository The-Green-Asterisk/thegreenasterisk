<x-many-worlds :tabs="$tabs" :bg="$bg" :world="$world">
    <section>
        {!! $world->article ?? 'This world has not been given an article.' !!}
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
</x-many-worlds>