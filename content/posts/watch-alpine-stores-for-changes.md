---
title: 'How to Watch Alpine Stores for Changes'
slug: how-to-watch-alpine-stores-for-changes
excerpt: |
    One of Spruce's more powerful features was `Spruce.watch`. With the introduction of `Alpine.store`, let's take a look at how we can watch our store properties for changes too.
published_at: 2021-07-08T12:00:00+00:00
category_slug: alpinejs
---

With Alpine 2.x and Spruce, you could define a global store and also a watcher for a particular store property:

```js
Spruce.store('counter', {
    count: 0,
})

Spruce.watch('counter.count', () => {
    // Do something here...
})
```

Anytime the `counter.count` property was updated, the callback would be called.

With the introduction of `Alpine.store` in Alpine 3.x there is no longer a dedicated watch method for stores, but we can still get the same effect with `Alpine.effect` (no pun intended):

```js
Alpine.store('counter', {
    count: 0,
})

Alpine.effect(() => {
    const count = Alpine.store('counter').count;

    // Now do something with `count`...
})
```

This works because Alpine will keep track of any dependencies / reactive properties we use inside of the callback and invoke it when any of them change.

Keep in mind that Alpine will run this callback function **atleast once**, so make sure you check for your initial state and prevent anything from happening.
