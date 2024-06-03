@props(['value', 'required' => false])

@php
    $classes = [
        'block',
        'font-medium',
        'text-sm',
        'text-gray-700',
        'dark:text-gray-300',
    ];

    if (isset($required)&&$required=='true') {
        $classes[] = 'required';
    }
@endphp

<label {{ $attributes->merge(['class' => implode(' ', $classes)]) }}>
    {{ $value ?? $slot }}
</label>
