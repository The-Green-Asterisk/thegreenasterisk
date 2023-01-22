<x-layout>
    <x-slot name="title">Blog</x-slot>

    <img class="headerImg" src="{{ asset('blog.png') }}" alt="Blog">

    <section>
        <div class="section-header">
            <h1>Blog</h1>
        </div>
        @foreach ($posts as $post)
            <section>
                <a href="{{ route('blog.show', $post->id) }}">
                    <img class="section-img" src="{{ asset($post->image) }}" alt="{{ $post->title }}">
                </a>
                @admin
                    @if ($post->id != 0)
                        <div style="float: right">
                            <a href="/blog/{{ $post->id }}/edit">
                                Edit
                            </a>
                            <a href="#" onclick="deleteModal({{ $post->id }})" style="color:red;">
                                Delete
                            </a>
                        </div>
                    @endif
                @endadmin
                <h2>
                    <a href="{{ route('blog.show', $post->id) }}">
                        {{ $post->title }} {!! $post->is_draft
                            ? '<span style="font-size: 1rem; font-style: italic; font-weight: 200;" >(Draft)</span>'
                            : '' !!}
                    </a>
                </h2>
                <p class="dateline">
                    Published {{ $post->getPublishedAtAttribute($post->published_at) }} by {{ $post->user->name }}
                </p>
                <p>
                    {!! $post->getexcerpt() !!}
                </p>
                @if ($post->tags->count())
                    <p class="tags">
                        @foreach ($post->tags as $tag)
                            <a class="tag" href="{{ route('blog.index', ['tag' => $tag->name]) }}">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                    </p>
                @endif
                <div class="end-section"></div>
            </section>
        @endforeach
    </section>
    <div class="button-row">
        @if (request()->get('tag') != null)
            <button class="btn btn-secondary" type="button" onclick="window.location.href='/blog'">
                Clear Tag
            </button>
        @endif
        @admin
            @if (request()->get('all') == null)
                <button class="btn btn-secondary" type="button" onclick="window.location.href='/blog?all=1'">
                    View All
                </button>
            @else
                <button class="btn btn-secondary" type="button" onclick="window.location.href='/blog'">
                    View Published
                </button>
            @endif
            @if (request()->get('drafts') == 1)
                <button class="btn btn-secondary" type="button" onclick="window.location.href='/blog'">
                    View Published
                </button>
            @else
                <button class="btn btn-secondary" type="button" onclick="window.location.href='/blog?drafts=1'">
                    View Drafts
                </button>
            @endif
            <button class="btn btn-primary" type="button" onclick="window.location.href='/blog/create'">
                + Create Post
            </button>
        @endadmin
    </div>
</x-layout>
