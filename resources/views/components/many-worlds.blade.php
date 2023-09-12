<x-layout>
    <x-tabs.tabs :tabs="$tabs" />
    <div id="body">
        <div class="world-hero" bg="{{ $bg ?? asset('/storage/images/graph-paper.jpg') }}">
            <h1>{{ $worldName }}</h1>
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