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

I _do_ however have a problem with huge bundle sizes when the only JavaScript that you're using is for a simple dropdown or tabs component. I understand why people do it. They're comfortable with a particular framework and using that framework will save them some time. I tell you what it _won't_ save them though, precious megabytes of your user bandwidth. Especially on mobile devices and mobile networks.