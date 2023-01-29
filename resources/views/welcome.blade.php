<x-layout>
    <img src="{{ asset('/steve.jpg') }}" alt="Steve" class="heroImg" />
    <p>Welcome to The Green Asterisk.</p>
    @admin
        <p>You are an admin.</p>
    @endadmin
    <section>
        <div class="section-header">
            <a href="/blog">
                <h2>Recent Blog Posts</h2>
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
            <div class="section-content">
                <div class="project">
                    <div class="project-header">
                        <h3>Project 1</h3>
                    </div>
                    <div class="project-content">
                        <p>Project 1 content.</p>
                    </div>
                </div>
                <div class="project">
                    <div class="project-header">
                        <h3>Project 2</h3>
                    </div>
                    <div class="project-content">
                        <p>Project 2 content.</p>
                    </div>
                </div>
                <div class="project">
                    <div class="project-header">
                        <h3>Project 3</h3>
                    </div>
                    <div class="project-content">
                        <p>Project 3 content.</p>
                    </div>
                </div>
        </section>
        <section class="smaller-section">
            <div class="section-header">
                <h2>Social Feed</h2>
            </div>
            @include('components.social-feed', ['social_posts' => $social_posts])
        </section>
    </div>
</x-layout>
