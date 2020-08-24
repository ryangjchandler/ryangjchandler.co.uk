<span {{ $attributes->merge([
    'class' => 'inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium leading-5 bg-primary-100 text-primary-800'
]) }}>
    {{ $slot }}
</span>
