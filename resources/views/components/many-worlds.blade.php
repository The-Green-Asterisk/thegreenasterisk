<x-layout :bg="$worldActive ? $bg : null">
    <x-slot name="title">{{ $world?->name ?? 'Many Worlds' }}</x-slot>
    <x-tabs.tabs :tabs="$tabs" />
    <div id="body">
        <div class="world-hero" bg="{{ $bg }}">
            <h1>{{ $world?->name ?? 'Many Worlds' }}</h1>
        </div>
    </div>
    @if($worldActive)
        <ul class="world-nav">
            <li><a href="">Locations</a></li>
            <li><a href="">Organizations</a></li>
            <li><a href="">NPCs</a></li>
            <li><a href="">Items</a></li>
        </ul>
    @endif
    {{ $slot }}
</x-layout>