---
title: Prevent Updating or Saving of Laravel Models
date: 2020-03-31
published: true
categories: [php, laravel]
extends: _layouts.post
section: content
---

Recently I've needed to disable particular methods and mutations on my Laravel models. For example, after a model gets created I don't want anyone to be able to update that record again. Instead, it should get overwritten with a brand new record and archived.

Here's a simple trait that you can use on your models to disable updating:

```php
trait PreventsUpdating
{
    public static function bootPreventsUpdating()
    {
        static::updating(function (Model $model) {
            return false;
        });
    }
}
```

Simply use this on your model and you will no longer be able to update it.

### Improvements

We could take this a step further and make it more reusable and DRY-er [<sup>1</sup>](#note-1).

```php
trait PreventsModelEvents
{
    protected static $prevents = [];

    public static function bootPreventsModelEvents()
    {
        foreach (static::$prevents as $event) {
            static::{$event}(function (Model $model) {
                return false;
            });
        }
    }
}
```

Now when we want to use it on a model, we can do this:

```php
class User extends Model
{
    use PreventsModelEvents;

    protected static $prevents = ['updating'];
}
```

When we try to update our `User` model, it will be stopped and will return false. This can be applied to the other events such as `saving` and `creating` too.

<small id="note-1">1. I could probably come up with a better name for the trait, but this will do for now.</small>
