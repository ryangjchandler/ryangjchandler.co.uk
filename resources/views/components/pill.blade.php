@props(['color' => 'gray'])

@php
    $classes = [
        'gray' => 'bg-gray-100 text-gray-800',
    ][$color];
@endphp

@if($attributes->has('href'))
    <a {{ $attributes->whereStartsWith('href') }} class="normal-case inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $classes }}">
        {{ $slot }}
    </a>
@else
    <span class="normal-case inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $classes }}">
        {{ $slot }}
    </span>
@endif

