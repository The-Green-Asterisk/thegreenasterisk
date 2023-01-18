<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>The Green Asterisk</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('asterisk.png') }}" type="image/x-icon" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <x-loader />
    @if ($showNavbar === true)
        <x-navbar />
    @endif
    <div class="main-content" style="margin-top:{{ $showNavbar ? '4rem' : '1rem' }};">
        {{ $slot }}
    </div>
    @if ($showFooter === true)
        <x-footer />
    @endif
</body>

</html>
