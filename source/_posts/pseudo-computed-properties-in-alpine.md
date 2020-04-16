---
title: Pseudo Computed Properties in Alpine
date: 2020-04-16
published: true
categories: [tips-and-tricks, javascript]
---

I've been trying to use [Alpine.js](https://github.com/alpinejs/alpine) more and more throughout my projects, both personal and professional. At work, most of the JavaScript is still using good ol' jQuery (yeah, I know 🤦‍♂️) so it's been super nice to sprinkle some lightweight reactivity and interactive goodness in there too.

Most of Vue's general API has been matched in Alpine. The directives, modifiers and general functionality is near enough identical. One thing that Alpine doesn't have out of the box is [computed properties](https://vuejs.org/v2/guide/computed.html). In reality a computed property is just a function that returns a value, as opposed to a property with a value assigned to it directly.

My example for this article will be reversing a string. Let's take a look at the Vue implementation first, taken straight from the docs:

## Vue

```html
<div id="example">
    <p>Original message: "{{ message }}"</p>
    <p>Computed reversed message: "{{ reversedMessage }}"</p>
</div>
```

```js
var vm = new Vue({
    el: '#example',
    data: {
        message: 'Hello'
    },
    computed: {
        // a computed getter
        reversedMessage: function() {
            // `this` points to the vm instance
            return this.message.split('').reverse().join('')
        }
    }
})
```

When we take a look at the HTML in the browser, we get this:

![Vue Computed Properties Example](/assets/images/vue-computed-properties.png)

When we use `{{ reversedMessage }}` in our HTML / template, Vue will look for a property inside of the `computed` array with the same name and call the function to get the value.

## Alpine

Let's try and recreate this with Alpine:

```html
<div x-data="data()">
    <p>Original message: "<span x-text="message"></span>"</p>
    <p>Computed reversed message: "<span x-text="reversedMessage"></span>"</p>
</div>
```

```js
function data() {
    return {
        message: 'Hello',
        reversedMessage: function () {
            return this.message.split('').reverse().join('')
        }
    }
}
```

This is what we get:

![Alpine Computed Properties Attempt](/assets/images/alpine-computed-properties-1.png)

The problem here is that Alpine doesn't know that our `reversedMessage` expression inside of `x-text` needs to be evaluated as a function. Instead, the function gets casted to a string by the browser.

The way to fix this would be by changing `reversedMessage` to `reversedMessage()` and voila:

![Alpine Computed Properties Working](/assets/images/alpine-computed-properties-2.png)

Now it's calling the function and setting the return value as the text for our element. It's really that easy! I'm calling these "pseudo computed properties" since Alpine doesn't automatically determine whether or not the property is a function, but they are actually computed properties.

These computed properties are reactive too. Changing the value of `message` using an `<input>` field or similar would update the computed value too.

## Sign off

The example a above is a bit redundant and could actually be done as an inline expression with Alpine & Vue. This might become more useful for certain types of data, such as the price of a product. You could use a computed property to prefix the output with a currency symbol (£, $, etc) and ensure that there is always 2 decimal points.

If you like this little trick, please consider sharing on Twitter and keep an eye out for more posts on cool things you can do with Alpine.js!

Have a good one :)