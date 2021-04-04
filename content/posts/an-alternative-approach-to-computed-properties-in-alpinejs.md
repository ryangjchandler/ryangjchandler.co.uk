---
slug: an-alternative-approach-to-computed-properties-in-alpinejs
title: 'An Alternative Approach to Computed Properties in Alpine.js'
excerpt: 'I previously wrote about using functions as computed properties in Alpine, but what if there was a better way?'
published_at: 2020-04-20T23:00:00+00:00
---
The other day, I wrote an article on [how to achieve a similar effect to computed properties](/articles/pseudo-computed-properties-in-alpine) in [Alpine.js](https://github.com/alpinejs/alpine). The approach that I took involved simply calling a method that returned a value:

```html
<div x-data="data()">
    <span x-text="hello()"></span>
</div>

<script>
function data() {
    return {
        hello: function () {
            return "Hello!"
        }
    }
}
</script>
```

This works quite well, but they're not _really_ properties anymore. The `<span>` _is_ still reactive, so if the return value depended on another data property, the UI would be updated when the dependency gets changed. To my eyes, `property()` isn't as pretty as `property` on it's own.

Today though, I saw a tweet from [Sebastian De Deyne](https://twitter.com/sebdedeyne) that took a different approach to the same concept.

<div class="flex justify-center">
<blockquote class="twitter-tweet"><p lang="en" dir="ltr"><a href="https://twitter.com/calebporzio?ref_src=twsrc%5Etfw">@calebporzio</a> Quick Alpine question, can I use getters in x-data, or am I going to shoot myself in the foot somehow? <a href="https://t.co/nBo4YcVNzZ">pic.twitter.com/nBo4YcVNzZ</a></p>&mdash; Sebastian De Deyne (@sebdedeyne) <a href="https://twitter.com/sebdedeyne/status/1252562642172067840?ref_src=twsrc%5Etfw">April 21, 2020</a></blockquote> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
</div>

This approach just didn't occur to me at first. It's probably because I hadn't actually tried it. The first thing I did was hop into CodePen and try it out:

<p class="codepen" data-height="265" data-theme-id="dark" data-default-tab="js,result" data-user="ryangjchandler" data-slug-hash="rNOWBrB" style="height: 265px; box-sizing: border-box; display: flex; align-items: center; justify-content: center; border: 2px solid; margin: 1em 0; padding: 1em;" data-pen-title="Getters Alpine.js">
  <span>See the Pen <a href="https://codepen.io/ryangjchandler/pen/rNOWBrB">
  Getters Alpine.js</a> by Ryan Chandler (<a href="https://codepen.io/ryangjchandler">@ryangjchandler</a>)
  on <a href="https://codepen.io">CodePen</a>.</span>
</p>
<script async src="https://static.codepen.io/assets/embed/ei.js"></script>

Out of the box, it just works! Click the button on the right and watch the `<span>` below update. I almost feel kind of stupid that I hadn't though of this originally. Since Alpine is using an object literal as it's source of data, we can use all of the normal things an object provides, such as [getters and setters](https://javascript.info/property-accessors).

The other added benefit this method provides is that you **don't** need to add the parentheses anymore because when Alpine tries to access the property, the JavaScript engine will recognise that there is a getter defined and call that for us.

## Browser compatibility

Regular `getters` and `setters` are supported in all modern browsers and ... 🥁 all the way back to Internet Explorer 9. The only thing that isn't supported that far back is computed property names, so you can't do things like:

```javascript
function data() {
    return {
        get [expression]() {
            return 'Hello!'
        }
    }
}
```

The expression is dynamic and acts like a fallthrough if the property doesn't exist or doesn't have a getter defined already. That's not a big deal, because nobody should be using IE9 today. Seriously, **nobody**.

## Sign off

Thanks to [Sebastian](https://twitter.com/sebdedeyne) for tweeting about this. You can read some of his blog posts on [his personal blog](https://sebastiandedeyne.com/) too.

Personally I'm going to be using this approach going forward, especially since the browser support is so good (unusual, I know).