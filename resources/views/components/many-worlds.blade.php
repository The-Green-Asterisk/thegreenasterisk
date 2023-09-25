<x-layout :bg="!!$world ? $bg : null">
    <x-slot name="title">{{ $world?->name ?? 'Many Worlds' }}</x-slot>
    <x-tabs.tabs :tabs="$tabs" />
    <div id="body">
        <div class="world-hero" bg="{{ $bg }}">
            <a href="{{ route(!$world ? 'many-worlds.index' : 'many-worlds.show', $world?->short_name) }}">
                <h1>{{ $world?->name ?? 'Many Worlds' }}</h1>
            </a>
        </div>
    </div>
    @if(!!$world)
        <ul class="world-nav">
            <li><a href="{{ route('many-worlds.locations.index', $world->short_name) }}">Locations</a></li>
            <li><a href="{{ route('many-worlds.organizations.index', $world->short_name) }}">Organizations</a></li>
            <li><a href="{{ route('many-worlds.characters.index', $world->short_name) }}">Characters</a></li>
            <li><a href="{{ route('many-worlds.items.index', $world->short_name) }}">Items</a></li>
            <li><a href="{{ route('many-worlds.events.index', $world->short_name) }}">Events</a></li>
        </ul>
    @endif
    {{ $slot }}
</x-layout>