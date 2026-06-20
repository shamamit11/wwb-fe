@props([
    'name',
    'class' => '',
])

<span {{ $attributes->merge(['class' => "material-symbols-outlined {$class}"]) }}>{{ $name }}</span>
