---
slug: storing-laravel-users-on-disk-in-flat-files
title: 'Storing Laravel Users on Disk in Flat-Files'
excerpt: 'Let me demonstrate how simple it is to get a flat-file `User` model going in your Laravel application.'
published_at: 2021-03-28T11:00:00+00:00
---
**I'm tired of generic SQL databases.** I've become infactuated with flat-file systems where content and data is stored on disk and persisted between environments, whether that be an SQLite database that powers my application or plain Markdown files.

That is one of the main reasons why I built [Orbit](https://github.com/ryangjchandler/orbit) - a flat-file "database" driver for Laravel's Eloquent ORM.

The main idea is that all of your content and data is stored inside of a "content" file but can still be used through a normal Eloquent `Model`, just like it would with a MySQL or Postgres database.

## The `User` model

To start using Orbit, you'll need to install the Composer package in your Laravel application.

```bash
composer require ryangjchandler/orbit
```

Orbit operates and bootstraps a model via the `Orbit\Concerns\Orbital` trait. This can be added to your `Model` class like this:

```php
use Orbit\Concerns\Orbital;

class User extends Model
{
    use Orbital;
}
```

This is all you need to do for the model to be "usable", but for it to function like a normal `User`, there are a couple of extra steps.

## The `schema` method

Just like a model that's hooked up to a MySQL database, you should define a `schema`. This is what Orbit will use to determine what content is available in your flat-files and what should be accessible from the model.

It's essentially an "up" migration, written as part of your model's definition:

```php
class User extends Model
{
    use Orbital;
  
    public static function schema(Blueprint $table)
    {

    }
}
```

Laravel provides a `users` table migration as standard, so we can take that existing migration and copy it into the `schema` method:

```php
class User extends Model
{
    use Orbital;
  
    public static function schema(Blueprint $table)
    {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->rememberToken();
    }
}
```

> Orbit will automatically add the `created_at` and `updated_at` columns to this schema if your `Model` class needs timestamps.

And that's all there is to it. **Really!**

If you were to open up a `tinker` session and type `User::create([...])`, you would see a new `content/users` directory in your application, as well as a new `1.md` file.

## Customising the primary key

One thing that I like to do with these flat-file models is use a more descriptive "key" as the primary key. In the case of the `User` model, that's most likely going to be the `email` since it's always going to be unique.

To do this in Orbit, all you need to do is change the `$primaryKey` or overwrite the `getKeyName` method.

```php
class User extends Model
{
    use Orbital;
  
    protected $primaryKey = 'email';
  
    public static function schema(Blueprint $table)
    {
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->rememberToken();
    }
}
```

Now, when you create a new `User`, the file name will be the same as the `email` making it really easy to see which users already exist.

> Changing the primary key of a model will affect the foreign and local columns for your relationships. For example, if you use `email` column as your `User` model's primary key, Laravel will guess that the foreign column name is `user_email` on the related model when using `belongsTo` relation. You can change this by specifying the column names when you define the relationship.

## Sign off

If you're interested in Orbit and want to find out more, check out the [GitHub repository](https://github.com/ryangjchandler/orbit).

Thanks for reading this post!