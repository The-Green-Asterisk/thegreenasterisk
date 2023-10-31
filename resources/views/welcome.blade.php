<x-layout>
    <img src="{{ asset('/steve.jpg') }}" alt="Steve" class="heroImg" />
    <p style="text-align: center">Welcome to The Green Asterisk.</p>
    <section>
        <div class="section-header">
            <a href="/blog">
                <h2>Here are the Recent Blog Posts</h2>
            </a>
        </div>
        <div class="section-wrapper">
            @foreach ($posts as $post)
                <section>
                    <h3 class="section-header">
                        <a href="{{ route('blog.show', $post->id) }}">
                            {{ $post->title }}
                        </a>
                    </h3>
                    <a href="{{ route('blog.show', $post->id) }}">
                        <img class="headerImg" src="{{ asset($post->image) }}" alt="{{ $post->title }}"
                            style="{{ !$loop->first ? ' height: 10rem;' : '' }}">
                    </a>
                    <div class="tags">
                        @foreach ($post->tags as $tag)
                            <a href="{{ route('blog.index', ['tag' => $tag->name]) }}">
                                <span class="tag">{{ $tag->name }}</span>
                            </a>
                        @endforeach
                        <div class="post-content">
                            <p>
                                {!! $post->getexcerpt() !!}
                            </p>
                        </div>
                </section>
                {!! $loop->first ? '<hr style="width: 100%">' : '' !!}
            @endforeach
    </section>
    <div class="section-wrapper">
        <section class="smaller-section">
            <div class="section-header">
                <h2>Current Projects</h2>
            </div>
            <section>
                <h3 class="section-header">
                    Gravity's Folly
                </h3>
                <p>Gravity's Folly is a campaign setting for D&D 5e that takes place in a sci-fi world where technology
                    has advanced enough as to be indistinguishable from magic! As such, the mechanical rules of magic
                    are completely unchanged from the basic D&D ruleset, but the flavor is entirely grounded in science
                    and technology</p>
                <p>Here's a <a href="{{ route('blog.show', 3) }}">blog post about it</a>, and look for more in the
                    future as it gets more
                    and more fleshed out as
                    my friends and I play through it!</p>
            </section>
            <section>
                <h3 class="section-header">
                    Catharicosa
                </h3>
                <p>Catharicosa will be a suite of platform agnostic tools for TTRPGs to make your game easier as both DM
                    and player.</p>
                <p><a href="https://notes.catharicosa.com" target="_blank">Catharicosa Notes</a> and <a
                        href="https://starship-console.catharicosa.com" target="_blank">Starship Console</a> are already
                    in the bag,
                    but look for more to come!</p>
            </section>
            <section>
                <h3 class="section-header">
                    Javascript Games
                </h3>
                <p>I made this <a href="flappy-bird" target="_blank">Flappy Bird</a> game when I was learning how to JavaScript. Play and enjoy!</p>
                <small>Disclaimer: Not the original Flappy Bird game.</small>
            </section>
        </section>
        <section class="smaller-section">
            <div class="section-header">
                <h2>Social Feed</h2>
            </div>
            @include('components.social-feed', ['social_posts' => $social_posts])
        </section>
    </div>
</x-layout>
