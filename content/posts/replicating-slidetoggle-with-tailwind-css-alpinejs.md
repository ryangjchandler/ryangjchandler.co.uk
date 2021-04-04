---
title: 'Replicating `$.slideToggle` with Tailwind CSS & Alpine.js'
slug: replicating-slidetoggle-with-tailwind-css-alpinejs
excerpt: 'One of jQuery''s most powerful and popular features is the `slide` helpers and lots of people would like to replicate these in Alpine, so let''s take a look at how we can do just that.'
published_at: 2020-08-08T16:00:00+00:00
category_slug: alpinejs
---
I think jQuery's greatest feature is all of the animation / transition utilities. These methods truly changed how fast you can build a clean and interactive UI with some nice animations along the way.

As people move away from jQuery though, it is hard to find a solid answer on how you can achieve a similar effect to `slideToggle`. I'm going to be using Tailwind v1.2+ alongside Alpine, using some modern CSS transformation rules.

## The basics

CSS provides such really useful transformation properties that allow you to modify the appearance of an element. In this case, we want to use the `scaleY` transformation function. This will allow us to change the height of an element and Tailwind provides `scale-y-0` and `scale-y-100` classes for this.

We also want to add some transitions for this scale change, so we'll use Tailwind's `transition-` classes too.

On the Alpine side of things, we can use some `data-` attributes and event handlers to trigger the slide.

## The click

The first thing needed is some sort of trigger. I'm going to use a `<button>` for this.

```html
<button @click.prevent="">Toggle</button>
```

We also need a scale target. You could hard-code this, but I want to make this re-usable and will instead use a `data-target` attribute. We can use this to declare the query selector of our target element.

```html
<button @click.prevent="" data-target="#toggleTarget">Toggle</button>
```

It would help if that target _actually_ existed on the page. I'll make it a sibling of the `<button>`, but you could put it anywhere on the page really.

```html
<button @click.prevent="" data-target="#toggleTarget">Toggle</button>

<div id="toggleTarget"></div>
```

## The base styles

Our target also needs some classes for this to function correctly. These classes will apply some sensible defaults to the element so that we need to do less work with Alpine.

```html
<button @click.prevent="" data-target="#toggleTarget">Toggle</button>

<div id="toggleTarget"
     class="transition-transform ease-out overflow-hidden origin-top transform"
></div>
```

`transition-transform` will make sure that our target element will transform when any `transform: ...` properties change. The `ease-out` class defines our timing function, in this case: `transition-timing-function: ease-out`. 

We want to hide any overflow inside of our target so that any text doesn't hang outside of it whilst scaling. 

`origin-top` will ensure our transformation uses the **top** of the element as it's origin / base point. If you change this to `origin-bottom`, the `scale` will go from the top to the **bottom** of the element. Change this depending on which effect you prefer.

`transform` tells Tailwind to add a master `transform` rule that will react to changes of CSS custom properties, made by the `scale-y-*` classes I mentioned earlier.

## Making it move

Now that we have some basic classes on the target element, we can go ahead and start on toggle itself. I'm going to write all of this JavaScript inside of the `@click.prevent` on the `<button>`, but you are free to move this into a function.

We first need to get the target element:

```html
<button data-target="#toggleTarget"
    @click.prevent="document.querySelector($event.target.dataset.target)"
>Toggle</button>
```

Then we need to toggle the `scale-y-0` class.

```html
<button data-target="#toggleTarget"
    @click.prevent="document.querySelector($event.target.dataset.target).classList.toggle('scale-y-0')"
>Toggle</button>
```

If you add some dummy text to the target element, you'll notice that it toggles state correctly but there's no smooth animation. That is because we haven't added a `transition-duration` property to our target element.

There are a couple of options here:

1. Add a class with a default duration. For example, `duration-500` will make sure that the transformation takes **500ms** to finish.

2. Add a class and support a `data-duration` attribute to change it on a trigger basis.

The first option is pretty self-explanatory but I'd like to show you how to do the section approach too.

## `data-duration` support

Add a `data-duration` attribute to the trigger element. I'll use 700 as my default value.

```html
<button data-target="#toggleTarget"
    data-duration="700"
    @click.prevent="document.querySelector($event.target.dataset.target)"
>Toggle</button>
```

Now, inside of your click handler we need to set the property on our target element, so let's do a little refactoring too:

```html
<button data-target="#toggleTarget" 
    data-duration="700"
    @click.prevent="
        const target = document.querySelector($event.target.dataset.target)
                    
        if ($event.target.dataset.duration) {
            target.style.transitionDuration = `${$event.target.dataset.duration}ms`            
        }
                    
        target.classList.toggle('scale-y-0')
    "
>Toggle</button>
```

Since we need the target more than once, we can assign it to a constant. Then, using the `style` property of the element, set the `transitionDuration` property using the new `data-duration` attribute.

## Live example

I've made a prettier example [here](https://codepen.io/ryangjchandler/pen/YzqXzqo) for you to check out. You could take this a step-further and make a `window.$slideToggle` variable that has this as a function so that you can use it throughout your application.