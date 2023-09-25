<x-many-worlds :tabs="$tabs" :bg="$bg" :world="$world">
    <section>
        <section class="section-header">
            <h1>Create World Asset</h1>
        </section>
        <form method="POST" action="{{ route('many-worlds.'.$type.'.store', [$world->short_name]) }}" enctype="multipart/form-data">
            @csrf
        
            <div>
                <label for="image">Image:</label>
                <input type="file" name="image" id="image">
            </div>
            <div>
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div>
                <label for="summary">Summary:</label>
                <input type="text" name="summary" id="summary" required>
            </div>
            <div>
                <label for="description">Description:</label>
                <textarea name="description" id="description" required></textarea>
            </div>
            @if(isset($locations) && $locations->count() > 0)
                <div>
                    <label for="parent_location">Located In:</label>
                    <select name="parent_location" id="parent_location">
                        <option value="">None</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->name }}</option>
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
                            <option value="{{ $character->id }}">{{ $character->name }}</option>
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
                            <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            @if(isset($items) && $items->count() > 0)
                <div>
                    <label for="item">Item:</label>
                    <select name="item" id="item">
                        <option value="">None</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <button class="btn btn-primary" type="submit">Create</button>
        </form>
    </section>
</x-many-worlds>
