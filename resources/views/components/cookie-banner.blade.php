<div id="cookie-banner">
    <p>
        Just so you know, I use digital cookies the same way I use real cookies. They make your experince better,
        and I never share them. If you're okay with that, click the button.
    </p>
    <button id="cookie-banner-button" class="btn" onclick="cookieBannerButtonClicked()">Accept</button>
</div>

<script>
    const cookieBanner = document.getElementById('cookie-banner');
    const cookieBannerButton = document.getElementById('cookie-banner-button');
    const cookieBannerButtonClicked = () => {
        cookieBanner.style.display = 'none';
        document.cookie = 'cookies_are_cool=true; path=/; max-age=31536000';
    };
    cookieBannerButton.addEventListener('click', cookieBannerButtonClicked);
    if (document.cookie.indexOf('cookies_are_cool=true') === -1) {
        cookieBanner.style.display = 'block';
    } else {
        cookieBanner.style.display = 'none';
    }
</script>
