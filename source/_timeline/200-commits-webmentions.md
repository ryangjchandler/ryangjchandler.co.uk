---
title: 200 Commits & Webmentions
date: 2020-04-03
order: 1
published: false
---

Another milestone reached. I made the 200th commit on the repository! This was quite a bit deployment actually, I'll explain why.

![Screenshot of 200 Commits on GitHub](/assets/images/timeline/2020-04-03-200-commits.png)

I finally added webmention support to my website! I've been hearing about webmentions for a couple of years now and never really understood their significance given the number of rock solid comments system out there, and then it hit me. Webmentions are the right step forward for general comment systems, especially if you're active / have followers on social platforms like Twitter.

When you post a new article and share it on Twitter, people generally interact with it. They will like your tweet, reply back, retweet and retweet with a comment. People will also mention your article. All of these different interactions on the platform can be converted into webmention-based interactions and act like on-site interactions.

Here's how my webmentions section looks:

![Screenshot of New Webmentions Section](/assets/images/timeline/2020-04-03-webmentions.png)

It's super basic and that's on purpose. I don't really want to use lots of JavaScript on this site, so I decided to use the native `<details>` element that is now supported in all major and modern web browsers (thank to Edge moving to Chromium). It's essentially a native accordion, which some questionable default styling, but nonetheless it works with **0 lines of JavaScript**.

I've not looked into how stylable the element is and what you can do with it, but I imagine you could get quite far without needing crazy JavaScript accordion libraries, or writing your own.

For some further thoughts on webmentions, they work great. I followed [Sebastian De Deyne's](https://twitter.com/sebdedeyne) article which you can find [on his site here](https://sebastiandedeyne.com/webmentions-on-a-static-site-with-github-actions/). The post walks through actually taking the webmention data and storing is inside of your repository, so you essentially own the data. This is super important in the current digital age, since most corporate companies will try to sell of your data for their own benefit.