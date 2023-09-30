<x-layout>
    @section('meta_title', $blogPost->title)
    @section('meta_description', strip_tags($blogPost->getexcerpt()))
    @section('meta_image', asset($blogPost->image))

    <x-slot name="title">{{ $blogPost->title }}</x-slot>

    <img class="headerImg" src="{{ asset($blogPost->image) }}" alt="{{ $blogPost->title }}">

    @if ($blogPost->tags->count())
        <p class="tags">
            @foreach ($blogPost->tags as $tag)
                <a class="tag" href="{{ route('blog.index', ['tag' => $tag->name]) }}">
                    {{ $tag->name }}
                </a>
            @endforeach
        </p>
    @endif

    <h1>{{ $blogPost->title }} {!! $blogPost->is_draft
        ? '<span style="font-size: 1rem; font-style: italic; font-weight: 200;" >(Draft)</span>'
        : '' !!}</h1>
    <p class="dateline">
        Published {{ $blogPost->getPublishedAtAttribute($blogPost->published_at) }} by {{ $blogPost->user->name }}
    </p>

    <p>{!! $blogPost->content !!}</p>
    <hr>
    <div class="comment-form">
        @if (auth()->check())
            <h2>Leave a Comment</h2>
            <form method="POST" action="/blog/{{ $blogPost->id }}/comment">
                @csrf
                <div class="form-group">
                    <input type="hidden" name="blog_post_id" value="{{ $blogPost->id }}" />
                    <label for="content" hidden>Comment</label>
                    <textarea id="comment_content" name="comment_content" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        @else
            <p><a href="#" id="log-in-button">Login</a> to leave a comment.</p>
        @endif
    </div>
    <hr>
    @if ($blogPost->comments->count())
        <div class="comments">
            <h2>Comments</h2>
            @foreach ($blogPost->comments as $comment)
                <div class="comment">
                    <section>
                        <img class="section-img comment-avatar" src="{{ $comment->user->avatar }}" alt="user image">
                        @if ((auth()->check() && auth()->user()->id == $comment->user_id) || auth()->user()->is_admin)
                            @if ($comment->id != 0)
                                <div style="float: right">
                                    <button class="btn btn-link delete-comment-button" name="{{ $comment->id }}">
                                        Delete
                                    </button>
                                </div>
                            @endif
                        @endif
                        <p class="comment-user">{{ $comment->user->name }}</p>
                        <p class="dateline">{{ $comment->getCreatedAtAttribute($comment->created_at) }}</p>
                        <p class="comment-content">{!! $comment->content !!}</p>
                        <div class="end-section"></div>
                    </section>
                </div>
            @endforeach
        </div>
    @endif
    <div class="button-row">
        <button class="btn btn-secondary" type="button" id="back-to-blog-button">Back to Blog</button>
        @admin
            <button class="btn btn-primary" type="button" id="edit-blog-post-button" value="{{ $blogPost->id }}">Edit
                Post</button>
        @endadmin
    </div>
</x-layout>
