---
title: Categories & Cards
date: 2020-03-31
order: 3
published: true
---

One of the things I wanted when I launched this blog was categories. That's now been added. Each post can have many categories, which is normally wrong. But, I want to write a post for say both [PHP](/categories/php) and [Laravel](/categories/laravel)</a>, I can do that and file it under both.

![31, March 2020 Screenshot of Categories](/assets/images/timeline/2020-03-31-categories-cards.png)

You probably noticed the different post "card". This is was intended and I think it looks a little bit nicer. Previously, I was using a table and some rows, but now it's just straight divs. Much cleaner and very 'Refactoring UI'-esque.

I also decided to add a listing page for the categories too. Here's how that looks:

![31, March 2020 Screenshot of Category Listing](/assets/images/timeline/2020-03-31-category-listing.png)

Not the nicest looking page, but it gets the job done. Each category also has it's own mini archive page, that was pretty easy. I wanted to copy how the [Jigsaw Blog Starter](http://jigsaw-blog-staging.tighten.co/) does it, but I couldn't get it to work, so I went for the inline filtering. Nasty looking code, but functionally sound.

![31, March 2020 Screenshot of Category Archive](/assets/images/timeline/2020-03-31-category-archive.png)

This was a pretty easy change to make. Not sure how best to handle the CMS side of things though, Netlify CMS doesn't seem to be picking up the existing categories in the source directory. Will need to look into that at some point, but for not it's not a big deal.

I think the next thing on my list is to implement Webmentions. There's tonnes of articles out there about how to do this, but I'd like to tackle it on my own first. I'd also like to actually own the webmentions, instead of using JavaScript to show them. That way, there's still no JavaScript on the site. [Sebastian De Deyne](https://twitter.com/sebdedeyne) wrote a cool article about how he did that on [his blog](https://sebastiandedeyne.com/webmentions-on-a-static-site-with-github-actions/).
