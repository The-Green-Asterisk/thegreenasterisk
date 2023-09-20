<x-mail::message>
# New Comment!

You have a new comment from [{{ $name }}](mailto:{{ $email }}) on The Green Asterisk's blog post, [{{ $post->title }}]({{ route('blog.show', $post) }}). Here's what they said:

>{!! $comment !!}

Thanks,
{{ config('app.name') }}

</x-mail::message>
