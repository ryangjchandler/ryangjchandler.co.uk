---
title: 'Writing Reusable Alpine Components'
slug: writing-reusable-alpine-components
excerpt: 'Reusability is important when it comes to scaling projects and future-proofing the maintainability of a project. Let''s take a look at how you can write more re-usable components in Alpine.'
published_at: 2020-08-30T18:30:00+00:00
category_slug: alpinejs
---
Since Alpine lives directly in the markup, it can be difficult to abstract components in the correct way. I'd like to go over a few ways that you can abstract your component logic into more re-usable components.

### The data function

When you initialise an Alpine component, you probably put the object expression directly inside of the `x-data` attribute.

This approach works well for small components that only have a couple of pieces of state and is one of Alpine's strongest selling points. It can get out of hand for larger components, especially those that have large methods for sending AJAX requests, handling form logic, etc.

The simplest way to abstract these large methods is by using functions as your data source. This is similar to how the `data()` method in Vue works, where you return an object from that function.

This is a component before being abstracted.

```html
<div x-data="{
    name: '',
    email: '',
    password: '',
    errors: {
        name: [],
        email: [],
        password: [],
    },
    validate() {
        if (! this.name) {
            this.errors.name.push('You must enter your name.')
        }

        if (this.email && ! this.email.includes('@')) {
            this.errors.email.push('You must enter a valid email address')
        }

        if (this.password && this.password.length < 8) {
            this.errors.password.push('Your password must be at least 8 characters long.')
        }
    }
}">
    <input type="text" x-model="name" @input="validate">

    <template x-for="error in errors.name">
        <p x-text="error"></p>
    </template>

    <input type="text" x-model="email" @input="validate">

    <template x-for="error in errors.email">
        <p x-text="error"></p>
    </template>

    <input type="password" x-model="password" @input="validate">

    <template x-for="error in errors.password">
        <p x-text="error"></p>
    </template>
</div>
```

Pretty nasty, right? Moving this to a function is pretty simple. You need to create a function inside of a `<script>` tag somewhere on the page and make the entire `x-data` object the return value of that function.

```html
<script>
window.profileForm = function () {
    return {
        name: '',
        email: '',
        password: '',
        errors: {
            name: [],
            email: [],
            password: [],
        },
        validate() {
            if (! this.name) {
                this.errors.name.push('You must enter your name.')
            }
    
            if (this.email && ! this.email.includes('@')) {
                this.errors.email.push('You must enter a valid email address')
            }
    
            if (this.password && this.password.length < 8) {
                this.errors.password.push('Your password must be at least 8 characters long.')
            }
        }
    }
}
</script>
```

Then replace the value of `x-data` with the name of the function, in this case `profileForm`.

```html
<div x-data="profileForm()">
    <input type="text" x-model="name" @input="validate">

    <template x-for="error in errors.name">
        <p x-text="error"></p>
    </template>

    <input type="text" x-model="email" @input="validate">

    <template x-for="error in errors.email">
        <p x-text="error"></p>
    </template>

    <input type="password" x-model="password" @input="validate">

    <template x-for="error in errors.password">
        <p x-text="error"></p>
    </template>
</div>
```

When you look at this again in the future, it will be much easier to read since you won't have the bloat of the `x-data` directive hiding all of the markup. 

**Note**: this is a simple trick for larger components but you should be careful to not abstract too early. If you are finding it difficult to manage your Alpine component from the `x-data` attribute, this one is definitely for you.

Since I'm a Laravel developer, I generally use a `@stack` on my layout file and push to it from inside of this partial.


```html
@push('scripts')
<script>
window.profileForm = function () {
    return {
        name: '',
        email: '',
        password: '',
        errors: {
            name: [],
            email: [],
            password: [],
        },
        validate() {
            if (! this.name) {
                this.errors.name.push('You must enter your name.')
            }
    
            if (this.email && ! this.email.includes('@')) {
                this.errors.email.push('You must enter a valid email address')
            }
    
            if (this.password && this.password.length < 8) {
                this.errors.password.push('Your password must be at least 8 characters long.')
            }
        }
    }
}
</script>
@endpush
```

If you're using the latest version of Laravel, you can also wrap this `@push` in an `@once` and it will only ever be pushed to the stack once in the same render.

**`x-spread`**

This directive, `x-spread`, was introduced in [v2.4 of Alpine](https://github.com/alpinejs/alpine/releases). It allows you to bind a collection of directives to a component, similar to `x-bind="{}"` in Vue.

This one kinds of follows on from the previous tip, where you can extract some re-usable logic into a function and then use `x-spread` to apply multiple directives at once.

Here's an example of a simple dropdown component built with Alpine. It involves binding some `aria-` attributes and a few click handlers. It also has no styles (but I'm sure you could make it look pretty).

