<x-many-worlds :tabs="$tabs" :bg="$bg" :world="$world">
    <section>
        <div class="section-header">
            <div class="edit-link">
                <form method="POST" action="{{ route('many-worlds.destroy', $world->short_name) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link">Delete</button>
                </form>                
            </div>
            <h1>Be the change you wish to see in the world.</h1>
        </div>

        <form method="POST" action="{{ route('many-worlds.update', $world->short_name) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
            <label for="image">Background Image:</label>
            <input type="file" name="image" id="image" />
            <label for="name" hidden>World Name:</label>
            <input type="text" name="name" id="world-name" placeholder="World Name" value="{{ $world->name }}" />
            <label for="short_name" hidden>Short Name:</label>
            <input type="text" name="short_name" id="short-name" placeholder="Short Name" value="{{ $world->short_name }}" />
            <textarea type="text" name="article" placeholder="Article">{{ $world->article }}</textarea>
            <div class="button-row">
                <button class="btn btn-secondary" type="button" id="cancel-create-button">Cancel</button>
                <button class="btn btn-primary" type="submit">Update World</button>
            </div>
        </form>
    </section>
</x-many-worlds>