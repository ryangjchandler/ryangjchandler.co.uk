---
title: Automatically Tweet New Articles on Your Jigsaw Site
date: 2020-04-03T00:00:00.000Z
published: false
should_tweet: false
tweeted: false
tweet_url: null
extends: _layouts.post
section: content
---
I'm a big believer in automation. If there's something that I can automate, I generally will. One of the downsides of running a static website is that you lose some of that "back end power". Let me give you an example.

If this blog was powered by a Laravel application, I could fire an event when some happens in my app or run a particular action. In this case, when I publish a new article I could run the `TweetArticleAction` and it would make a tweet for me.

Another example might be cross-posting my article to another platform such as [Dev.to](https://dev.to).

None of this back end automation is possible with a static site. At least that's what I though.

## The Platform

Every time I use Jigsaw, I completely forget about the lifecycle hooks. The framework gives you the ability to run something when a particular event fires during the build. You can read more about those events [in the documentation](https://jigsaw.tighten.co/docs/event-listeners/), but for this article we're going to focus on the `afterBuild` event.

This event gets fired after all of the collections have been built and stored on disk. This is super useful as it allows me to run something after any further modifications have happened.

Since we're just writing PHP, we also have the full power of Composer packages, specifically [`abraham/twitteroauth`](https://github.com/abraham/twitteroauth).

## Tweeting about New Articles

The first step is creating a new listener. A lot of examples will tell you to create a `listeners/` directory in your Jigsaw site, but I prefer to create an `app/` directory. This feels more Laravel like to me and it also lets me put other stuff in there too.

After creating the directory, be sure to hook it up with an autoloader