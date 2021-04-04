---
slug: validating-laravel-console-input
title: 'Validating Laravel Console Input'
excerpt: 'When distributing console commands in a package or within an application, making sure data is in the correct format can be important. Let''s build a `make:user` command that takes advantage of Laravel''s validation helpers.'
published_at: 2021-03-02T18:30:00+00:00
---
Let's start off by creating a new console command. Run the following command in your terminal:

```bash
php artisan make:command MakeUserCommand
```

This will create a new file in `app/Console/Commands` called `MakeUserCommand.php` with all of the normal command boilerplate. I've removed some of the cruft below for demonstration purposes.

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeUserCommand extends Command
{
    protected $signature = 'command:name';

    protected $description = 'Command description';

    public function handle()
    {
        return 0;
    }
}
```

## Retrieving user input

Instead of asking for input up front when the user runs the command, I'll instead be using the `Command::ask()` method to get input during the command's run time.

Here's how you might get the name of the new user.

```php
public function handle()
{
    $name = $this->ask('Name:');

    return 0;
}
```

When the command runs, the user will be shown the text provided as the method's first argument.

If you wanted to validate this input, all you need to do is pass the data through to a new `Validator` and handle any errors. Let's begin by creating a new `Validator` with the correct data and rules.

```php
use Illuminate\Support\Facades\Validator;

public function handle()
{
    $name = $this->ask('Name:');
    
    $validator = Validator::make([
        'name' => $name,
    ], [
        'name' => ['required', 'string']    
    ]);

    return 0;
}
```

Now that the validator has been created, calling the `$validator->fails()` method will run the data against the rules provided and return a `bool`.

```php
public function handle()
{
    $name = $this->ask('Name:');
    
    $validator = Validator::make([
        'name' => $name,
    ], [
        'name' => ['required', 'string']    
    ]);
    
    if ($validator->fails()) {
        // Do something here...
    }

    return 0;
}
```

Now that we know if the validation has failed or not, we can look into the errors and output them to the user.

```php
public function handle()
{
    $name = $this->ask('Name:');
    
    $validator = Validator::make([
        'name' => $name,
    ], [
        'name' => ['required', 'string']    
    ]);
    
    if ($validator->fails()) {
        foreach ($validator->errors()->all() as $error) {
            $this->error($error);
        }
        
        return 1;
    }

    return 0;
}
```

And that's all there is to it! If somebody tries to enter an invalid name, the validation will fail and the errors will be output in the user's console.

If you went ahead and did this for the `email` too, you can be confident that the data being provided is valid.

## Improving the `ask` method

The only problem with the basic approach I've shown is that the process exits if there is an error. If you've only got one piece of data being validated, this might be okay.

Imagine you've battled with the validation for the name and *finally* reach the `email` stage. If you fail the validation here, you need to go back to the beginning, put in your `name` again and then try the `email` again too.

One way we can tackle this is with recursion... **dun dun dun**!

### A new method

Let's start by pulling all of the validation logic into a new helper method on the class.

```php
public function askWithValidation(
    string $message, array $rules = [], string $name = 'value'
) {

}
```

This new method will handle all of the validation, as well as the error displaying. Start by asking the question and instantiating a validator, just like before

```php
public function askWithValidation(
    string $message, array $rules = [], string $name = 'value'
) {
    $answer = $this->ask($message);
    
    $validator = Validator::make([
        $name => $answer,
    ], [
        $name => $rules,
    ]);
}
```

> This method is going to be re-usable, so instead of hardcoding the key in each array, we'll let the developer pass in a custom `$name` (defaulted to `value`).

Instead of calling `$validator->fails()`, we can actually use the inverse operation, `$validator->passes()` and return early if that returns `true`.

```php
public function askWithValidation(
    string $message, array $rules = [], string $name = 'value'
) {
    $answer = $this->ask($message);
    
    $validator = Validator::make([
        $name => $answer,
    ], [
        $name => $rules,
    ]);
    
    if ($validator->passes()) {
        return $answer;
    }
}
```

Early returns are just *cleaner*, right? 

If the condition fails, we can go through and check for any errors and display them to the user.

```php
public function askWithValidation(
    string $message, array $rules = [], string $name = 'value'
) {
    $answer = $this->ask($message);
    
    $validator = Validator::make([
        $name => $answer,
    ], [
        $name => $rules,
    ]);
    
    if ($validator->passes()) {
        return $answer;
    }
    
    foreach ($validator->errors()->all() as $error) {
        $this->error($error);
    }
}
```

Now for the recursion. If the validation fails and errors are shown to the user, instead of returning and exiting the process, we can instead `return $this->askWithValidation` so that the user is asked the same question again.

```php
public function askWithValidation(
    string $message, array $rules = [], string $name = 'value'
) {
    $answer = $this->ask($message);
    
    $validator = Validator::make([
        $name => $answer,
    ], [
        $name => $rules,
    ]);
    
    if ($validator->passes()) {
        return $answer;
    }
    
    foreach ($validator->errors()->all() as $error) {
        $this->error($error);
    }
    
    return $this->askWithValidation($message, $rules, $name);
}
```

And there you have it! Validated user input inside of your console commands.

I've create a little Gist with a `trait` that you can pull into any of your console commands [here](https://gist.github.com/ryangjchandler/1c579774cc2c2c5fda421f3374e4a01c).

## Sign off

Used something similar in your application or package? Let me know on [Twitter](https://twitter.com/ryangjchandler).

Thanks for reading!