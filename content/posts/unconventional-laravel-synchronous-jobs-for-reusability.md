---
title: 'Unconventional Laravel: Synchronous jobs for reusability'
slug: unconventional-laravel-synchronous-jobs-for-reusability
excerpt: 'Code reusability is a big thing to consider when working on larger applications, but have you ever considered using synchronous jobs?'
published_at: 2020-07-05T16:00:00+00:00
category_slug: laravel
---
Most applications use jobs as a way of pushing heavy logic off of the main thread and doing work asynchronously, in the background.

After looking at some larger applications, I found a few that used synchronous jobs as a way of splitting up application logic into reusable components.

## The idea

Laravel provides some convenient ways of dispatching jobs. If you had a job called `CreateSubscription` you could push it to the queue using `CreateSubscription::dispatch()`. You could also process it synchronously using `CreateSubscription::dispatchNow()`.

A little known fact is that you can actually return things from the job itself.

Let's create a barebones job:

```php
use App\Models\User;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateSubscription implements ShouldQueue
{
    use Dispatchable;
    
    private $user;
  
    private $plan;
    
    public function __construct(User $user, string $plan)
    {
        $this->user = $user;
        $this->plan = $plan;
    }
}
```

The job will receive an instance of `App\Models\User` and store it in a `private` property. The visibility of this property isn't important since this job will be self handling.

Here's the `handle` method:

```php
public function handle()
{
    $subscription = SomeSubscriptionService::create([
        'email' => $this->user->email,
        'plan' => $this->plan,
    ]);

    $this->user->update([
        'subscription_id' => $subscription->id,
    ]);

    return $subscription;
}
```

The logic isn't important for this article. The important part is the `return $subscription` at the end of the method.

If we were to dispatch this job inside of a controller:

```php
class SubscriptionController
{
    public function store(Request $request)
    {
        $subscription = CreateSubscription::dispatchNow(
            $request->user(),
            $request->input('plan')
        );
        
        return redirect()->route('subscription.thank-you', [
            'plan' => $subscription->plan,
        ]);
    }    
}
```

The return value of the job will be given back to the controller, in this case assigned to a variable so that it can be used further along.

## Pros

### It's a job, queue it when you want

Since this is just a regular Laravel job that implements the `ShouldQueue` marker interface, you could just as easily push it to the queue using `CreateSubscription::dispatch()`.

There's no need to change the logic at all, since the return value will just get thrown away, it won't harm the queue.

With the example above where you _need_ the subscription afterwards, it doesn't make much sense, but for something like `RenewSubscription`, you could use the job synchronously when the user manually renews in the browser, then use the same job from a scheduled command that handles automatic renewals or something.

### Reusability

These jobs are reusable and can be used anywhere in your applications (controllers, listeners, commands, etc). This benefit is a little less important because in reality you could create any sort of class and have it do the same thing, just like the "action" pattern that is quite popular.

## Cons

### It's different

Jobs aren't designed for this. They can do it, but according to convention they shouldn't. If a new developer comes on to a project and sees this, they're probably going to think "What the f&$*?".

### It's not officially documented

This functionality won't be found anywhere in the [official Laravel docs](https://laravel.com), so it could disappear in a major version update. I doubt it will, but it **could**.

## Sign off

If you've ever used this pattern, let me know on [Twitter](https://twitter.com/ryangjchandler) because I'd love to know. Let me know if you have any questions or things you think I missed.

I'd like to shout out [laravel.io](https://laravel.io) too ([Dries](https://twitter.com/driesvints)), since this is where I initially discovered this functionality. You can take a look at the [GitHub repo](https://github.com/laravelio/laravel.io) to find out a bit more.

As always, thanks for reading! 👋