@props(['class' => '', 'color' => 'blue', 'height' => '60'])

<div {{ $attributes->merge(['class' => 'w-full overflow-hidden ' . $class]) }}>
    <svg
        class="w-full"
        style="height: {{ $height }}px;"
        viewBox="0 0 1200 120"
        preserveAspectRatio="none"
    >
        <defs>
            <linearGradient id="wave-gradient-{{ $color }}" x1="0%" y1="0%" x2="100%" y2="0%">
                <stop offset="0%" stop-color="rgb(59 130 246)" stop-opacity="0.1" />
                <stop offset="50%" stop-color="rgb(147 51 234)" stop-opacity="0.2" />
                <stop offset="100%" stop-color="rgb(59 130 246)" stop-opacity="0.1" />
            </linearGradient>
            <filter id="glow-{{ $color }}">
                <feGaussianBlur stdDeviation="3" result="coloredBlur"/>
                <feMerge>
                    <feMergeNode in="coloredBlur"/>
                    <feMergeNode in="SourceGraphic"/>
                </feMerge>
            </filter>
        </defs>

        <!-- Main wave -->
        <path
            d="M0,60 C150,120 350,0 600,60 C850,120 1050,0 1200,60 L1200,120 L0,120 Z"
            fill="url(#wave-gradient-{{ $color }})"
            filter="url(#glow-{{ $color }})"
        />

        <!-- Secondary wave for depth -->
        <path
            d="M0,80 C200,40 400,100 600,80 C800,60 1000,100 1200,80 L1200,120 L0,120 Z"
            fill="url(#wave-gradient-{{ $color }})"
            opacity="0.3"
            filter="url(#glow-{{ $color }})"
        />

        <!-- Animated particles along the wave -->
        <circle cx="200" cy="40" r="2" fill="rgb(59 130 246)" opacity="0.6">
            <animateMotion dur="8s" repeatCount="indefinite">
                <path d="M200,40 Q400,20 600,40 T1000,40"/>
            </animateMotion>
        </circle>
        <circle cx="400" cy="30" r="1.5" fill="rgb(147 51 234)" opacity="0.7">
            <animateMotion dur="10s" repeatCount="indefinite">
                <path d="M400,30 Q600,10 800,30 T1200,30"/>
            </animateMotion>
        </circle>
        <circle cx="600" cy="50" r="2.5" fill="rgb(16 185 129)" opacity="0.5">
            <animateMotion dur="12s" repeatCount="indefinite">
                <path d="M600,50 Q800,30 1000,50 T1400,50"/>
            </animateMotion>
        </circle>
    </svg>
</div>
