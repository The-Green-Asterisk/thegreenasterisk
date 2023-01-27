<x-layout>
    <x-slot name="title">Edit: {{ $blogPost->title }}</x-slot>
    <form action="/blog/{{ $blogPost->id }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <input type="hidden" name="id" value="{{ $blogPost->id }}">
        <label for="image">Header Image:</label>
        <input type="file" name="image" id="image" class="btn btn-info">
        <img class="headerImg" src="{{ asset($blogPost->image) }}" alt="{{ $blogPost->title }}" />
        <input type="text" name="title" id="title" value="{{ $blogPost->title }}">
        <textarea name="content" id="content" cols="30" rows="10">{{ $blogPost->content }}</textarea>
        <div class="tag-section">
            @if ($tags->count() > 0)
                <label for="tags">Tags
                    <select name="tags[]" id="tags" multiple class="tag-box">
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}" @if ($blogPost->tags->contains($tag)) selected @endif>
                                {{ $tag->name }}</option>
                        @endforeach
                    </select>
                </label>
            @endif
            <button class="btn btn-info" type="button" onclick="newTag()">
                + New Tag
            </button>
        </div>

        <div class="button-row">
            <button class="btn btn-secondary" type="button" onclick="cancelEdit()">Cancel</button>
            <button class="btn btn-danger" type="button" onclick="deleteModal({{ $blogPost->id }})">Delete
                Post</button>
            @if ($blogPost->is_draft)
                <button class="btn btn-info" type="submit" formaction="{{ route('blog.draft') }}">Save
                    Draft</button>
                <button class="btn btn-primary" type="submit">Publish</button>
            @else
                <button class="btn btn-info" type="submit" formaction="{{ route('blog.edit.draft') }}">Revert to
                    Draft</button>
                <button class="btn btn-primary" type="submit">Update Post</button>
            @endif
        </div>
    </form>
    @if ($errors->any())
        <div>
            <p>There were some problems with your input.</p>
        </div>
        @foreach ($errors->all() as $error)
            <p class="error">{{ $error }}</p>
        @endforeach
    @endif
</x-layout>
