<x-many-worlds :tabs="$tabs" :bg="$bg" :world="$world">
    <section>
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
        <section class="smaller-section">
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
            @if(isset($asset->members))
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
</x-many-worlds>