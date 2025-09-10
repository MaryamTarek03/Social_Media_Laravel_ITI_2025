@props(['size' => 'md', 'color' => 'blue'])

@php
    $sizeClasses = [
        'xs' => 'h-4 w-4',
        'sm' => 'h-6 w-6',
        'md' => 'h-8 w-8',
        'lg' => 'h-12 w-12',
        'xl' => 'h-16 w-16',
    ];

    $colorClasses = [
        'blue' => 'border-blue-600',
        'gray' => 'border-gray-600',
        'white' => 'border-white',
        'green' => 'border-green-600',
        'purple' => 'border-purple-600',
    ];

    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    $colorClass = $colorClasses[$color] ?? $colorClasses['blue'];
@endphp

<div class="inline-flex items-center justify-center">
    <div class="animate-spin rounded-full {{ $sizeClass }} border-2 border-gray-300 {{ $colorClass }} border-t-transparent"></div>
    @if(isset($slot) && !$slot->isEmpty())
        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ $slot }}</span>
    @endif
</div>
