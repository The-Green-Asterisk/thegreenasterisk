<nav>
    <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/about">About</a></li>
        <li><a href="/contact">Contact</a></li>
        @auth
            <li>
                <a href="/logout">Log Out</a>
                <img src="{{ Auth::user()->avatar }}" width="60px" />
            </li>
        @endauth
        @guest
            <li><a href="#" onclick="logIn()">Log In</a></li>
        @endguest
    </ul>
</nav>
