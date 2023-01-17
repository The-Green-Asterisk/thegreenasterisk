<x-mail::message>
    # The Mail's Here!

    You have a new message from {{ $name }} ({{ $email }}) who used The Green Asterisk's contact form.

    {{ $message }}

    <x-mail::button :url="'mailto:' . $email">
        Reply to {{ $name }}
    </x-mail::button>

    Thanks,
    {{ config('app.name') }}
</x-mail::message>
