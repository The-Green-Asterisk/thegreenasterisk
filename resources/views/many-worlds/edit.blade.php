<x-many-worlds :tabs="$tabs" :bg="$bg" :world="$world">
    <section>
        <div class="section-header">
            <h1>Let there be light...</h1>
        </div>

        <form method="POST" name="new-world" action="{{ route('many-worlds.update', $world->short_name) }}" >
            @method('DELETE')
            @csrf
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
            <input type="text" name="name" id="world-name" placeholder="World Name" value="{{ $world->name }}" />
            <input type="text" name="short_name" id="short-name" placeholder="Short Name" value="{{ $world->short_name }}" />
            <textarea type="text" name="article" placeholder="Article">{{ $world->article }}</textarea>
            <div class="button-row">
                <button class="btn btn-secondary" type="button" id="cancel-create-button">Cancel</button>
                <button class="btn btn-danger" type="submit" name="delete" value="{{ $world->short_name }}">Delete World</button>
                <button class="btn btn-primary" type="submit">Update World</button>
            </div>
        </form>
    </section>
</x-many-worlds>