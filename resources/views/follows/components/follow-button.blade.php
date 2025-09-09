@props(['user'])

@php
    $isFollowing = auth()->check() && auth()->user()->following()->where('following_id', $user->id)->exists();
    $isCurrentUser = auth()->check() && auth()->id() === $user->id;
@endphp

@if(!$isCurrentUser)
    <button
        class="follow-btn px-4 py-2 rounded-lg font-medium transition-colors duration-200 {{ $isFollowing ? 'bg-gray-500 text-white hover:bg-gray-600' : 'bg-blue-500 text-white hover:bg-blue-600' }}"
        data-user-id="{{ $user->id }}"
        onclick="{{ $isFollowing ? 'unfollowUser' : 'followUser' }}({{ $user->id }})"
    >
        {{ $isFollowing ? 'Unfollow' : 'Follow' }}
    </button>
@endif

<script>
function followUser(userId) {
    fetch(`/users/${userId}/follow`, {
        method: 'POST',
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
        alert('An error occurred while following the user.');
    });
}

function unfollowUser(userId) {
    fetch(`/users/${userId}/follow`, {
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
        alert('An error occurred while unfollowing the user.');
    });
}
</script>
