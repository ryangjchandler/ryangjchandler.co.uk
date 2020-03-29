---
title: Alpine by Example - Tabs
date: '2020-03-29'
published: false
extends: _layouts.post
section: content
---
When learning a new framework or library, I find it much easier to learn the basic concepts and patterns by building something. That's why, in this series, I'm going to walk through the process of building some common components with Alpine.js, so that you can hopefully learn how to use it and incorporate it into your own projects.

This entry will go over the process of building a tabs component that is both accessible and easily reusable.

First, let's include the Alpine.js `<script>` tag in the `<head>` of our document.

```html
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
```

I'll go through each step I normally take when building something new. If you prefer to see the final piece of code, I'll include a CodePen embed towards the end so you can go and try it out.

I will also be using Tailwind to style the final result, but for the sake of leaner code snippets, I'll leave out the classes in the article.

## Setting the Scene

I want to create a set of tabs that provide some information about the features that Alpine.js has. There should be **3 tabs**, each with their own unique title and content.

I should be able to move through and "activate" each tab using the keyboard, as well as visually see which tab is active.

## The Markup

When building out a new component or project, I like to start with the actual markup. This helps me understand what needs to go where and what needs to happen when I click X, or hover over Y.

Here's what I've got:

```html
<div>
    <div>
        <button>
            Declarative Syntax
        </button>
        <button>
            Lightweight
        </button>
        <button>
            Reactive
        </button>
    </div>
    <div>
        This is the declarative syntax tab...
    </div>
    <div>
        This is the lightweight tab...
    </div>
    <div>
        This is the reactive tab...
    </div>
</div>
```

Super simple stuff. We've got three `<button>`s, wrapped inside of a single `<div>`. Then we have three extra `<div>`s for the tab content.

This could work for our Alpine, but I want this to be accessible. Let's sprinkle some `aria-` attributes in there, along with some `role` and `tabindex` attributes too.

## Accessibility

If you don't care about accessibility (you should), then skip this section. I'm just going to throw some extra attributes into our markup to make it a friendlier to screen readers and other helpers.

```html
<div>
    <div role="tablist" aria-label="Features">
        <button role="tab" 
            aria-selected="true" 
            aria-controls="declarative-syntax-tab" 
            id="declarative-syntax"
        >
            Declarative Syntax
        </button>
        <button role="tab" 
            aria-selected="true" 
            aria-controls="lightweight-tab" 
            id="lightweight"
            tabindex="-1"
        >
            Lightweight
        </button>
        <button role="tab" 
            aria-selected="true" 
            aria-controls="reactive-tab" 
            id="reactive-syntax"
            tabindex="-1"
        >
            Reactive
        </button>
    </div>
    <div tabindex="0"
        role="tabpanel"
        id="declarative-syntax-tab"
        aria-labelledby="declarative-syntax"
    >
        This is the declarative syntax tab...
    </div>
    <div tabindex="0"
        role="tabpanel"
        id="lightweight-tab"
        aria-labelledby="lightweight"
    >
        This is the lightweight tab...
    </div>
    <div tabindex="0"
        role="tabpanel"
        id="reactive-tab"
        aria-labelledby="reactive"
    >
        This is the reactive tab...
    </div>
</div>
```

Phew... that took a little while. Trust me though, it's worth the effort. We've added some `role` attributes so that accessibility APIs can understand the semantics behind our markup. The same goes for the `aria-` attributes.

Lots of these attributes are currently being hardcoded, but for some of those `aria-` attributes, we want to change the values when a tab is active / focused, etc.

Let's start to sprinkle some interactive goodness on top of our markup.

## Interactivity

Let's start off by making this an Alpine.js component.

```html
<div x-data="{}">
    ...
</div>
```

That's simple enough. Now we need to keep track of some data, but what data exactly? Well, we want to know what tab is currently active, so we'll add a `tab` data property. Off the top of my head, I can't think of anything else.

The beauty of Alpine.js is that if we need to add a new data property, we don't need to recompile our JavaScript, we can just edit our markup and add it in.

Here's what we've got now at the root of our component.

```html
<div x-data="{ tab: 'declarative-syntax' }">
    ...
</div>
```

We're setting the value of our tab to `declarative-syntax` so that the first tab is active by default.

Now, let's get those tabs changing. 

Alpine will let us use an expression as the value of a directive. Let's hide our tabs, based on the value of our `tab` data property.

```html
<div x-data="{ tab: 'declarative-syntax' }">
    ...
    <div tabindex="0" x-show="tab === 'declarative-syntax'" role="tabpanel" id="declarative-syntax-tab" aria-labelledby="declarative-syntax">
        This is the declarative syntax tab...
    </div>
    <div tabindex="0" x-show="tab === 'lightweight'" role="tabpanel" id="lightweight-tab" aria-labelledby="lightweight">
        This is the lightweight tab...
    </div>
    <div tabindex="0" x-show="tab === 'reactive'" role="tabpanel" id="reactive-tab" aria-labelledby="reactive">
        This is the reactive tab...
    </div>
</div>
```