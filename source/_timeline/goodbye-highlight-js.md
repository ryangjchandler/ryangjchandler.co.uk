---
title: Goodbye, Highlight.js
date: 2020-03-30
order: 1
published: true
---

So, I removed Highlight.js. This is in an effort to remove any unnecessary JavaScript and other assets. Instead, I've chosen to go with [Caleb Porzio's](https://twitter.com/calebporzio) [GitDown](https://github.com/calebporzio/gitdown) package which uses the open GitHub API to parse the Markdown instead. It returns the syntax-marked HTML too, as well as the styles for the code blocks. It looks and works great, and it also saves me some JavaScript stuffs. 

**Before:**

![30, March 2020 Screenshot of Code Blocks Before](/assets/images/timeline/2020-03-30-code-before.png)

**After:**

![30, March 2020 Screenshot of Code Blocks After](/assets/images/timeline/2020-03-30-code-after.png)

I'm not sure what sort of performance gain I've achieved, but there's no JavaScript at all on the site now which I'm pleased about. If there is any in the future, it will just be [Alpine](https://github.com/alpinejs/alpine).

I wasn't much of a fan of that orange colour either so win win I guess.

<div class="border shadow-lg mb-4">
    <div style="width:100%;height:0;padding-bottom:100%;position:relative;"><iframe src="https://giphy.com/embed/h5cZakvQ2hq0Vw4G22" width="100%" height="100%" style="position:absolute" frameBorder="0" class="giphy-embed" allowFullScreen></iframe></div></p>
</div>