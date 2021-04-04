---
title: 'Hiding elements until Alpine loads with `x-cloak`'
slug: hiding-elements-until-alpine-is-ready-with-x-cloak
excerpt: '`x-cloak` can be used to hide elements until Alpine has initialised all components and has control of them.'
published_at: 2020-05-15T16:00:00+00:00
category_slug: alpinejs
---
If you've used Alpine before, you might have seen a brief flick when you load your site up. This is common if you have components that are conditionally rendered and are hidden by default.

What's happening is the DOM is ready before Alpine takes controls of the element, so it shows up and then disappears. It can be quite jarring if you have lots of components on your site.

To counter the problem, Alpine will look for an `x-cloak` attribute and remove it once it has loaded. This lets you defined some CSS that will set the element to `display: none` when the page loads.

Add this bit of CSS to your site:

```css
[x-cloak] {
    display: none !important;
}
```

And Bob's your uncle, the flicker problem has been fixed!