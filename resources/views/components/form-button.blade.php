<form action="{{ $action }}" method="POST">
    @csrf
    @method($method ?? 'POST')

    <button class="{{ $buttonClasses ?? '' }}" style="{{ $style ?? '' }}">{{ $slot }}</button>
</form>
