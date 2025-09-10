<!-- Walk as if you are kissing the Earth with your feet. - Thich Nhat Hanh -->
@props(['comment'])
<div class="p-6">
    <div class="flex space-x-3">
        <x-profile-avatar :user="$comment->user" class="h-8 w-8" />
        <div class="flex-1">
            <div class="flex items-center space-x-2">
                <h4 class="text-sm font-medium text-gray-900">{{ $comment->user->name }}</h4>
                <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
            </div>
            <p class="mt-2 text-sm text-gray-700">{{ $comment->content }}</p>
        </div>
    </div>
</div>