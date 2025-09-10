@props(['post'])
@php
// Check if the authenticated user has reacted to the post
$userReaction = auth()->check() ? $post->reactions->firstWhere('user_id', auth()->id()) : null;
@endphp


@auth
<!-- when authenticated it is a button -->
<form method="POST" action="{{ route('reactions.store', $post) }}" class="inline">
    @csrf
    <button type="submit" class="flex items-center text-gray-500 hover:text-red-600 transition-colors duration-200">
        <svg class="h-4 w-4 mr-1 {{ $userReaction ? 'text-red-600' : '' }}" fill="{{ $userReaction ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
        <span class="text-xs">{{ $post->reactions->count() }}</span>
    </button>
</form>
@else
<!-- when not authenticated it is not a button -->
<span class="flex items-center text-gray-500">
    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
    </svg>
    <span class="text-xs">{{ $post->reactions->count() }}</span>
</span>
@endauth