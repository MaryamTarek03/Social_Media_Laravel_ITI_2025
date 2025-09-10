<!-- The biggest battle is the war against ignorance. - Mustafa Kemal Atatürk -->
@props(['user', 'class' => 'w-10 h-10'])

<a href="{{ route('users.show', $user) }}">
    @if($user->avatar_url && !\Illuminate\Support\Str::contains($user->avatar_url, 'http'))
    <img class="{{ $class }} rounded-full object-cover" src="{{ asset('storage/' . $user->avatar_url) }}">
    @else
    <img class="{{ $class }} rounded-full object-cover" src="{{ asset('assets/default-avatar.png') }}">
    @endif
</a>