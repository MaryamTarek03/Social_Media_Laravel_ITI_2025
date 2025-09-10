@props(['post'])

<div class="reaction-buttons flex items-center space-x-1">
    @php
        $userReaction = $post->reactions->where('user_id', auth()->id())->first();
        $reactionTypes = \App\Models\ReactionType::all();
    @endphp

    @foreach($reactionTypes as $type)
        <button
            class="reaction-btn group flex items-center space-x-1 px-3 py-2 rounded-xl text-sm font-medium transition-all duration-200 hover:scale-105 {{ $userReaction && $userReaction->reaction_type_id == $type->id ? 'bg-blue-500 text-white shadow-lg' : 'bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-slate-600' }}"
            data-post-id="{{ $post->id }}"
            data-reaction-type-id="{{ $type->id }}"
            onclick="reactToPost({{ $post->id }}, {{ $type->id }})"
        >
            @if($type->name === 'like')
                <svg class="w-4 h-4 {{ $userReaction && $userReaction->reaction_type_id == $type->id ? 'text-white' : 'text-blue-500' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                </svg>
            @elseif($type->name === 'love')
                <svg class="w-4 h-4 {{ $userReaction && $userReaction->reaction_type_id == $type->id ? 'text-white' : 'text-red-500' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                </svg>
            @elseif($type->name === 'haha')
                <svg class="w-4 h-4 {{ $userReaction && $userReaction->reaction_type_id == $type->id ? 'text-white' : 'text-yellow-500' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 100-2 1 1 0 000 2zM13 9a1 1 0 100-2 1 1 0 000 2zM6 12a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                </svg>
            @elseif($type->name === 'wow')
                <svg class="w-4 h-4 {{ $userReaction && $userReaction->reaction_type_id == $type->id ? 'text-white' : 'text-orange-500' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                </svg>
            @elseif($type->name === 'sad')
                <svg class="w-4 h-4 {{ $userReaction && $userReaction->reaction_type_id == $type->id ? 'text-white' : 'text-blue-600' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 100-2 1 1 0 000 2zM13 9a1 1 0 100-2 1 1 0 000 2zM6 12a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                </svg>
            @elseif($type->name === 'angry')
                <svg class="w-4 h-4 {{ $userReaction && $userReaction->reaction_type_id == $type->id ? 'text-white' : 'text-red-600' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            @endif
            <span class="hidden sm:inline">{{ ucfirst($type->name) }}</span>
        </button>
    @endforeach

    @if($userReaction)
        <button
            class="remove-reaction-btn flex items-center space-x-1 px-3 py-2 rounded-xl text-sm font-medium bg-red-500 text-white hover:bg-red-600 transition-all duration-200 hover:scale-105 shadow-lg"
            data-post-id="{{ $post->id }}"
            onclick="removeReaction({{ $post->id }})"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span class="hidden sm:inline">Remove</span>
        </button>
    @endif
</div>

<script>
function reactToPost(postId, reactionTypeId) {
    fetch(`/posts/${postId}/react`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            reaction_type_id: reactionTypeId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while reacting to the post.');
    });
}

function removeReaction(postId) {
    fetch(`/posts/${postId}/react`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while removing the reaction.');
    });
}
</script>
