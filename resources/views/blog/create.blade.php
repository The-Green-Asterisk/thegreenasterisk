<x-layout>
    <x-slot name="title">Create a new post</x-slot>

    <h1>Create a new post</h1>

    <form method="POST" action="{{ route('blog.store') }}" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="image">Header Image:</label>
            <input type="file" name="image" id="image" class="btn btn-info">
            <img id="image-preview" class="headerImg" src="/placeholder.png" />
        </div>

        <div>
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}">
        </div>

        <div>
            <label for="content">Content</label>
            <textarea name="content" id="content">{{ old('content') }}</textarea>
        </div>

        <x-tags.tags :tags="$tags" />

        <div class="button-row">
            <button class="btn btn-secondary" type="button" id="cancel-create-button">Cancel</button>
            <button class="btn btn-info" type="submit" formaction="{{ route('blog.draft') }}">Save as Draft</button>
            <button class="btn btn-primary" type="submit">Publish</button>
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
