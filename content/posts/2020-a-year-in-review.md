---
slug: 2020-a-year-in-review
title: '2020: A year in review'
excerpt: "**Damn**. 2020. What a (good, bad) year.\n\nThis is my first time writing one of these \"year in review"
published_at: 2020-12-23T15:30:00+00:00
---
**Damn**. 2020. What a (good, bad) year.

This is my first time writing one of these "year in review" blog posts but I'd like to make this an annual tradition. It gives me an opportunity to reflect on the positives from this year and also look into next year, 2021.

## Prologue

Before I get started, I want to acknowledge the fact that there are lots of people who have had it rough this year. Nobody could have predicted this year to turn out the way it did.

Some might have guessed that certain things would happen but definitely not to *this* extent.

I also want to acknowledge that I am *very* lucky and fortunate to be in a good position mentally, financially and health wise.

## Personal

I don't want to go too deep into my personal life. You're probably not interested in it.

Not much has changed for me in the last year outside of the development world. I think the biggest milestone was **saving for a deposit on a house**.

This was one positive thing to come from COVID. Being stuck at home had a side effect of spending less money on food, travel and holidays since my partner and I couldn't do any of that. This leftover money ended up in savings and in the last couple of months has added up and allowed us to start looking at properties with the hopes of buying and moving out in the New Year.

## Work

### New job

