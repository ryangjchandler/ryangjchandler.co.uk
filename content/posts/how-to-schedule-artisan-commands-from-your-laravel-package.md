---
slug: how-to-schedule-artisan-commands-from-your-laravel-package
title: 'How to Schedule Artisan Commands from Your Laravel Package'
excerpt: 'Ever needed to schedule an `artisan` command from one of your Laravel packages but couldn''t figure out how to do it? Let me show you!'
published_at: 2021-03-21T17:45:00+00:00
---
Before you can run your command on the scheduler, you need to make sure you've actually registered the command with `artisan`.

To do this, use the `$this->commands` method in your `ServiceProvider::boot` method.

```php
class MyPackageServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands([
            Commands\MyAwesomeCommand::class,
        ])
    }
}
```

By doing this, you can now run your command using `php artisan my-awesome-command`.

## Scheduling the command

Now that `artisan` is aware of your command, you can hook it up to Laravel's `Schedule` and run it as often as you need.

Begin by calling `$this->app->afterResolving` in your `ServiceProvider::boot` method, passing through two arguments.

The first argument should be the abstract that is being resolved. In this case, that will be `Illuminate\Console\Scheduling\Schedule`. The second argument should be a `Closure` that accepts the object in it's parameter list.

```php
use Illuminate\Console\Scheduling\Schedule;

class MyPackageServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands([
            Commands\MyAwesomeCommand::class,
        ])
		  
        $this->app->afterResolving(Schedule::class, function (Schedule $schedule) {
            $schedule->command(Commands\MyAwesomeCommand::class)->everyMinute();
        });
    }
}
```

Now when you run `php artisan schedule:run`, the `Closure` will be executed and `MyAwesomeCommand` will be added to the scheduler, running once every minute.