<div class="tag-section">
    @if ($tags->count() > 0)
        <label for="tags">Tags
            <select name="tags[]" id="tags" multiple class="tag-box">
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
        </label>
    @endif
    <button class="btn btn-info" type="button" id="new-tag-button">
        + New Tag
    </button>
</div>
