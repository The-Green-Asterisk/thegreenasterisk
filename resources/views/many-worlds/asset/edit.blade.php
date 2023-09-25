<x-many-worlds :tabs="$tabs" :bg="$bg" :world="$world">
    <section>
        <section class="section-header">
            <h1>Edit World Asset</h1>
        </section>
        <form method="POST" action="{{ route('many-worlds.'.$type.'.update', [$world->short_name, $asset->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
        
            <div>
                <label for="image">Image:</label>
                <input type="file" name="image" id="image">
            </div>
            <div>
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" value="{{ $asset->name }}" required>
            </div>
            <div>
                <label for="summary">Summary:</label>
                <input type="text" name="summary" id="summary" value="{{ $asset->summary }}" required>
            </div>
            <div>
                <label for="description">Description:</label>
                <textarea name="description" id="description" required>{{ $asset->description }}</textarea>
            </div>
            @if(isset($locations) && $locations->count() > 0)
                <div>
                    <label for="parent_location">Located In:</label>
                    <select name="parent_location" id="parent_location">
                        <option value="">None</option>
                        @foreach($locations as $l)
                            <option value="{{ $l->id }}" {{ $asset->location_id === $l->name ? 'selected' : '' }}>{{ $l->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            @if(isset($characters) && $characters->count() > 0)
                <div>
                    <label for="leader">Leader:</label>
                    <select name="leader" id="leader">
                        <option value="">None</option>
                        @foreach($characters as $character)
                            <option value="{{ $character->id }}" {{ $asset->leader_id === $character->id ? 'selected' : '' }}>{{ $character->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            @if(isset($organizations) && $organizations->count() > 0)
                <div>
                    <label for="organization">Organization:</label>
                    <select name="organization" id="organization">
                        <option value="">None</option>
                        @foreach($organizations as $organization)
                            <option value="{{ $organization->id }}" {{ $asset->organization_id === $organization->id ? 'selected' : '' }}>{{ $organization->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <button class="btn btn-primary" type="submit">Update</button>
        </form>
    </section>
</x-many-worlds>