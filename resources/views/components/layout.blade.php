<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="@yield('meta_title', 'The Green Asterisk')" />
    <meta property="og:description" content="@yield('meta_description', 'Welcome to the Green Asterisk')" />
    <meta property="og:image" content="@yield('meta_image', asset('asterisk.png'))" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:site_name" content="The Green Asterisk" />
    <meta property="og:locale" content="en_US" />
    <meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}" />

    <title>{{ $title ?? 'The Green Asterisk' }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('asterisk.png') }}" type="image/x-icon" />
    <script src="https://cdn.tiny.cloud/1/o51weqkkyqtt9zegndzt9c8khol7waxhxpcmbfmjg8o5nr82/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'image link',
            toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify alignnone | indent outdent | cut copy paste | image | link unlink openlink removeformat',
            images_upload_url: '/image-upload',
            image_file_types: 'image/jpeg,image/png,image/gif',
            setup: function(editor) {
                let textarea =
                    [...document.querySelectorAll('textarea')].filter(t => t.id == editor.id)[0];
                editor.on('keyup', function(e) {
                    textarea.innerHTML = editor.getContent();
                    textarea.value = editor.getContent();
                    textarea.dispatchEvent(new Event('input'));
                });
            },
            images_upload_handler: function(blobInfo, success, failure) {
                var xhr, formData;
                xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '/image-upload');
                xhr.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]')
                    .content);
                xhr.onload = function() {
                    var json;
                    if (xhr.status != 200) {
                        failure('HTTP Error: ' + xhr.status);
                        return;
                    }
                    json = JSON.parse(xhr.responseText);
                    if (!json || typeof json.location != 'string') {
                        failure('Invalid JSON: ' + xhr.responseText);
                        return;
                    }
                    success(json.location);
                };
                formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
            }
        });
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.ts'])
</head>

<body bg="{{ isset($bg) ? $bg : asset('/bg.jpg') }}">
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
    <x-cookie-banner />
</body>

</html>
