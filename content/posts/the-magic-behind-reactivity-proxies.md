---
title: "The Magic Behind Reactivity - Proxies"
slug: the-magic-behind-reactivity-proxies
excerpt: |
    Reactive JavaScript frameworks are full of magic. In this series, I'll cover the basics of
    reactivity in JavaScript, starting with proxies.
published_at: 2021-06-18T17:00:00+00:00
category_slug: javascript
---

In this short series of blog posts, I'm going to be showing you how reactive JavaScript frameworks such as [Alpine.js](https://alpinejs.dev) and [Vue.js](https://vuejs.org/) work under the hood.

We'll begin by understanding the `Proxy` object in JavaScript and create our own budget version of `Alpine.reactive()`.

## What is `Proxy`?

The `Proxy` object was introduced as part of the ES2015 specification. It allows you to intercept the basic operations on an object, for example retrieving a property, setting a property or deleting a property.

You're able to define your own callbacks / handlers for these operations. This is similar to how PHP's `__get` and `__set` magic methods work.

You receive the target object, the name of the property being accessed and when setting, the value that's being assigned.

Here's an example:

```js
const proxy = new Proxy(
    {
        count: 0,
    },
    {
        get(target, property) {
            return target[property];
        },
        set(target, property, value) {
            target[property] = value;

            return true;
        },
    }
);
```

The code above shows a very basic `Proxy` handler. The behaviour implemented inside of the `get` and `set` methods isn't anything special, it's just returning the `property` from `target` and setting it to `value`. It's really just a regular object.

If we wanted to get fancy, we could put a `console.log` inside of the `get()` handler.

```js
const proxy = new Proxy(
    {
        count: 0,
    },
    {
        get(target, property) {
            console.log(`Trying to access ${property}.`);

            return target[property];
        },
    }
);

proxy.count;
```

When the `proxy.count` expression is evaluated, the `console.log` will be called and appear in your console.

One thing that confuses people a lot about `Proxy` is that it **doesn't** change how you interact with the underlying value.

If you wrap an `Array` in a `Proxy`, you can still do `myWrappedArray.push` or `myWrappedArray.filter`.

## Creating a function

Now that we know what a `Proxy` is, let's create a new function:

```js
function reactive(object) {
    return new Proxy(object, {
        get(target, property) {
            return target[property];
        },
        set(target, property, value) {
            target[property] = value;

            return true;
        },
    });
}
```

One thing that we haven't covered in this function is nested `Proxy` instances. Imagine the following scenario:

```js
const user = reactive({
    name: 'Ryan',
    address: {
        postcode: 'TT1 1TT'
    }
})

// How do we intercept this!?
user.address.postcode = 'TT2 2TT';
```

When we update `user.address.postcode`, the `set` handler in our `Proxy` won't be called as the `address` object inside of `user` isn't reactive. 

Don't worry, this is easy to fix. We can recursively call `reactive` for each of the properties on our original `object` when they're `typeof` is `object`.

```js
function reactive(object) {
    if (object === null || typeof object !== 'object') {
        return object;
    }

    for (const property in object) {
        object[property] = reactive(object[property])
    }

    return new Proxy(object, {
        get(target, property) {
            return target[property];
        },
        set(target, property, value) {
            target[property] = reactive(value);

            return true;
        },
    });
}
```

Voila! When the `object` passed into `reactive` has any nested objects, they will also be passed through `reactive` recursively. 

When we `set` the value of a property, we'll also pass the `value` through `reactive` to ensure that any objects are wrapped in a `Proxy` too.

## Wrapping up

And with that, we've created a semi-functional version of `Alpine.reactive()`. The only thing that our `reactive` function doesn't do yet is update or trigger any function calls.

We'll look at creating a basic version of `Alpine.effect()` in the next instalment.

Until then, thank you for reading and I'll catch you next time!