I started a new job in January at an insurance company, [Surewise](https://surewise.com). I joined a small team of Laravel developers who all have a shared goal of making online insurance smarter and simpler for as many people as possible.

The job is great and I've been able to innovate our technology stack over this last year. We've implemented many new tools and packages, here's a list of just a few:

- [Livewire](https://laravel-livewire.com)
- [Alpine.js](https://github.com/alpinejs/alpine)
- CI/CD

### Freelancing

I'm very happy to say that this year was **the** year that I started (seriously) freelancing. This was the second positive thing to come from COVID, since I was at home I had some more time on my hands and I wanted to help others with their projects.

All of the freelance work was done in the evenings after work or at the weekends, but that really didn't bother me. I was helping others (people and companies) with their projects and really trying to help out companies who were invested in the [TALL stack](https://tallstack.dev/).

## Open-source

I've been interested in open-source work for a few years now but this last year, it has been a real focus of mine.

### My introduction to big open-source (Alpine.js)

It all started at the beginning of the year with the new [Alpine](https://github.com/alpinejs/alpine) (originally named Project X) project by [Caleb Porzio](https://twitter.com/calebporzio). I was using the project myself and was very active on the repository. I'd comment on issues, try to help people out. I was also opening PRs to the project, trying to fix things, introduce new features and improve the developer experience along the way.

This was my first real taste of what it was like to contribute to an open-source project and Caleb made the whole experience **beautiful**.

As a developer who had come from the world of Vue, I felt like Alpine was missing something. There were also a few other people who felt the same way. That "thing" was a way of sharing state between components, a.k.a global state management.

After a few iterations and releases of an early (and ugly) prototype, [Spruce](https://github.com/ryangjchandler/spruce) was born. Spruce was my solution to that "missing something". It was designed to be minimalistic, just like Alpine. It felt natural to use through the `$store` variable that it provided.

I personally believe that Spruce has filled that void and the numbers do add up. On average, the CDN has had over 75,000 hits per month so either somebody is using it on a really big site, or a lot of people are using it on smaller sites.

Either way, it solved the problem for me. That's all that matters, right?

As well as Spruce, I've gone on to create and contribute to other Alpine.js related projects such as the [DevTools](https://github.com/alpine-collective/alpinejs-devtools), [Magic Helpers](https://github.com/alpine-collective/alpine-magic-helpers) and the [Awesome list](https://github.com/alpine-collective/awesome).

### The TALL stack

Alongside Alpine, Caleb released a new tool called Livewire. Together they're extremely powerful and add Tailwind to the mix, you're going to be having a party.

As people started to pick up these new tools an acronym emerged, TALL:

- **T**ailwind
- **A**lpine.js
- **L**ivewire
- **L**aravel

The Laravel framework has had this concept of "presets" for a little while but there wasn't a real one for the TALL stack.

So I teamed up with [Liam Hammett](https://twitter.com/LiamHammett) and [Dan Harrin](https://twitter.com/danjharrin) to build one. We wanted to build **[the best third-party preset](https://github.com/laravel-frontend-presets/tall)** preset Laravel.

We went above and beyond really. It came out of the box with tests, customisable components, pretty Tailwind components and more.

At the time of writing this article, our preset has had over 33,000 downloads. That is an insane amount of downloads and we're all really happy with how it turned out, as well as how helpful it has been.

### GitHub Sponsors

GitHub introduced a new Sponsors program this year. I was accepted into it and wrote a [small profile](https://github.com/sponsors/ryangjchandler).

I was initially inspired by Caleb's success with [sponsorware](https://calebporzio.com/sponsorware), but I never really pushed that concept. Instead, I opted for the "if you use my packages and benefit from them in some way, you can give me $1 or more per month to show that you support my work".

At the time of writing this article, I have **25 sponsors** and I couldn't be more grateful. You know who you are.

The support that these guys give me, financially, allows me to spend more time on my open-source work. It really does mean **a lot**.

### Overview

Here are some real numbers for you:

- **Total number of contributions: > 2,000**
- **Total number of discussions answered: > 25**
- **Total number of pull request by me: > 150**
- **Total number of issues by me: > 200**

Considering I do all of that on the side of my full-time *and* freelance work, those numbers aren't too shabby.

## Writing and Speaking

I got really serious about blogging this year. I've written **30 blog posts** (not including this one) on topics that interest me but also help other people out.

One of my posts even reached [Hacker News](https://news.ycombinator.com/item?id=24647722) and the abuse wasn't too bad!

I won't go into numbers, but here are 4 of my most popular posts from the last year:

- [Running GitHub Actions for Certain Commit Messages](https://ryangjchandler.co.uk/articles/running-github-actions-for-certain-commit-messages)
- [Unconventional Laravel: Custom Pipeline Classes](https://ryangjchandler.co.uk/articles/unconventional-laravel-custom-pipeline-classes)
- [Writing Reusable Alpine Components](https://ryangjchandler.co.uk/articles/writing-reusable-alpine-components)
- [Unconventional Laravel: Responsable classes](https://ryangjchandler.co.uk/articles/unconventional-laravel-responable-classes)

I also did my first meetup talks this year. My favourite one of them all was the [Laravel Worldwide Meetup](https://meetup.laravel.com/) where I demonstrated how to setup a simple CI/CD pipeline for your Laravel application with GitHub Actions.

You can watch that talk [on YouTube](https://www.youtube.com/watch?v=1kPu2eQjkGk).

## New friends

Through all of my new ventures this year, I've been able to meet some really great people. I want to thank you all for reaching out to me for help with something, helping me with something and most of all, being awesome.

I want to thank [Liam](https://twitter.com/LiamHammett), [Dan](https://twitter.com/danjharrin), [Caleb](https://twitter.com/calebporzio), [Sam](https://twitter.com/carre_sam), [Samuel](https://twitter.com/samuelstancl), [Lars](https://twitter.com/LarsKlopstra), [Hugo](https://twitter.com/hugo__df), [Kevin](https://twitter.com/kevinbatdorf), [Simone](https://twitter.com/simo_tod), [Duncan](https://twitter.com/damcclean). This feels like I'm accepting a Grammy so I've definitely missed some people off that list but if we talk, you know who you are.

You've all had a huge impact on my developer life this year and it wouldn't have been the same without you.

(I'll stop with the soppy stuff now).

## Epilogue

This year has been full of thrills. For some, it has been full of lows but I really want to believe that 2021 will be a better year for all of us, all across the globe.

As I look forward into 2021, I want to set a few goals for myself:

1. Write more blog posts and help people out.
2. Speak at a conference.
3. Release at least 3 new open-source packages.
4. Finish and release [GitHub Actions for PHP Developers](https://actions-for-php.com).
5. Livestream on a regular basis.
6. Meet new friends.
7. Somehow convince [Taylor](https://twitter.com/taylorotwell) to follow me.

There we go. We'll see how well that went next year.