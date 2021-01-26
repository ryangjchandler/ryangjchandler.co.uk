<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent ring-offset-2 rounded-md font-semibold text-xs text-white uppercase tracking-widest ring-opacity-75 hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-black disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
