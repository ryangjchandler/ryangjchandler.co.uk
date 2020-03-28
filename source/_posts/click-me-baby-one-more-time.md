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

### Vue

```html
<template>
    <div v-if="show">
        You can see me!
    </div>
    <button type="button" v-on:click="toggle">
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

### React

