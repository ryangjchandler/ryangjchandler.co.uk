---
title: "The Magic Behind Reactivity - Effects"
slug: the-magic-behind-reactivity-effects
excerpt: |
    Let's take our `reactive` function and start reacting to data changes.
published_at: 2021-06-18T17:01:00+00:00
category_slug: javascript
---

In the [previous instalment](/posts/the-magic-behind-reactivity-proxies), we created a `reactive` function that accepts an object and returns a new `Proxy` instance.

If you're not sure what a `Proxy` is or how it works, definitely go back and read that post.

In this post, I'll be creating an `effect` function that will allow us to react to changes on the `Proxy` and update the DOM.

## What is an "effect"?

An effect is a side-effect of a data change. Generally speaking, it's a function that should be run when a particular piece of data changes.

Here's a good example:

```html
<p id="greeting">Hello, reader!</p>
```

At the moment, this text is completely static. If we use an `effect` function, we can actually make this dynamic.

```js
const greeting = document.querySelector("#greeting");

const data = reactive({
    greeting: "Hello, reader!",
});

effect(() => {
    greeting.innerText = data.greeting;
});
```

We haven't written the `effect` function yet, so let's start implementing it now.

```js
function effect(callback) {
    callback();
}
```

This version of `effect` is the bare minimum. When we register an effect, we want to invoke / call it immediately to update the DOM.

## Running effects when state changes

If you were to do something like `data.greeting = 'Hello, John!'`, nothing will happen. Our DOM node won't be updated, which isn't very helpful.

What we can do is store all the `effect` callbacks in an array and call each one when our `Proxy` is updated.

```js
const effects = [];

function effect(callback) {
    effects.push(callback);

    callback();
}
```

Inside of the `Proxy.set` handler, we can loop through the `effects` array and call each callback.

```js
function reactive(object) {
    // ...

    return new Proxy(object, {
        // ...
        set(target, property, value) {
            target[property] = reactive(value);

            effects.forEach((effect) => {
                effect();
            });

            return true;
        },
    });
}
```

If we were to now run `data.greeting = 'Hello, John!'`, the DOM node's `innerText` property will be updated with the value `Hello, John!`.

## More efficient updates

The current system works quite well for small bits of reactivity, such as text changes or attribute changes.

If we were to have 50 different effects though, things would get a little bit out of hand and performance would take quite a big hit. That's because each change we make to `data` will invoke every callbacks inside of `effects` and if you're doing anything intensive such as AJAX requests, big loops or heavy DOM updates, your page will slow to a snail's pace.

To work around this issue, we can introduce **dependency tracking**. This is really just a fancy phrase for figuring out what data an `effect` callback is using.

The major benefit of dependency tracking is the fact that we will be able to only invoke / call the functions that were using the data being changed.

The first thing we need to do is update our `effect` callback slightly:

```js
const effects = new Map();
let currentEffect = null;

function effect(callback) {
    currentEffect = callback;

    callback();

    currentEffect = null;
}
```

When we register a new `effect`, we will assign the callback to a `currentEffect` variable and remove the old `effects` array. This will allow us to reference the callback inside of our `Proxy.get` function later on.

We'll also want to store the effects for a particular `Proxy` somewhere. The best way to do this is with a `Map` object.

The `Map` object provides you with a key/value storage, similar to a normal object. The main difference is that you're not limited to string-based keys, you can actually store objects in the key.

This means we can store the `target` from our Proxy in the key and then an object literal (`{}`) in the value.

Here's an example:

```js
const map = new Map();

const data = {
    user: "Ryan",
};

map.set(data, {
    user: [() => {}],
});

map.get(data)["user"]; // This returns an array containing an anonymous function.
```

Let's also make some changes to the `Proxy.get` method:

```js
let effects = new Map;

function reactive(object) {
    //...

    return new Proxy(object, {
        get(target, property) {
            if (currentEffect === null) {
                return target[property];
            }

            if (! effects.has(target)) {
                effects.set(target, {});
            }

            const targetEffects = effects.get(target);

            if (! targetEffects[property]) {
                targetEffects[property] = [];
            }

            targetEffects[property].push(currentEffect)

            return target[property];
        },
        // ...
    });
```

Here's a breakdown of what's happening now:

1. Check if `currentEffect` is not null. If it's `null`, we want to just return the property without doing any tracking. It will only hold a value when `effect()` is doing something.
2. Check whether our `Map` has any entries for the `target` object. If it doesn't, we need to insert an empty object into the `Map` using `Map.set()`.
3. We can then pull that object back out using `Map.get(target)`.
4. We need to check whether the current `property` being accessed on the `target` has an entry inside of the object returned into `targetEffects`. If it doesn't, we can simply write to the object using `[]` notation.
5. Finally we can return the `target[property]` so that it still behaves like a normal object.

All of this combined allows us to track which properties are being used inside of `currentEffect`. Cool, right?

### Running effects on change

Now that we know which `effect` callbacks rely on certain pieces of data, i.e. `property`, we can run only the required callbacks inside of `Proxy.set`.

```js
let effects = new Map;

function reactive(object) {
    // ...

    return new Proxy(object, {
        // ...
        set(target, property, value) {
            target[property] = reactive(value);

            if (effects.has(target)) {
                const targetEffects = effects.get(target)

                targetEffects[property].forEach(effect => {
                    effect()
                })
            }

            return true;
        },
    });
}
```

Here's a breakdown of the logic:

1. We need to check whether the current `target` has any `effects` register. If it doesn't, we don't want to do anything as it will error out.
2. Then we want to pull all of the `targetEffects` for that `target`.
3. Once we have those effects, we can get the array for the `property` being updated and loop over it, invoking / calling each item in the array.

## Wrapping up

And that's it! We now have a reactive object and an `effect` function that is invoked each time a relevant property in our `data` is updated.

In the next instalment, I'll show you how to create a reactive data object from an HTML attribute, similar to Alpine's `x-data`.

Until then, thank you for reading and I'll catch you next time!
