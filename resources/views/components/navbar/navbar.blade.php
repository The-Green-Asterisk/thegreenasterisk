<nav>
    <ul>
        <li><img src="{{ asset('asterisk.png') }}" width="20px" style="margin-bottom: 5px" /><a href="/">Home</a>
        </li>
        <li><a href="/about">About</a></li>
        <li><a href="/blog">Blog</a></li>
        <li><a href="/contact">Contact</a></li>
        @auth
            <li>
                <a href="/logout">Log Out</a>
                <img src="{{ Auth::user()->avatar }}" class="avatar" width="60px" />
            </li>
        @endauth
        @guest
            <li><a href="#" onclick="logIn()">Log In</a></li>
        @endguest
    </ul>
</nav>
