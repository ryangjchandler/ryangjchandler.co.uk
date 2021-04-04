---
title: 'Maintainable Alpine Components'
slug: organising-your-alpine-components
excerpt: 'Writing maintainable code is an important part of any software project. Let''s take a look at some ways you can make your Alpine components more maintainable.'
published_at: 2020-05-15T11:00:00+00:00
category_slug: alpinejs
---
I've been using Alpine for the last couple of months in most of my projects and have experimented with different organisation patterns that improve the maintainability of my components.

I'd like to take you through some of them, as well as the pros and cons of each.

## Data functions

This one shouldn't be new to regular Alpine users. This approach replaces the inline `x-data` object literal with a function that returns an object instead.

``` html
<div x-data="data()">
    <p x-text="text"></p>
</div>

<script>
    function data() {
        return {
            text: "Hello, World!"
        }
    }
</script>
```

**Pros**:

* For component with larger datasets, it's far easier to manage than an object string.
* You can add methods to the returned object that it also easier to manage.
* Makes using Alpine with third-party libraries simpler.

**Cons**:

* Function must be defined on the `window` object, so a large number of unique components starts to add lots of bloat to the global namespace.
* These objects aren't structured in any particular way, your data is sat directly next to your methods.
* When placed in an inline `<script>` tag, you lose the ability to minify your JavaScript and reduce data transfer sizes.

**Summary**

This approach works great for small sites and developers who don't mind explicitely putting everything under `window` . It's also useful if you're integrating with third party libraries that interact with your Alpine components.

## Async components

If you have used Vue before, you'll probably be familiar with the concept of asynchronous components, a design pattern that only loads the component / JavaScript when a particular component is needed.

This is especially useful when using code-splitting / browser-supported ES modules. I'll show you an example using browser-supported ES modules:

``` javascript
// index.js (loaded in browser using <script type="module">
;(async function() {
    if (document.querySelector('[x-data="example()"]')) {
        await import('./components/example.js').then(module => window['example'] = module.default)
    }
})()

// ./components/example.js
export default function() {
    return {
        message: 'Hello!',
        clear() {
            this.message = ''
        }
    }
}
```

The code above is taking advantage of [**dynamic imports**](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/import#Dynamic_Imports). This is supported in all major modern browsers, not IE11. If you need to support IE11, I'd suggest creating a separate bundle that has support for it.

In this instance, we are checking to see if any `example` components are found on the page. If one is found, we want to load the code for that component. This is stored inside `components/example.js` . Again, this example is using ES modules hence the exports.

When the component is found on the page, we want to dynamically import the file responsible for the component and assign the default export to a `window.example` variable so that Alpine can call it.

**Pros**:

* Uses modern JavaScript features with no transpilation, can run directly in the browser.
* Only the code that is needed gets loaded, so no unnecessary data transfer.
* Component logic can be separated into individual files, on a component by component basis.

**Cons**:

* Uses modern JavaScript features with no transpilation so won't run directly in IE11.
* Won't be useful when dynamically inserting content into page, since it does not re-evaluate on page mutation, but this could easily be fixed with a `MutationObserver` .
* Still a big blur of data properties and logical methods.
* Still using puts functions on `window` object.

To counter the last "con", I've found a way that makes it clearer what is what in my head.

``` javascript
// utils.js
export const buildComponent = (data, methods, __init) {
    return () => {
        return {
            ...data,
            ...methods,
            __init
        }
    }
}
```

Inside of your component file, you can then import this function and use it to separate your data, methods and init method.

``` javascript
import { buildComponent } from '../utils.js'

const data = {
    message: 'Hello!',
}

const methods = {
    clear() {
        this.message = ''
    }
}

export default buildComponent(data, methods)
```

The only thing that I don't like about _this_ approach is referencing `this` inside of my methods doesn't give my any autocomplete, nor is it clear what `this` is.

## Laravel Blade Components

For Laravel developers, this one will most likely work the best.

Instead of using regular partials, you can turn your Alpine component into a Blade component and use it like a regular HTML element.

``` html
// components/input.blade.php
<div x-data="{ text: '' }">
    <input x-model="text" {{ $attributes }}>
</div>

// index.blade.php
<div>
    <x-input type="text" name="hello" id="hello" />
</div>
```

Unless your smaller components are being used in lots of different places, this probably won't be useful for most sites. For larger components, such as modals and dropdowns, you can nicely hide all of the logic in your component file and still pass the regular HTML attributes through.

If you're using JavaScript functions to setup your component and data, you could add a custom `@pushonce` directive so that you can use inline `<script>` tags. The idea behind this is that you include a `<script>` tag with the component, inside of the `@pushonce` directive that is pushed to an `@stack` in your layout file.

This approach is going to be most similar to a single file Vue component, since you have your markup, JavaScript and you could even `@pushonce` your CSS too.

**Pros**:

* Excellent reusability of both the markup and the JavaScript.
* Most familiar to Vue single file component pattern.
* Fluent use of HTML-like tags, with support for passing regular attributes through.

**Cons**:

* Requires Laravel (or a Blade package for external use).
* JavaScript being inlined with `@pushonce` can't be minified.
* Only really good for high usage components, no real gain for single use components.

Here's that `@pushonce` directive for you:

``` php
Blade::directive('pushonce', function ($expression) {
    [$pushName, $pushSub] = explode(':', trim(substr($expression, 1, -1)));

    $key = '__pushonce_'.str_replace('-', '_', $pushName).'_'.str_replace('-', '_', $pushSub);

    return "<?php if(! isset(\$__env->{$key})): \$__env->{$key} = 1; \$__env->startPush('{$pushName}'); ?>";
});
				 
Blade::directive('endpushonce, function () {
    return '<?php $__env->stopPush(); endif; ?>';
});
```

### Outside of Laravel

If you're using other frameworks, or completely different languages, most templating engines have the concept of partials where you could apply the same pattern, just without the nice HTML-ish tags.

## Sign off

I'm glad you made it this far. These were just a couple of tips on organising your Alpine components and how I've personally been doing it recently.

As the project evolves, there will definitely be new and improved ways to do this so I'll be sure to keep an eye out for new ideas and share them with you all too.

I'd also like to say another thank you for sponsoring me, it means a lot that people are genuinely interested and support what I do. As always, all feedback is welcome no matter how good or bad it is, so let me know what you thought through [Twitter](https://twitter.com/ryangjchandler) or Discord.

Have a good one! 👋