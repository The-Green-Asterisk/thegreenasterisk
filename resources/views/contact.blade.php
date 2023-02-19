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
        <div class="form-group">
        </div>
        <p>Are you human, or are you dancer?</p>
        <x-toggle.toggle name="turing-test" required="true" />
        <div class="button-row">
            <button type="submit" class="btn btn-primary" id="submit" disabled>Send</button>
        </div>
    </form>
</x-layout>
