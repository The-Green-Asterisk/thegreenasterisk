<x-many-worlds :tabs="$tabs" :bg="$bg" :world="$world">
    <section>
        <div class="section-header">
            <h1>Let there be light...</h1>
        </div>

        <form method="POST" name="new-world" action="{{ route('many-worlds.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
            <label for="image">Background Image:</label>
            <input type="file" name="image" id="image" />
            <label for="name" hidden>World Name:</label>
            <input type="text" name="name" id="world-name" placeholder="World Name" />
            <label for="short_name" hidden>Short Name:</label>
            <input type="text" name="short_name" id="short-name" placeholder="Short Name" />
            <textarea type="text" name="article" placeholder="Article"></textarea>
            <div class="button-row">
                <button class="btn btn-secondary" type="button" id="cancel-create-button">Cancel</button>
                <button class="btn btn-primary" type="submit">Create World</button>
            </div>
        </form>
    </section>
</x-many-worlds>