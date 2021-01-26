@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'shadow-sm border-gray-300 focus:ring-offset-2 focus:border-gray-700 focus:ring focus:ring-black focus:ring-opacity-75']) !!}>
