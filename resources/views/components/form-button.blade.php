@props(['method' => 'POST', 'action'])

<form action="{{ $action }}" method="POST">
    @csrf
    @method($method)
    <button {{ $attributes }}>{{ $slot }}</button>
</form>
