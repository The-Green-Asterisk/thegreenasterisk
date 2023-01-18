<x-layout>
    <img src="{{ asset('/steve.jpg') }}" alt="Steve" class="heroImg" />
    <p>Welcome to The Green Asterisk.</p>
    @admin
        <p>You are an admin.</p>
    @endadmin
    <section>
        <div class="section-header">
            <h2>Recent Blog Posts</h2>
        </div>
        <div class="section-content">
            <div class="post">
                <div class="post-header">
                    <h3>Post 1</h3>
                </div>
                <div class="post-content">
                    <p>Post 1 content.</p>
                </div>
            </div>
            <div class="post">
                <div class="post-header">
                    <h3>Post 2</h3>
                </div>
                <div class="post-content">
                    <p>Post 2 content.</p>
                </div>
            </div>
            <div class="post">
                <div class="post-header">
                    <h3>Post 3</h3>
                </div>
                <div class="post-content">
                    <p>Post 3 content.</p>
                </div>
            </div>
        </div>
    </section>
    <div class="section-wrapper">
        <section>
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
        <section>
            <div class="section-header">
                <h2>Social Feed</h2>
            </div>
        </section>
    </div>
</x-layout>
