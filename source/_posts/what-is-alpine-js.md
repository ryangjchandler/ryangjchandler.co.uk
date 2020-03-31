---
title: What is Alpine.js?
date: 2020-03-28T00:00:00.000Z
published: true
categories: [javascript]
extends: _layouts.post
section: content
---
If you're a part of the Laravel community, you've probably already heard of Alpine. It's a minimalistic JavaScript framework that ditches the virtual DOM in favour of raw DOM updates and operations. The documentation says to *Think of it like [Tailwind](https://tailwindcss.com/) for JavaScript.*

Syntactically, it's inspired by Vue. This isn't a problem because Vue has the most beginner friendly and natural syntax in my opinion.

Let me show you where it all starts:

```html
<div x-data="{}">
    <span>Sweet, sweet content.</span>
</div>
```

Everything in Alpine begins with a custom attribute, `x-data`. If you come from the Vue world, this is essentially the `data` property on one of your components. Alpine will search through your DOM, find all of the elements with this attribute and set them up for some sweet vanilla reactivity.

## What can I put in this attribute?

That's a good question. In the same way as your Vue component data, the `x-data` attribute should contain a JavaScript object, something like this:

```html
<div x-data="{ foo: 'bar' }">
    <span>Sweet, sweet content.</span>
</div>
```

When the DOM is scanned, Alpine will take this `x-data` attribute, run it through a clever little `eval` function (don't worry, it's not the regular core `eval()` function) that is powered by `Function` objects and then start to observe the data.

> One thing to note here is that Alpine does not observe the original data object directly. Instead, it will make a clone of that object and store it elsewhere for observations.

## Okay, that's cool. How do I use this data?

It's simple. Just like Vue, Alpine provides a variety of different directives that can be used to access and control your data.

Let's start by making the text inside of the `span` match the value of our `foo` data property.

```html
<div x-data="{ foo: 'bar' }">
    <span x-text="foo"></span>
</div>
```

Now, when we view this HTML inside of the browser, we'll see that our `<span>` has the word `bar` inside of it. Want to know the best part of this? There is no virtual DOM, no crazy diff process going on. Just 7kb of JavaScript.

### Changing the value of data properties

The example above is a bit pointless really. There's no way for us to change the value of `foo` so it's just static. Let's change this now by adding an input field.

```html
<div x-data="{ foo: 'bar' }">
    <span x-text="foo"></span>
    <input type="text" x-model="foo">
</div>
```

Alpine provides another directive `x-model` which acts the same way as the one in Vue. Whenever we change the value inside of the input, our `foo` property will be updated and the text inside of our `<span>` will react.

I've put this on CodePen so you can play around with it [here](https://codepen.io/ryangjchandler/pen/oNXJaKg).

## Show me more

I'm going to post some more articles on using Alpine and how it might be able to replace Vue or React in some of your applications.

If you want to get ahead of the game, check out [the README file in the GitHub repo](https://github.com/alpinejs/alpine) which is the current official documentation.

Let me know what you thought about this article on Twitter! I'm always up for improving my writing so every opinion is welcome.
