---
title: Click Me Baby One More Time
date: '2020-03-29'
published: true
extends: _layouts.post
section: content
---
One of the most common things to do with JavaScript is run some function on click of a button, or other element. (hopefully it's a button though, because accessibility and that).

The first example of this pattern that comes to mind is showing and hiding something when we click a button.

Let's take a look at this inside of a Vue component, then a React component.

## Vue

```html
<template>
    <div v-if="show">
        You can see me!
    </div>
    <button type="button" v-on:click="toggle" value="Toggle">
</template>

<script>
export default {
    data() {
        return {
            show: false,
        }
    },
    methods: {
        toggle: function () {
            this.show = !this.show
        }
    }
}
</script>
```

This is quite a bit of code, I know. This can be simplified a lot but more verbosity's sake, we'll keep this format for now. 

This is simple to understand. On click of the button, the `toggle` method will be called and the value of `show` will be inverted, or toggled. If the value of `show` is truth-y, the `div` will be shown. It's super simple stuff.

Now, looking at this bit of code and this super simple component, we've managed to build up []kb of JavaScript ([]kb minified) just to toggle a `<div>`. It's a bit embarrassing.

## React

```javascript
import React, { useState } from 'react';

function App() {
    const [show, setShow] = useState(false)

    return (
        {show &&
            <div>
                You can see me!
            </div>
        }
        <button type="button" onClick={() => setShow(true)} value="Toggle">
    )
}
```

This is also a very simple component. We're using Hooks because we're cool kids. That's also the philosophy behind functional components. We're too cool for school (everyone is at the moment, coronavirus 28.03.2020).

Taking this approach for such a simple component will cost you []kb of JavaScript ([]kb minified).

## Vanilla JavaScript

For the sake of it, we'll write some vanilla JavaScript too. No frameworks, just good ol' JavaScript.

```javascript
var button = document.querySelector('button');

button.addEventListener('click', () => {
    var div = document.querySelector('div');

    if (div.style.display === 'none') {
        div.style.display = 'block';
    } else {
        div.style.display = 'hidden';
    }
});
```

This is obviously going to be the smallest in bundle size, and probably the fastest for this sort of thing. Without minification, you'd be looking at []kb. Post-minification is going to be roughly []kb.

## What was the point in all of that?

I wanted to show you how verbose the code _can_ be for such simple tasks. Even the vanilla JavaScript code is a bit ugly and requires some focus to see what's going on. Let me show you the Alpine way of doing this.

<p class="codepen" data-height="265" data-theme-id="dark" data-default-tab="html,result" data-user="ryangjchandler" data-slug-hash="JjdwxRm" data-preview="true" style="height: 265px; box-sizing: border-box; display: flex; align-items: center; justify-content: center; border: 2px solid; margin: 1em 0; padding: 1em;" data-pen-title="Alpine Toggle Visibility">
  <span>See the Pen <a href="https://codepen.io/ryangjchandler/pen/JjdwxRm">
  Alpine Toggle Visibility</a> by Ryan Chandler (<a href="https://codepen.io/ryangjchandler">@ryangjchandler</a>)
  on <a href="https://codepen.io">CodePen</a>.</span>
</p>
<script async src="https://static.codepen.io/assets/embed/ei.js"></script>

Pretty simple, I know. We've achieved the same result as the other components, but how much JavaScript have we written? Zero lines. How long have we spent setting up Webpack, Parcel or Rollup? Zero minutes (hopefully). How much JavaScript have we pulled in? Just 7kb.

All we _had_ to do was include the Alpine.js CDN, via a `<script>` tag, in our `<head>`. If there is any reason to use Alpine.js, it's for the reasons I just listed. I'll list them again for clarity:

* No custom JavaScript written
* No compilation needed, so no need to battle Webpack and co.
* No need to worry about compilation targets
* Just 7kb of JavaScript, leaving you with 7kb to squeeze into your first response
