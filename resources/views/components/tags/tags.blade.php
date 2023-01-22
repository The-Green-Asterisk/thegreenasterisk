<div class="tag-section">
    @if ($tags->count() > 0)
        <label for="tags">Tags
            <select name="tags[]" id="tags" multiple class="tag-box" title="Ctrl + click to select more than one tag">
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
        </label>
    @endif
    <button class="btn btn-info" type="button" onclick="newTag()">
        + New Tag
    </button>
</div>