```html
<div x-data="{ open: false }" @keydown.window.escape="open = false" @click.away="open = false">
    <div>
        <span>
            <button @click="open = !open" type="button" id="options-menu" aria-haspopup="true" x-bind:aria-expanded="open">
                Options
            </button>
        </span>
    </div>

    <div x-show="open">
        <div>
            <div>
                <a href="#" role="menuitem">Account settings</a>
                <a href="#" role="menuitem">Support</a>
                <a href="#" role="menuitem">License</a>
                <form method="POST" action="#">
                    <button type="submit" role="menuitem">
                        Sign out
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
```

The first step here is to move to an `x-data` function, like we did earlier. This is only going to hold a single piece of state, but it will be much easier to setup the `x-spread` directives later on.


```html
<div x-data="dropdown()" @keydown.window.escape="open = false" @click.away="open = false">
    <!-- Rest of markup here -->
</div>
```

```js
window.dropdown = function () {
    return {
        open: false
    }
}
```

To start using the `x-spread` directive, we need to define an object on our component that will be used to bind the rest of the directives. 

Let's first start with the `keydown` and `click` handlers on the parent element. I'm going to refer to this particular element as the "wrapper", so let's call the object `wrapper`.


```js
window.dropdown = function () {
    return {
        open: false,
        wrapper: {
            ['@keydown.window.escape']() {
                this.open = false
            },
            ['@click.away']() {
                this.open = false
            }
        }
    }
}
```

The `wrapper` object now contains 2 methods, each one matches the name of the directive it will replace and the function logic matches that of the expression.

**Note**: Since this is now running inside of a function, Alpine will bind your data object to the `this` context of the function so be sure to use `this.[prop]` when reading and writing props.

The only thing left to do with our wrapper element is to remove the directives and add the new `x-spread` directive:

```html
<div x-data="dropdown()" x-spread="wrapper">
    <!-- Rest of markup here -->
</div>
```

Under the hood, Alpine will go through the `wrapper` object and take each method name, setup the directive as usual and use the function as the expression / callback for the directive.

The same technique can be applied for the rest of the components too - the `trigger` and `menu` itself.

```js
window.dropdown = function () {
    return {
        open: false,
        wrapper: {
            ['@keydown.window.escape']() {
                this.open = false
            },
            ['@click.away']() {
                this.open = false
            }
        },
        trigger: {
            ['@click']() {
                this.open = ! this.open
            },
            ['x-bind:aria-expanded']() {
                return this.open
            }
        },
        menu: {
            ['x-show']() {
                return this.open
            }
        }
    }
}
```

And the markup...

```html
<div x-data="dropdown()" x-spread="wrapper">
    <div>
        <span>
            <button type="button" id="options-menu" aria-haspopup="true" x-spread="trigger">
                <!-- Button markup here -->
            </button>
        </span>
    </div>

    <div x-spread="menu">
        <!-- Rest of markup here -->
    </div>
</div>
```

### Mixins

In the context of a Vue component, [mixins](https://vuejs.org/v2/guide/mixins.html) are just a way of having small bits of re-usable code that could be used throughout your application, in multiple types of component.

Since Alpine evaluates vanilla JavaScript and all of the data is powered by an object, this pattern is even easier to achieve through the use of the [spread operator](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Spread_syntax).

Let's take our dropdown function from the previous section and use that as an example.

Imagine I had a component that needed the logic for a dropdown, but also some extra logic on top for changing the icon shown inside of a `<button>` element. The icon changing logic is only specific to this single component so it doesn't make much sense to abstract that out into the `dropdown()` function.

How about this, instead:

```html
<div x-data="{ icon: 'up', ...dropdown() }">
    <!-- Rest of markup here -->
</div>
```

It's truly that simple. Since the `window.dropdown` function returns an object when invoked, we can "spread" the contents of that object into our data and still have access to the `trigger`, `wrapper` and `menu` objects for use with `x-spread`.

This pattern is really powerful for renderless components that are likely going to be used in multiple projects too. You could move the `window.dropdown` method into a re-usable JavaScript file or package and use it anywhere and everywhere (Alpine exists), then sprinkle your styling on top (hopefully with [Tailwind](https://tailwindcss.com)).

**Note**: You should be careful of any property name clashes, for example, multiple `open` props. To workaround this, you might accept an argument to the `dropdown()` function that has a unique "key" or "prefix" and add that to each of the props returned.

## Sign off

This article was quite a long one, but these are some of the more common patterns for abstracting component logic and making your components more re-usable.

I didn't touch on server-side abstraction too much because not everybody has the power of [Blade components](https://laravel.com/docs/7.x/blade#components) at their disposal, but I'm sure you can find your own ways of doing that too.

If you enjoyed this article and found it useful, I'd love to know on [Twitter](https://twitter.com/ryangjchandler) since I would like to cover these concepts in more detail with better examples in the future.