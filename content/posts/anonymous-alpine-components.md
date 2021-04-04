---
slug: anonymous-alpine-components
title: 'Anonymous Alpine Components'
excerpt: 'One of Alpine''s main selling points is that it provides most of the reactive goodies that Vue and React do at a much lower cost. What if you don''t need reactivity for your site? Well, Alpine can definitely still fit into your stack!'
published_at: 2020-04-18T23:00:00+00:00
---
At it's core, Alpine depends on an `x-data` attribute. At the time of writing this article, there isn't any other way to let Alpine know your component exists. One fun fact is that your `x-data` attribute can actually be empty and have no value at all.

```html
<div x-data="{}"></div>

// this gets treated the same as above
<div x-data></div>
```

Alpine will default to using an empty object literal, so you don't have to worry about it. By doing this, we aren't setting up any data properties that need to be reactive in our UI, but we can still take advantage of Alpine's Vue-esque event binding syntax.

```html
<div x-data>
  <button x-on:click="eventHandler()">Click me!</button>
</div>
```

I like to call this concept _Anonymous Components_, since Alpine has no data context to keep track of. If you're familiar with Laravel and the new Blade Components in version 7, you would have heard the same name being used for components that have no class handler and are simply regular Blade views (Thanks [Dries](https://twitter.com/driesvints)!).

## Why though?

The real question is "Why not?". Let's list the alternative routes:

1. Inline event registration using `<button onclick="eventHandler()">`
2. Event property registration using `el.onclick = eventHandler`
2. Registering event listeners using `el.addEventListener('click', eventHandler)`.

This anonymous component approach is, syntactically, most similar to option number one. You are registering the event listener / handler using an attribute on the element itself. 

Option number two is nearly the same, except this code needs to be executed from inside of a `<script>` tag, much like option number three.

Despite some of the performance problems with option number one, before using Alpine, I wouldn't actually have a problem with doing this for smaller components on my sites.

When looking at the markup, I can clearly see what function is going to be called when the event fires and for which event it is triggered for. Unless I actually need to edit or write the function, there is no need to switch context either. I don't need to do a project wide search for this function, or traipse through JavaScript files to find where and when the function is being called.

Under the hood, Alpine is using option number three (`addEventListener`) to actually register the event so the only performance bottleneck is going to be how quickly Alpine can traverse the DOM and find the `x-on:` or `@` attributes. Given the small size of Alpine and it's declarative nature, this is something I'm quite happy to forget about since it's going to be minimally different from writing the code myself in an inline `<script>` tag, or importing a JavaScript file.

## Things to be aware of

If you decide to use this approach in your applications, there are a couple of things to keep in mind.

### Your function / handler must be defined on the global scope

This can become a problem if you are transpiling / bundling your JavaScript, since it's normally scoped down to the module level automatically. 

To circumvent this problem, explicitly define your functions on the `window` variable:

```javascript
// bad
function eventHandler() {
  ...
}

// good
window.eventHandler = function () {
  ...
}
```

### You need the parentheses in the expression

In other Alpine components, you might choose to define functions on the data object itself. When doing this, you can reference your event callback functions without the ending `()` parentheses. Alpine does this automatically for functions defined on your data object by checking the return value of your expression, then calling it if it is of the type `function`.

If you are using a function that's defined on the global scope, you will need to add those `()` parentheses yourself.

```html
// bad
<button x-on:click="eventHandler">Click me</button>

// good
<button x-on:click="eventHandler()">Click me</button>
```

### The event won't be automatically passed through

When using functions defined on your data object (as mentioned above), your function will receive a magic `$event` property as the first argument. This behaviour is the same as any other event handler in JavaScript, most commonly shortened to a single `e`.

Since we're having to put the parentheses in yourselves, we'll also need to pass through any of those mystical Alpine properties too.

```html
<button x-on:click="eventHandler($event)">Click me</button>
```

Now we can access properties such as `$event.target` or `$event.type` in our function.

### You don't have to write a function

All the way through this post, I've used a function on the global scope as my event handler. Since Alpine will evaluate the expression inside of the attribute, you could also write some inline JavaScript too.

```javascript
<button x-on:click="$event.target.style.display = 'none'">Hide me</button>
```

## Sign off

This is probably my current favourite use case for Alpine. Sure, the reactivity is cool but this can be so much cooler.

If you do get stuck with this approach at all, feel free to ask me questions on [Twitter @ryangjchandler](https://twitter.com/ryangjchandler). I've also put a quick example [here on CodePen](https://codepen.io/ryangjchandler/pen/wvKzypX?editors=1111).

Thanks for sticking around this far, have a good one!