<x-many-worlds :tabs="$tabs" :bg="$bg" :world="$world">
    <section>
        <section class="section-header">
        @admin
            <div class="edit-link">
                <a href="{{ route('many-worlds.'.$type.'.create', $world->short_name) }}">Create</a>
            </div>
        @endadmin
            <h1>{{ ucfirst($type) }}</h1>
        </section>
        @if(isset($assets))
            @foreach($assets as $asset)
                <section class="smaller-section">
                    @if(isset($asset->image))
                        <img src="{{ asset('/storage/'.$asset->image) }}" alt="{{ $asset->name }}" class="asset-img">
                    @endif
                    <a href="{{ route('many-worlds.'.$type.'.show', [$world->short_name, $asset->id]) }}"><h2>{{ $asset->name }}</h2></a>
                    <h3>{{ $asset->summary }}</h3>
                    <p>{!! substr($asset->description, 250).(strlen($asset->description) > 250 ? '...' : '') !!}</p>
                </section>
            @endforeach
        @else
            <p>There are no {{ $type }} in this world yet.</p>
        @endif
    </section>
</x-many-worlds>