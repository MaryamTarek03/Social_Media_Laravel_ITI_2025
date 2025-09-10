@props(['post'])

<div class="reaction-buttons flex items-center space-x-2">
    @php
        $userReaction = $post->reactions->where('user_id', auth()->id())->first();
        $reactionTypes = \App\Models\ReactionType::all();
    @endphp

    @foreach($reactionTypes as $type)
        <button
            class="reaction-btn px-3 py-1 rounded-full text-sm font-medium transition-colors duration-200 {{ $userReaction && $userReaction->reaction_type_id == $type->id ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}"
            data-post-id="{{ $post->id }}"
            data-reaction-type-id="{{ $type->id }}"
            onclick="reactToPost({{ $post->id }}, {{ $type->id }})"
        >
            {{ ucfirst($type->name) }}
        </button>
    @endforeach

    @if($userReaction)
        <button
            class="remove-reaction-btn px-3 py-1 rounded-full text-sm font-medium bg-red-500 text-white hover:bg-red-600 transition-colors duration-200"
            data-post-id="{{ $post->id }}"
            onclick="removeReaction({{ $post->id }})"
        >
            Remove Reaction
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
