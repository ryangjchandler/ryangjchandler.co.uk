---
title: 'Share Data With Your Frontend in Laravel'
slug: share-data-with-your-frontend-in-laravel
excerpt: 'Sharing data with your frontend doesn''t need to be difficult, let''s look at a couple of way of doing it.'
published_at: 2020-06-26T13:00:00+00:00
category_slug: laravel
---
Have you ever needed access to the current user's name or email address in your applications JavaScript? There are many different ways it can be done, but let's take a look at the 2 simplest methods.

## Constrained access

It's not always the best idea to put this data everywhere on your site. You might only need it when working with a particular element or view, this is where `data-` attributes come in handy.

Given the following HTML, I need to show the current user's name when the button is clicked, otherwise, just show a generic "Hello" message. By default, it will show the generic message.

```html
<button type="button" id="show">Show Email Address</button>
<p id="message">Hello</p>
```

Let's add a `data-name` attribute to the `<p>` element.

```html
<button type="button" id="show">Show Email Address</button>
<p id="message" data-name="{{ $user->name }}">Hello</p>
```

Now if we want to access it inside of our JavaScript, we can:

```js
document.getElementById('show').addEventListener('click', el => {
    const el = document.getElementById('message')
    
    el.innerText = `Hello, ${el.dataset.name}`
})
```

Any `data-*` attributes can be accessed using the "camel case" equivalent. For example, `data-first-name` can be accessed using `el.dataset.firstName`.

In the case you have a model, you'll need to `{{ $user->toJson() }}` in the Blade template and then `JSON.parse(el.dataset.user)` in JavaScript to access it correctly.

## Global object

The next one is useful if you've got loads of different scripts that rely on the data.

In a layout file, we can add a `<script>` somewhere in `<head>` of the document.

```html
<head>
    <script>
        window.sharedData = {}
    </script>
</head>
```

It's just an empty object, but there is 2 different approaches we can take here. Either declare the property using JavaScript and ensure we `json_encode()` each value, or instead `json_encode()` an associative array and let PHP handle it all (nearly).

### Each item

```html
<head>
    <script>
        window.sharedData = {
            user: {{ json_encode(auth()->user()) }},
            ids: {{ json_encode([1, 2, 3]) }}
        }
    </script>
</head>
```

### Associative array

```html
<head>
    <script>
        window.sharedData = json_encode([
            'user' => auth()->user(),
            'ids' => [1, 2, 3],
        ])
    </script>
</head>
```

It's worth noting that any objects that get serialized will have all of their `public` properties exposed in the resulting object.

If you want to customise the serialized form, you can implement the `JsonSerializable` interface and add a `jsonSerialize()` method. This method should return an array with the things you'd like to expose.

## Going beyond

The methods above don't take all scenarios into account. For example, any class that implements the `Arrayable` or `Jsonable` contracts won't be serialized using the `toArray()` or `toJson()` methods.

You should also be careful of any HTML or double quotes when serialising user-created values. I'd suggest passing through the `JSON_HEX_QUOT | JSON_HEX_APOS` flags to `json_encode()`. These flags will convert all `"` and `'` to their Unicode equivalent.

There are plenty of packages out there that can share server-side values with your client-side scripts ([coderello/js-shared-data](https://github.com/coderello/js-shared-data) comes to my mind), but for the simpler cases, the 2 methods above should be enough.