---
slug: flashing-banner-messages-in-your-laravel-jetstream-and-livewire-applications
title: 'Flashing Banner Messages in Your Laravel Jetstream and Livewire Applications'
excerpt: 'Learn how you can use Jetstream''s out-of-the-box banner component to show flash messages to your users.'
published_at: 2021-02-15T14:35:00+00:00
---
> This article assumes you've already got a [Laravel Jetstream](https://jetstream.laravel.com/) application setup and that you are using the [Livewire](https://laravel-livewire.com) stack. If you haven't, read the official documentation on [how to get started](https://jetstream.laravel.com/2.x/installation.html).

## The `<x-jet-banner>` component

Jetstream comes jam-packed with lots of goodies. One of those goodies is an `<x-jet-banner>` component. If you're using the default `layouts.app` layout that comes with Jetstream, you might have already seen this. It can be found at the very start of the `<body>` tag:

```html
<body class="font-sans antialiased">
    <x-jet-banner />
```

If you're using a different layout file, go ahead and include this Blade component somewhere in your markup.

A brief look at the component itself shows that it's powered by Alpine and support 2 different styles out of the box. A **success** style, as well as an **error/danger** style.

This is perfect for 99% of applications since you either want to say something is good or bad.

You might also notice that there is an `@props` declaration at the top of the component file:

```blade
@props(['style' => session('flash.bannerStyle', 'success'), 'message' => session('flash.banner')])
```

This is where the component gets all of the information for what type of banner should be shown as well as the message.

## Flashing a message

Since we know the component is looking for the message and style in the session, all we need to do is flash these pieces of information to the session.

In a Livewire component, you might use the `session()` helper or go through the `request()` helper instead.

```php
public function banner(string $message, string $style = 'success')
{
    request()->session()->flash('flash.banner', $message);
    request()->session()->flash('flash.bannerStyle', $style);
}
```

Add this method to your component and use it yourself!


```php
public function save()
{
    // Some save logic goes here, I guess.
  
    $this->banner('Successfully saved!');
}
```

## A reusable trait

If you want to re-use this throughout multiple components, you might wish to extract the method into a `trait` that can be used on your components.

Here's the one I use.

```php
namespace App\Support\Concerns;

trait InteractsWithBanner
{
    public function banner(string $message, string $style = 'success')
    {
        request()->session()->flash('flash.banner', $message);
        request()->session()->flash('flash.bannerStyle', $style);
    }
}
```

> For these sort of traits, I don't put them inside of the `App/Http/Livewire` folder because they're not reliant on Livewire specific methods. I could add this to anything in my application and it would still do the same thing.

Now you can use this trait in your Livewire component instead:

```php
use App\Support\Concerns\InteractsWithBanner;

class SaveForm extends Component
{
    use InteractsWithBanner;
}
```