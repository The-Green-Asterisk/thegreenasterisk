<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'The Green Asterisk' }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('asterisk.png') }}" type="image/x-icon" />
    <script src="https://cdn.tiny.cloud/1/o51weqkkyqtt9zegndzt9c8khol7waxhxpcmbfmjg8o5nr82/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'image',
            toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify alignnone | indent outdent | cut copy paste | image | removeformat',
            images_upload_url: '/image-upload',
            image_file_types: 'image/jpeg,image/png,image/gif',
            images_upload_handler: function(blobInfo, success, failure) {
                var xhr, formData;
                xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '/image-upload');
                xhr.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').content);
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
