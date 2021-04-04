---
title: 'Simple Repositories in Laravel'
slug: simple-repositories-in-laravel
excerpt: 'Abstracting common queries in your Laravel applications can be done in many ways. Let''s take a look at the simplest way using the "Repository pattern".'
published_at: 2020-05-24T18:00:00+00:00
category_slug: laravel
---
The "Repository pattern" is essentially another level of abstraction on top of your database abstraction layer. In the context of Laravel, these are simple classes with methods that call more complex chains of methods on your model classes.

Generally, each repository is responsible for **one** entity within your application. For example, a `UserRepository` should only be responsible for retrieving `User` records.

## Abstract implementation

I've seen various people use traits to implement repositories directly inside of their models. Personally I think this gives the model too much responsibility, especially since models in Laravel are essentially "God classes" already.

Instead, I'll create an **abstract class** that all of the repository classes will extend:

```php
<?php
  
namespace App\Repositories;

abstract class Repository
{
    //
}
```

All of the repository classes will live inside of the `app/Repositories` folder and are namespaced accordingly. If you're following a domain-driven design, you could put this class inside of a "shared" domain.

Each repository needs to have some model-based context, so we'll add a `static` property to our base class.

```php
<?php
  
namespace App\Repositories;

abstract class Repository
{
    protected static string $model;
}
```

I've chosen to make this `protected` since I don't need to access it externally, but I still need to have access to it / overwrite it in the child class. You could make it `public` if you wanted to do some conditional logic based on the value.

This `$model` property should contain the fully-qualified namespace of a model class, for example `User::class`.

The reason this implementation of the repository pattern is so simple is that all method calls from inside of the class will be delegated to an instance of `$model`. 

The missing piece of the puzzle is the all-mighty magic `__call()` method.

```php
<?php
  
namespace App\Repositories;

use Illuminate\Support\Facades\App;

abstract class Repository
{
    protected static string $model;

    public function __call(string $name, array $arguments)
    {
        return App::make(static::$model)->{$name}(...$arguments);
    }
}
```

Now whenever we call a method that doesn't exist on your repository class, it will instead be delegated / deferred to an instance of the underlying `$model`.

## An example

A quick example would be creating a `UserRepository` that has some useful methods for finding a `User` by `email`, `name` and `id`.

```php
<?php
  
namespace App\Repositories;

use App\User;

class UserRepository extends Repository
{
    protected static string $model = User::class;
  
    public function findByName(string $name): ?User
    {
        return $this->where('name', $name)->first();
    }
  
    public function findByEmail(string $email): ?User
    {
        return $this->where('email', $email)->first();
    }
  
    public function findById(int $id): ?User
    {
        return $this->find($id);
    }
}
```

Then, inside of a controller you could pull the repository in using dependency injection:

```php
<?php
  
namespace App\Http\Controllers;

use App\Repositories\UserRepository;

class UserController
{
    protected $users;
  
    public function __construct(UserRepository $users)
    {
        $this->users = $users;    
    }
}
```

## Sign off

I'd love to know if anyone else has used this pattern in their applications and how they implemented it. Comment below or [tweet me](https://twitter.com/ryangjchandler) if you have.

See ya! 👋