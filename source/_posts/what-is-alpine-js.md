---
title: What is Alpine.js?
date: 2020-03-28
published: true
extends: _layouts.post
section: content
---
If you're a part of the Laravel community, you've probably already heard of Alpine. It's a minimalistic JavaScript framework that ditches the virtual DOM in favour of raw DOM updates and operations.

Syntactically, it's inspired by Vue. This isn't a problem because Vue has the most beginner friendly and natural syntax in my opinion.

Let me show you where it all starts:

```html
<div x-data="{}">
    <span>Sweet, sweet content.</span>
</div>
```

Everything in Alpine begins with a custom attribute, `x-data`. If you come from the Vue world, this is essentially the `data` property on one of your components. Alpine will search through your DOM, find all of the elements with this attribute and set them up for some sweet vanilla reactivity.

### What can I put in this attribute?

That's a good question. In the same way as your Vue component data, the `x-data` attribute should contain a JavaScript object, something like this:

```html
<div x-data="{ foo: 'bar' }">
    <span>Sweet, sweet content.</span>
</div>
```

When the DOM is scanned, Alpine will take this `x-data` attribute, run it through a clever little `eval` function (don't worry, it's not the regular core `eval()` function) that is powered by `Function` objects and then start to observe the data.

> One thing to note here is that Alpine does not observe the original data object directly. Instead, it will make a clone of that object and store it elsewhere for observations.

