@props([
    'name',
    'class' => '',
])

@php
    $icon = strtolower(trim((string) $name));
    $classes = trim('inline-block h-5 w-5 shrink-0 '.$class);
@endphp

@switch($icon)
    @case('arrow_forward')
        <svg {{ $attributes->merge(['class' => $classes, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '2', 'aria-hidden' => 'true']) }}>
            <path d="M5 12h14" stroke-linecap="round" stroke-linejoin="round" />
            <path d="m13 5 7 7-7 7" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        @break

    @case('keyboard_arrow_down')
    @case('expand_more')
        <svg {{ $attributes->merge(['class' => $classes, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '2', 'aria-hidden' => 'true']) }}>
            <path d="m6 9 6 6 6-6" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        @break

    @case('chevron_left')
        <svg {{ $attributes->merge(['class' => $classes, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '2', 'aria-hidden' => 'true']) }}>
            <path d="m15 18-6-6 6-6" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        @break

    @case('chevron_right')
        <svg {{ $attributes->merge(['class' => $classes, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '2', 'aria-hidden' => 'true']) }}>
            <path d="m9 18 6-6-6-6" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        @break

    @case('search')
        <svg {{ $attributes->merge(['class' => $classes, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '2', 'aria-hidden' => 'true']) }}>
            <circle cx="11" cy="11" r="7" />
            <path d="m20 20-3.5-3.5" stroke-linecap="round" />
        </svg>
        @break

    @case('menu')
        <svg {{ $attributes->merge(['class' => $classes, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '2', 'aria-hidden' => 'true']) }}>
            <path d="M4 7h16M4 12h16M4 17h16" stroke-linecap="round" />
        </svg>
        @break

    @case('close')
        <svg {{ $attributes->merge(['class' => $classes, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '2', 'aria-hidden' => 'true']) }}>
            <path d="m6 6 12 12M18 6 6 18" stroke-linecap="round" />
        </svg>
        @break

    @case('download')
        <svg {{ $attributes->merge(['class' => $classes, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '2', 'aria-hidden' => 'true']) }}>
            <path d="M12 4v10" stroke-linecap="round" />
            <path d="m7 10 5 5 5-5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M5 20h14" stroke-linecap="round" />
        </svg>
        @break

    @case('download_done')
        <svg {{ $attributes->merge(['class' => $classes, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '2', 'aria-hidden' => 'true']) }}>
            <path d="m5 12 4 4L19 6" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M5 20h14" stroke-linecap="round" />
        </svg>
        @break

    @case('bookmark')
        <svg {{ $attributes->merge(['class' => $classes, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '2', 'aria-hidden' => 'true']) }}>
            <path d="M7 4h10a1 1 0 0 1 1 1v15l-6-4-6 4V5a1 1 0 0 1 1-1Z" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        @break

    @case('share')
        <svg {{ $attributes->merge(['class' => $classes, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '2', 'aria-hidden' => 'true']) }}>
            <circle cx="18" cy="5" r="3" />
            <circle cx="6" cy="12" r="3" />
            <circle cx="18" cy="19" r="3" />
            <path d="m8.6 10.8 6.8-4.1M8.6 13.2l6.8 4.1" stroke-linecap="round" />
        </svg>
        @break

    @case('public')
        <svg {{ $attributes->merge(['class' => $classes, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '2', 'aria-hidden' => 'true']) }}>
            <circle cx="12" cy="12" r="9" />
            <path d="M3 12h18M12 3a15 15 0 0 1 0 18M12 3a15 15 0 0 0 0 18" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        @break

    @case('alternate_email')
    @case('email')
        <svg {{ $attributes->merge(['class' => $classes, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '2', 'aria-hidden' => 'true']) }}>
            <rect x="3" y="5" width="18" height="14" rx="2" />
            <path d="m4 7 8 6 8-6" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        @break

    @case('robot')
        <svg {{ $attributes->merge(['class' => $classes, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '2', 'aria-hidden' => 'true']) }}>
            <rect x="5" y="8" width="14" height="10" rx="3" />
            <path d="M12 4v4M8 12h.01M16 12h.01M9 16h6" stroke-linecap="round" />
        </svg>
        @break

    @case('edit_square')
        <svg {{ $attributes->merge(['class' => $classes, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '2', 'aria-hidden' => 'true']) }}>
            <path d="M4 20h4l10-10-4-4L4 16v4Z" stroke-linejoin="round" />
            <path d="m12 6 4 4" stroke-linecap="round" />
        </svg>
        @break

    @case('hub')
        <svg {{ $attributes->merge(['class' => $classes, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '2', 'aria-hidden' => 'true']) }}>
            <circle cx="12" cy="12" r="2" />
            <circle cx="5" cy="7" r="2" />
            <circle cx="19" cy="7" r="2" />
            <circle cx="5" cy="17" r="2" />
            <circle cx="19" cy="17" r="2" />
            <path d="M7 7l3.2 3M17 7l-3.2 3M7 17l3.2-3M17 17l-3.2-3" stroke-linecap="round" />
        </svg>
        @break

    @case('bolt')
        <svg {{ $attributes->merge(['class' => $classes, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '2', 'aria-hidden' => 'true']) }}>
            <path d="M13 2 5 14h6l-1 8 8-12h-6l1-8Z" stroke-linejoin="round" />
        </svg>
        @break

    @case('integration_instructions')
        <svg {{ $attributes->merge(['class' => $classes, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '2', 'aria-hidden' => 'true']) }}>
            <path d="m8 8-4 4 4 4M16 8l4 4-4 4M13 5l-2 14" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        @break

    @case('auto_stories')
        <svg {{ $attributes->merge(['class' => $classes, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '2', 'aria-hidden' => 'true']) }}>
            <path d="M4 6a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v12a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2V6Z" stroke-linejoin="round" />
            <path d="M8 8h7M8 12h7" stroke-linecap="round" />
        </svg>
        @break

    @case('topic')
        <svg {{ $attributes->merge(['class' => $classes, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '2', 'aria-hidden' => 'true']) }}>
            <path d="M6 7h12M6 12h8M6 17h10" stroke-linecap="round" />
        </svg>
        @break

    @case('verified')
        <svg {{ $attributes->merge(['class' => $classes, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '2', 'aria-hidden' => 'true']) }}>
            <path d="m7 12 3 3 7-7" stroke-linecap="round" stroke-linejoin="round" />
            <circle cx="12" cy="12" r="9" />
        </svg>
        @break

    @case('link')
        <svg {{ $attributes->merge(['class' => $classes, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '2', 'aria-hidden' => 'true']) }}>
            <path d="M10 14 8 16a3 3 0 1 1-4-4l3-3a3 3 0 0 1 4 0" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M14 10l2-2a3 3 0 1 1 4 4l-3 3a3 3 0 0 1-4 0" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M8 12h8" stroke-linecap="round" />
        </svg>
        @break

    @default
        <svg {{ $attributes->merge(['class' => $classes, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '2', 'aria-hidden' => 'true']) }}>
            <circle cx="12" cy="12" r="8" />
        </svg>
@endswitch
