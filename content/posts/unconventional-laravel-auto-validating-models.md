---
slug: unconventional-laravel-auto-validating-models
title: 'Unconventional Laravel: Auto-validating models'
excerpt: 'Join me as I go through some strange and unconventional things that you can do in your Laravel applications, starting with auto-validating Laravel models.'
published_at: 2020-07-02T16:00:00+00:00
---
In most applications validation logic is placed in standardised places. You can do it inside of `FormRequest` objects or as part of your controller logic. You could even do it inside of your middleware if you really wanted to.

Have you ever considered removing that logic from your main request / response flow and holding the model accountable instead? If not, let me show you how it can be done and some of the pros and cons.

## How?

### Model events

Most Laravel developers have used model events at some point in their career. If you haven't, here is how they work.

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    public static function boot()
    {
        parent::boot();

        static::creating(function (Post $post) {
            if (!$post->slug) {
                $post->slug = Str::slug($post->title);
            }
        });
    }
}
```

When a new `Post` model is created using the `Post::create()` method, our closure will be run before it has actually been saved / persisted. `Model::creating()` is just one example. There are `::created()`, `::saving()`, `::saved()` and so many more. You can read more about them in the [Laravel documentation](https://laravel.com/docs/7.x/eloquent#events).

Generally speaking, these events are used to ensure that some property is always present or auto-generated on the model. Ensuring something exists kind of sounds like validation, doesn't it?

### Validating the model

Now that we know how model events work, we can utilise them and validate our models on creation. Take a look at the following code:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class Post extends Model
{
    public static $rules = [
        'title' => 'required|string|max:255',
        'slug' => 'required|string',
        'excerpt' => 'nullable|string|max:160',
        'published_at' => 'nullable|date',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function (Post $post) {
            Validator::validate($post->toArray(), static::$rules);
        });
    }
}
```

The rules are defined on the model as a static property, since they're unlikely to change. In the event that they do change, you could always define a `getRulesArray()` method on the model, and use the following snippet instead.

```php
static::creating(function (Post $post) {
    Validator::validate($post->toArray(), $post->getRulesArray());
});
```

```php
public function getRulesArray(): array
{
    return [
        'title' => 'required|string|max:255',
        'slug' => 'required|string',
        'excerpt' => 'nullable|string|max:160',
        'published_at' => 'nullable|date',
    ];
}
```

The second approach would make more sense when you need to conditionally apply some logic based on a property on the model, but in most cases I'd find a `static` array to be fine. One example might be a `unique` rule that needs to ignore the current model when updating / saving.

## Things to note

**Hidden properties**

Unfortunately Laravel's validator doesn't work with objects, meaning the `Model::toArray()` method is needed. The problem here is you might not actually be able to validate all of the properties if you're using the `protected $hidden` property on the model.

This would be the case for the default `User` model that Laravel provides and the `password` column. One way to work around this is by making those properties visible during validation:

```php
protected $hidden = ['published_at'];

static::creating(function (Post $post) {
    $post->makeVisible(['published_at']);
  
    Validator::validate($post->toArray(), static::$rules);
});
```

Now when the `$post->toArray()` call is made, the `published_at` column will be present and processed.

## Pros

### Knowledge encapsulation

One common thing, especially in more domain-driven patterns, is ensuring that your HTTP layer knows as little as possible about your database. In Laravel, this means your model becomes a God class full of database knowledge, and your controllers simply call methods without knowing what columns are present and what data types they are.

With this auto-validation pattern, that is easy enough to achieve. Your controller no longer needs to do any validation or worry about what data is being validated. Your model handles all of that and encapsulates it in a single place.

### Re-usability

Even if you didn't want to do the whole auto-validation thing, you could still place your rules on the model and use those elsewhere. This is another point on top of my last one. As long as you know the name of the method (use some sort of interface if you want), your controller won't know anything about the rules present, just that it needs to do some sort of validation.

A smaller point is that any changes to the rules will be applied everywhere. You won't need to go through all of your controllers / form requests and change them.

### Forget about the boring stuff

Validation is boring. This approach will mean you only have to do is in one place, just create your models as regular elsewhere. Forget about the boring stuff and enjoy the magic.

## Cons

### Redirect loops

Since the `Validator::validate()` method throws a `ValidationException` when validation fails, Laravel will try to catch that exception and redirect back to the previous location.

If for whatever reason your previous location was the same as the route where validation is failing, you will probably get stuck an a redirect loop.

Be sure to only use this auto-validation pattern on separate routes, i.e. `GET /posts` and `POST /posts` would be fine.

### Side effects

As mentioned a second ago, Laravel will pick up on the `ValidationException` and try to redirect the user back with some errors. This means that something that happens in the database layer _could_ have some effect on the HTTP layer of your application.

This doesn't bother me much, but there will be some people who find this disgusting and some sort of anti-pattern. Remember though, this is an **unconventional** thing to do.

### "Bottom of the drawer" logic

The final con that I'd like to mention is that this pattern will push all of your validation to the "bottom of the drawer". By that I mean the validation itself is hidden when looking at your controllers and other parts of your application, so when something goes wrong or you need to add a new validation rule, it might cause some headaches or digging to find out where it is all taking place.

## Sign off

Thanks for reading! I'm super excited to write some more articles about strange patterns you can use in your Laravel applications.

If you're interested in using this automatic validation pattern in your applications, I've created a small package that will can make it a bit easier to get started with. Check it out on my [GitHub](https://github.com/ryangjchandler/laravel-auto-validate-models) or click [this link](https://github.com/ryangjchandler/laravel-auto-validate-models).