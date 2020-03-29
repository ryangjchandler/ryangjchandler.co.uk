---
title: Advanced Alpine.js - Server Fetched Partials
date: '2020-03-29'
published: false
extends: _layouts.post
section: content
---
[Caleb](https://twitter.com/calebporzio) has been running a series on the [Laracasts](https://laracasts.com) site which goes through some useful JavaScript techniques for use with server side frameworks.

One of those episodes covered server fetched partials. That's when you make an XHR / fetch request to your server, through a regular route or API route and it returns good ol' HTML. You then insert that HTML into the DOM using JavaScript and Bobs' your uncle.

Let's use this technique in a Laravel application to fetch the contents of a dropdown from the server and insert it into the DOM using Alpine.

## The Route

We're going to setup two simple routes on the server. One that returns our main view, another that returns the partial.

```php
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/partial', function () {
    return view('partials.dropdown');
});
``` 

I've also created those two views, `index.blade.php` and `partials/dropdown.blade.php`.

Let's go into our `index` view and add the Alpine `<script>` to our `<head>`.

```html
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>
```

Let's also add some markup. Here's what I've got.

```html
<div>
    <button type="button">
        Awesome Dropdown
    </button>
    <div></div>
</div>
```

Couldn't get any simpler. We've got a `<button>` and a `<div>`. The nested `<div>` will hold our dropdown content and the `<button>` will toggle the visibility.

Let's sprinkle some magical Alpine dust in there too.

```html
<div x-data="{ show: false }">
    <button type="button" x-on:click="show = !show">
        Awesome Dropdown
    </button>
    <div></div>
</div>
```