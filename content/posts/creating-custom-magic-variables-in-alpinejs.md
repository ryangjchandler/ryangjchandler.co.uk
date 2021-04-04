---
slug: creating-custom-magic-variables-in-alpinejs
title: 'Creating Custom Magic Variables in Alpine.js'
excerpt: 'We all come across tasks that are repetitive and probably struggle to find ways of making them more re-usable in our Alpine components. Since v2.5 we can register custom magic variables that can help us out with that.'
published_at: 2020-08-23T16:50:00+00:00
---
DRY code is important and it can be difficult to be _completely_ DRY with your code, especially when you're using a front-end framework such as Alpine. 

There a couple of ways to reduce code duplication, especially when it comes to utility functions for string manipulation or HTTP requests. With the release of Alpine v2.5 we can register custom magic variables that will allow us to reduce that duplication without copying and pasting functions, or adding a load of functions to the global namespace.

## The entry point

All of Alpine's public API runs through a global `window.Alpine` object. Registering magic variables is no different.

A single call to `Alpine.addMagicProperty` will get you well on your way.

```js
Alpine.addMagicProperty('property', function ($el) {

});
```

The first argument is the name of the magic property. If you're familiar with Alpine, you have probably already used `$refs`, `$dispatch` or `$el`.

**The name you provide doesn't need to have any prefix, Alpine will automatically add a `$` prefix so that it is more inline with the Alpine ones.**

The second argument is the callback for the magic variable. This function will receive the root element for the component, **not** the component instance itself.

You can use this callback to return a scalar value such as a string, boolean or integer, or even return another function so that the magic variable can be invoked.

## A good example

Nowadays I try to avoid using third-party libraries (where possible) and ship JavaScript that utilises native browser APIs. Let's take this approach and create a little helper for the [Fetch API](https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API).

I want a magic variable called `$post` that will send a `POST` request to the URL provided as the first argument and pass along any data that I provide as the second argument.

```js
Alpine.addMagicProperty('post', function () {
    return function (url, data = {}) {
        return fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            redirect: 'follow',
            body: JSON.stringify(data)
        });
    }
});
```

By returning a function from our callback, we can now invoke the `$post` property:

```html
<button type="button" x-on:click="$post('/posts', { id: 1, title: 'Awesome New Post' })">
  Create Post
</button>
```

Pretty sweet, eh?

## Sign off

This was just a short article to show you the API for creating custom magic variables / properties in your Alpine components.

**Note**: This API is not documented and you should be careful using it.

If you want to see some more examples of magic properties, [Kevin Batdorf](https://twitter.com/kevinbatdorf) has created a collection of packages  / helpers for you to use. Here is [the GitHub link](https://github.com/KevinBatdorf/alpine-magic-helpers). (Huge shoutout to Kevin for being so active and helpful on the [Alpine.js Discord](https://discord.com/invite/snmCYk3) too!)

If you create any cool helper functions, please share them on [Twitter](https://twitter.com/ryangjchandler), I'm sure we'd all love to see them!