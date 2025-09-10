@props(['post'])

<div class="reaction-count mt-2">
    @php
        $reactionCounts = $post->reactions->groupBy('reaction_type_id');
        $totalReactions = $post->reactions->count();
    @endphp

    @if($totalReactions > 0)
        <div class="flex items-center space-x-2 text-sm text-gray-600">
            <span class="font-medium">{{ $totalReactions }} reaction{{ $totalReactions > 1 ? 's' : '' }}</span>

            @foreach($reactionCounts as $typeId => $reactions)
                @php
                    $type = \App\Models\ReactionType::find($typeId);
                    $count = $reactions->count();
                @endphp
                <span class="bg-gray-100 px-2 py-1 rounded-full">
                    {{ ucfirst($type->name) }}: {{ $count }}
                </span>
            @endforeach
        </div>
    @endif
</div>
