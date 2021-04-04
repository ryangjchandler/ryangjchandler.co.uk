---
slug: how-to-customise-the-logo-in-your-laravel-jetstream-application
title: 'How to Customise the Logo in Your Laravel Jetstream Application'
excerpt: 'Laravel Jetstream comes jam-packed with lots of great features but some people struggle to change the logo in their application. Let me show you how it can be done in 2 simple steps.'
published_at: 2021-02-14T20:00:00+00:00
---
> This article assumes you've already got a [Laravel Jetstream](https://jetstream.laravel.com/) application setup. If you haven't, read the official documentation on [how to get started](https://jetstream.laravel.com/2.x/installation.html).

## Publishing Jetstream's views

Although Jetstream publishes quite a few things into your application, it doesn't publish views by default. The main reason for this is it's much easier to rollout bug fixes or new features if the views are registered inside of the package.

You can publish them yourself however by running the following command:

```bash
php artisan vendor:publish --tag=jetstream-views
```

This will publish all of Jetstream's views into `resources/views/vendor/jetstream`.

## Changing the logo

The steps needed here depend on which stack you have chosen.

### Livewire

To use a custom logo, you'll need to customise three files:

1. `resources/views/vendor/jetstream/components/application-logo.blade.php`
2. `resources/views/vendor/jetstream/components/application-mark.blade.php`
3. `resources/views/vendor/jetstream/components/authentication-card-logo.blade.php`

Each of these files will contain an SVG. Replace this markup with your own logo (another SVG or even an `<img>` tag).

> If you use an SVG, be sure to add the `{{ $attributes }}` on to the `<svg>` tag so that any attributes passed through to the component are still rendered.

### Inertia

You'll need to customise three files for Inertia too:

1. `resources/js/Jetstream/ApplicationLogo.vue`
2. `resources/js/Jetstream/ApplicationMark.vue`
3. `resources/js/Jetstream/AuthenticationCardLogo.vue`

Much like the Livewire stack, just replace the SVG markup with your own SVG or an `<img>` tag.