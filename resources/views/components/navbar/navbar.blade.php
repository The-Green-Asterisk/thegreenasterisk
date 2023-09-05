<nav>
    <ul>
        <li>
            <img src="{{ asset('asterisk.png') }}" width="20px" style="margin-bottom: 5px" />
            <a href="/">Home</a>
        </li>
        <li><a href="{{ route('about') }}">About</a></li>
        <li><a href="{{ route('blog.index') }}">Blog</a></li>
        <li><a href="{{ route('contact.index') }}">Contact</a></li>
        @auth
            <li>
                <a href="/logout">Log Out</a>
                <a href="{{ route('profile.index') }}">
                    <img src="{{ asset(Auth::user()->avatar) }}" class="avatar" width="60px" />
                </a>
            </li>
        @endauth
        @guest
            <li><a href="#" id="log-in-button">Log In</a></li>
        @endguest
    </ul>
</nav>
