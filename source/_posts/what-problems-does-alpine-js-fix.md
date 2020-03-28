---
title: What problems does Alpine.js fix?
date: '2020-03-29'
published: false
extends: _layouts.post
section: content
---
Okay, I'll warn you now - this article is very slightly mistitled. I am going to explain some of the problems that Alpine.js aims to fix but I'm also going to pose a couple of additional questions too.

### Huge JavaScript Bundles

I've not got a massive problem with larger bundle sizes, but **only** when they are necessary. For example, if you're using Vue or React to build a modern single page monolith, then a larger bundle size is expected. Even if you go down the route of using a lighter weight alternative such as Preact, your bundle sizes are still going to be large after you include all of your components and utility functions, then any custom hooks that you've got.

I _do_ however have a problem with huge bundle sizes when the only JavaScript that you're using is for a simple dropdown or tabs component. I understand why people do it. They're comfortable with a particular framework and using that framework will save them some time. I tell you what it _won't_ save them though, precious kilobytes of your user bandwidth. Especially on mobile devices and mobile networks.

Why not pull in a library like Alpine instead? Save yourself the effort of writing the actual JavaScript and place it all in your markup. I'd guess, on average, you'll be saving around 20-30kb of bandwidth, just on your JavaScript.

### Virtual DOM

Generally, I don't have a problem with libraries / frameworks that use a virtual DOM. I do have a problem with needless computation for simple components though.

I 