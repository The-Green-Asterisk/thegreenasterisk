<x-layout>
    <img class="avatar" src="{{ $user->avatar }}"
        title="Avatar is determined by your login service. Log out and in again to refresh.">
    <form action="{{ route('profile.update', Auth::user()) }}" method="POST">
        @method('PUT')
        @csrf
        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ $user->name }}">
        <input type="hidden" name="email" value="{{ $user->email }}">
        <button class="btn btn-primary" type="submit">Update</button>
    </form>

</x-layout>
