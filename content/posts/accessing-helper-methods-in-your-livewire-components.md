---
slug: accessing-helper-methods-in-your-livewire-components
title: 'Accessing Helper Methods in Your Livewire Components'
excerpt: 'Helper methods can be, well, helpful. Did you know that you can actually write helper methods in your Livewire classes and use them really easily in your Blade views?'
published_at: 2020-08-24T10:00:00+00:00
---
Anyone who is familiar with [Livewire](https://laravel-livewire.com/) has probably used [computed properties](https://laravel-livewire.com/docs/properties#computed-properties) at some point. The magic behind them isn't actually all that magic.

Computed properties are accessed using the `$this` context of the Blade view. Livewire has a custom Blade compiler that essentially binds an instance of the component to `$this` so that magic methods can be used to intercept calls to non-existent "computed" properties.

This does open up some cool ideas though - one of them being helper methods on the component class.

## The idea

Wouldn't it be amazing if you could change:

```html
<div>
    <select wire:model="selected">
        @foreach(range(1, 100) as $number)
            <option value="{{ $number }}">
                {{ $number }}
            </option>
        @endforeach
    </select>
    
    @if($selected > 0 && $selected % 2 === 0 && $selected < 50)
        <strong>
            Congrats! Your number is even and in the correct range!
        </strong>
    @endif
</div>
```

Into this:

```html
<div>
    <select wire:model="selected">
        @foreach($this->range() as $number)
            <option value="{{ $number }}">
                {{ $number }}
            </option>
        @endforeach
    </select>
    
    @if($this->selectionIsValid())
        <strong>
            Congrats! Your number is even and in the correct range!
        </strong>
    @endif
</div>
```

All of the logic for the iterable value and whether or not a valid selection has been can be moved out of the view and into the component class.

## The how

It's not difficult. Move all of the logic into methods on the component class and Bob's your uncle, you've refactored to helper methods on your component class.

```php
class Selection extends Component
{
    public function range()
    {
        return range(1, 100);
    }
    
    public function selectedIsValid()
    {
        return $this->selected > 0 && $this->selected < 50 && $this->selected % 2 === 0;
    }
}
```

## The why

Personally, I like this approach since it my views are clearer and easier to follow. I'm not having to search through a clouded chunk of conditional mayhem to find out where something is being output. Instead, I can use appropriately named methods to describe the condition being checked and move on with my life.

Another benefit is that I can now use any `protected` or `private` dependencies from my class without needing to explicitely pass them through to the view, or use a computed property.

## Sign off

If you found this little trick useful, let me know on [Twitter](https://twitter.com/ryangjchandler) and share some examples of where you have benefited from it.

**Note**: This feature isn't documented as part of Livewire's public API, so there could be some unexpected behaviour if used incorrectly. The same API is used for computed properties so without a major version update and breaking changes, this is unlikely going to change any time soon.