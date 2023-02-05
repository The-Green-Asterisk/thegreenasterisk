<x-layout>
    <h1>Make Contact</h1>
    <form method="post" action="{{ route('contact.store') }}">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label><br>
            <input type="text" class="form-control" id="name" name="name" required
                placeholder="Hi, what's your name?">
        </div>
        <div class="form-group">
            <label for="email">Email:</label><br>
            <input type="email" class="form-control" id="email" name="email" required
                placeholder="Let me know your email address so I can contact you back!">
        </div>
        <div class="form-group">
            <label for="message">Message:</label><br>
            <textarea class="form-control" id="message" name="message" rows="5" required
                placeholder="Write whatever you want here, but if it's rude I reserve the right to ignore it."></textarea>
        </div>
        <script src="https://www.google.com/recaptcha/enterprise.js?render=6Lf8XVAkAAAAAFm2UBRv7vkP8Fh6MPGBqQ-XW6Kh"></script>
        <script>
            grecaptcha.enterprise.ready(function() {
                grecaptcha.enterprise.execute('6Lf8XVAkAAAAAFm2UBRv7vkP8Fh6MPGBqQ-XW6Kh', {
                    action: 'login'
                }).then(function(token) {
                    console.log(token);
                });
            });
        </script>
        <script src="https://www.google.com/recaptcha/enterprise.js" async defer></script>

        <div class="g-recaptcha" data-sitekey="site_key" data-action="LOGIN"></div>
        <br />

        <div class="button-row">
            <button type="submit" class="btn btn-primary">Send</button>
        </div>
    </form>
</x-layout>
