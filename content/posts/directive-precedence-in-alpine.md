---
slug: directive-precedence-in-alpine
title: 'Directive precedence in Alpine'
excerpt: 'Lots of people get caught out by the fact that Alpine evaluates each directive in a particular order. Let''s look at the order it uses,'
published_at: 2020-05-19T20:00:00+00:00
---
Since Alpine doesn't have a virtual DOM and doesn't compile your templates, it evaluates a component's directives procedurally, in the order that they are defined.

## Directive evaluation

When defining your directives on a component, the order **does** matter.

```html
<div x-data="{ text: 'Hello' }">
    <p x-text="text" x-bind:style="color: red;"></p>
</div>
```

In the example above, our text will be set **before** the `style` attribute is updated. This could cause problems since you will see a flash of black, or whatever the default `color` is, before the `x-bind:style` directive is evaluated.

To counter this problem, you could swap the two directives around:

```html
<div x-data="{ text: 'Hello' }">
    <p x-bind:style="color: red;" x-text="text"></p>
</div>
```

Now the `x-bind:style` is reached first, then our `x-text` directive is evaluated.

Another option would be adding `x-cloak` to the element, **at the end**.

```html
<div x-data="{ text: 'Hello' }">
    <p x-text="text" x-bind:style="color: red;" x-cloak></p>
</div>
```

Now the `<p>` will be hidden ([as long as you have the correct CSS](https://ryangjchandler.co.uk/articles/hiding-elements-until-alpine-is-ready-with-x-cloak)) until Alpine has completely initialised the element.

If you're interested in the piece of code that handles all of the evaluation, you can find it [here in the GitHub repository](https://github.com/alpinejs/alpine/blob/67493c138e9e9282dd85839f5c410791981a798f/src/component.js#L250).