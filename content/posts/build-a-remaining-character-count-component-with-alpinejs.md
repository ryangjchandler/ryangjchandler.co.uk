---
slug: build-a-remaining-character-count-component-with-alpinejs
title: 'Build a Remaining Character Count Component with Alpine.js'
excerpt: 'Learn how to build a remaining character counter in Alpine.js using only a few lines of code.'
published_at: 2020-10-29T17:00:00+00:00
---
Before we begin, let's lay down some basic markup for our character counter.

I'm going to be using `x-ref` directives to identify each part so that you can keep track of everything easily.

```html
<div>
    <textarea x-ref="content"></textarea>
    <p x-ref="remaining"></p>
</div>
```

On top of that, we need to ensure Alpine can initialise a new component. Let's add an `x-data` attribute to the root element, in this case a `<div>`, as well as a data property to hold the contents of the `<textarea>`.

```html
<div x-data="{ content: '' }">
    <textarea x-ref="content"></textarea>
    <p x-ref="remaining"></p>
</div>
```

The new `content` property hasn't been hooked up to the `<textarea>` yet. The simplest way to do this would be using `x-model`, which will add an event listener to the element and update the property with the elements `value` property.

```html
<div x-data="{ content: '' }">
    <textarea x-ref="content" x-model="content"></textarea>
    <p x-ref="remaining"></p>
</div>
```

With data binding setup, all that's left to do is output the number of remaining characters. To do this, we need to know how many characters the content has and what the limit is. 

I like to use `data` attributes for variable pieces of data, such as the character limit. I'll add a new `data-limit` attribute to hold this.

```html
<div x-data="{ content: '' }" data-limit="100">
    <textarea x-ref="content" x-model="content"></textarea>
    <p x-ref="remaining"></p>
</div>
```

The reason I like using `data` attributes is because if you later decide to move the data object into a function, you can still see the arguments that change the behaviour of the component directly in the markup.

I'm also going to add a new property on our component to hold the limit.

```html
<div x-data="{ content: '', limit: $el.dataset.limit }" data-limit="100">
    <textarea x-ref="content" x-model="content"></textarea>
    <p x-ref="remaining"></p>
</div>
```

> If you don't want to use a data attribute for the `limit`, you could put the value directly in the data object instead.

The `$el` object being used is a magic variable provided by Alpine and is a reference to the root element (the `<div>`). Since this is just a regular `Element` object, we can use the `dataset` property to get the `data-limit`.

There are a couple of ways to go about actually _outputting_ the remaining characters. I'll cover both of them here, since you might like one more than the other.

### Method One - template literals

Using Alpine's `x-text` alongside [template literals](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Template_literals), you can dynamically set the `innerText` of an element. 

Applying this method to the element looks a little something like:

```html
<div x-data="{ content: '', limit: $el.dataset.limit }" data-limit="100">
    <textarea x-ref="content" x-model="content"></textarea>
    <p x-ref="remaining" x-text="`You have ${limit - content.length} characters remaining."></p>
</div>
```

### Method Two - dynamic `<span>`

Compared to the first method, this approach will only update the `innerText` of a single child element instead of the entire `<p>` element.

This means that you can render the non-dynamic content on the server, or statically.

```html
<div x-data="{ content: '', limit: $el.dataset.limit }" data-limit="100">
    <textarea x-ref="content" x-model="content"></textarea>
    <p x-ref="remaining">
        You have <span x-text="limit - content.length"></span> characters remaining.
    </p>
</div>
```

## Improvements

### Preventing flashing content

I personally prefer using server-rendered content to give the `<span>` some default text. In a Laravel application, I might do something like:

```html
<div x-data="{ content: '', limit: $el.dataset.limit }" data-limit="{{ $limit }}">
    <textarea x-ref="content" x-model="content"></textarea>
    <p x-ref="remaining">
        You have <span x-text="limit - content.length">{{ $limit }}</span> characters remaining.
    </p>
</div>
```

In this case, the `$limit` variable is coming from the server and will be rendered as the default value inside of the `<span>` element. This helps with "flashing" content, since Alpine needs some time to evaluate the `x-text` directive and set the `innerText` of the element.

> You could also tackle the "flashing" problem using `x-cloak`, as described in [this article](https://ryangjchandler.co.uk/articles/hiding-elements-until-alpine-is-ready-with-x-cloak).

### Using a "computed property"

Alpine doesn't support computed properties in the same sense as Vue, but since the data object is just a regular object literal, you can make use of JavaScript's "getters", as described in [this article](https://ryangjchandler.co.uk/articles/an-alternative-approach-to-computed-properties-in-alpinejs).

This can hide the calculation logic from the directive itself:

```html
<div x-data="{
    content: '',
    limit: $el.dataset.limit,
    get remaining() {
        return this.limit - this.content.length
    }
}" data-limit="100">
    <textarea x-ref="content" x-model="content"></textarea>
    <p x-ref="remaining">
        You have <span x-text="remaining"></span> characters remaining.
    </p>
</div>
```

## Sign off

If you would like to see an interactive version of this component, I've uploaded [one to CodePen](https://codepen.io/ryangjchandler/pen/ZEOrVPM).

If you enjoyed this article or have any feedback, please feel free to let me know on [Twitter](https://twitter.com/ryangjchandler).

Thanks for reading! 👋