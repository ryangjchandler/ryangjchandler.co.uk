---
title: What is Alpine.js?
date: '2020-03-28'
published: false
extends: _layouts.post
section: content
---
If you're a part of the Laravel community, you've probably already heard of Alpine. It's a minimalistic JavaScript framework that ditches the virtual DOM in favour of raw DOM updates and operations.

Syntactically, it's inspired by Vue. This isn't a problem because Vue has the most beginner friendly and natural syntax in my opinion.

Let me show where it all starts:

```html
<div x-data="{}">
    <span></span>
</div>
```