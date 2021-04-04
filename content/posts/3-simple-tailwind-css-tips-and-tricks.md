---
slug: 3-simple-tailwind-css-tips-and-tricks
title: '3 Simple Tailwind CSS Tips and Tricks'
excerpt: 'Here are 3 simple Tailwind CSS tips and tricks that you can start applying and using in your Tailwind based applications right now!'
published_at: 2021-01-24T17:00:00+00:00
---
## 1. Always know the current breakpoint

Finding it hard to remember what breakpoint you're currently viewing your screen at? Struggle no more!

Install the `tailwindcss-debug-screens` plugin and you'll be provided with a small visual helper in the bottom-left of your site.

Run this command in your project directory:

```bash
npm install tailwindcss-debug-screens --save-dev
```

Then register the plugin in your Tailwind configuration file:

```js
module.exports = {
    //...
    plugins: [
        require('tailwindcss-debug-screens'),
    ]
}
```

And finally add the new `debug-screens` class to your `<body>` tag:

```html
<body class="debug-screens">
```

> You should ensure that this class is only added to the `<body>` in development. Wrap the class inside of a conditional or exclude the plugin at part of your build process.

## 2. Create a visual breakpoint separator

This is definitely one that you can start implementing in your project. Have you ever seen any class lists like this?

```html
<h1 class="text-xl text-gray-500 focus:text-gray-800 hover:text-gray-800 mb-1 sm:text-2xl sm:mb-2 md:text-3xl md:mb-4 xl:text-5xl">
```

These can get rather large, rather quickly. As they get larger and more breakpoint-specific classes come into play, it can get harder to see each breakpoints styles.

One trick that I like to use is inserting a style-less / marker class between each breakpoints section.

```html
<h1 class="text-xl text-gray-500 focus:text-gray-800 hover:text-gray-800 mb-1 | sm:text-2xl sm:mb-2 | md:text-3xl md:mb-4 | xl:text-5xl">
```

In this case, I'm using a single `|` as the marker for a new breakpoint. It gives each section some breathing room but also provides a visual indicator for where a new screen definition starts.

> You could use any valid CSS class here instead, but a `|` is very common for separating things in many contexts.

## 3. Give your text editor / IDE some Tailwind love

There are plenty of great extensions out there for improving your Tailwind development experience. Here are some of my favourites and ones I would highly recommend to any Tailwind developer.

### [Tailwind CSS Intellisense for VS Code](https://tailwindcss.com/docs/intellisense)

This is an official extension for Visual Studio Code and comes with some really, _really_ neat features.

* Autocompletion for class names and CSS functions.
* Linting of your classes and CSS files.
* Syntax highlighting of custom Tailwind directives.
* Hover previews that show entire CSS definitions for CSS classes.

I think it's great when a project develops a first-party extension for their own tool. It adds a certain degree of reliability and trust.

### [Headwind](https://marketplace.visualstudio.com/items?itemName=heybourn.headwind)

Headwind is a Tailwind class sorter extension for Visual Studio Code. The documentation states that _"It enforces consistent ordering of classes by parsing your code and reprinting class tags to follow a given order"_.

I've been using this one for quite a while now and once you get used to the order, it can make finding a class in a long list much easier.

> If you're a PhpStorm user, you can get a [Headwind port plugin here](https://plugins.jetbrains.com/plugin/13376-tailwind-formatter).