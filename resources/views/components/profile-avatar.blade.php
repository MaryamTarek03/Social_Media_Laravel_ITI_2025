<!-- The biggest battle is the war against ignorance. - Mustafa Kemal Atatürk -->
@props(['user', 'class' => 'w-10 h-10'])
<a href="{{ route('users.show', $user) }}">
    @if($user->avatar_url)
    <img class="{{ $class }} rounded-full object-cover" src="{{ asset('storage/' . $user->avatar_url) }}">
    @else
    <div class="{{ $class }} rounded-full bg-gray-300 flex items-center justify-center">
        <svg class="h-6 w-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
        </svg>
    </div>
    @endif
</a>