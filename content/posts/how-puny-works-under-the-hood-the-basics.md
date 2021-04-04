---
slug: how-puny-works-under-the-hood-the-basics
title: 'How Puny Works under the Hood: The Basics'
excerpt: 'Let me show you how some of Puny''s internal codebase works and why I''m in love with it.'
published_at: 2021-02-05T12:00:00+00:00
---
## Introduction

For those of you who don't know, or haven't heard about it, [Puny](https://github.com/ryangjchandler/puny) is my very own unit testing library.

Unlike PHPUnit et al, it's designed with minimalism as it's main goal. There are only a handful (literally) of standard functions provided by Puny and it really makes you think differently about how you test your applications or packages.

The best way to showcase Puny is by writing a simple unit test for a `StringFormatter` class.

```php
class StringFormatter
{
    public static function upper(string $input)
    {
        return strtoupper($input);
    }
}
```

All this method does is wrap the `strtoupper()` function, but it's a good way of showcasing the testing utilities.

Normally my test files can be found in a `tests` directory at the root of my project. By default, Puny will try to look for this folder.

Since we're unit testing, it's also common practice to test each component or concept inside of it's own file, so I'll create a new file called `tests/StringFormatter.php`.

Puny provides a `Puny\test` function that can be used to register a new test.

```php
use function Puny\test;

test('it can convert a string to uppercase', function () {

});
```

The `Puny\test` function accepts **two arguments**, the first is the name of the test itself (a description of what you will be testing) and the second is a `callable` / `Closure` that actually performs the test's logic.

In this case, we'll be calling `StringFormatter::upper()` and checking that the return value is suitable.

```php
use function Puny\{test, ok};

test('it can convert a string to uppercase', function () {
    ok(StringFormatter::upper('hello') === 'HELLO', 'it converts correctly');
});
```

Here I'm using the `Puny\ok` function to make sure that something is, you guessed it, "ok". All it really does is check that the first argument is `true` or `false`.

If it's `true` it doesn't do anything at all. If it's `false`, it will print out an error in the console.

The second argument is a sub-description of the specific assertion being made. This will be used in the error output so that you can quickly find the right failing assertion.

### A better equality helper

Instead of writing out a `bool` condition for the `Puny\ok` helper, you could instead use the `Puny\eq` helper function. This is just a shorthand for comparing two operands.

```php
use function Puny\{test, eq};

test('it can convert a string to uppercase', function () {
    eq(StringFormatter::upper('hello'), 'HELLO', 'it converts correctly');
});
```

It's almost identical. You just don't need to worry about writing the `===` (or `==` if you're a menace) yourself.

> It's worth noting that the `Puny\eq` helper will always make **strict comparisons**. If this isn't fit for your use case, just use `Puny\ok`.

## How it all works

It all starts with the Puny CLI. This is a file installed with the Composer package that you can use to actually run your tests. It's only responsible for invoking the `Puny::run()` and setting the correct tests folder method.

As I mentioned previously, Puny will default to using a `tests` folder in your current working directory (according to `getcwd()`). This is a great default and makes running the command easier since you don't need to pass in any options or arguments.

> You can specify a custom folder by passing in an argument to the command - `puny ./tests-folder`.

### Bootstrapping

Puny does include some niceties for running some logic before your entire test suite. If it encounters a `bootstrap.php` file in the root of your `tests` folder, it will include that file.

This means you can setup singleton classes, bind things to a container or anything else that you might need to use throughout your test suite.

### Discovering tests

Once Puny knows where the tests are located, it walks through that directory recursively and will include any PHP files it finds. The interesting thing here is that the tests themselves (registered using `Puny\test`) aren't actually being run quite yet.

Calling the `Puny\test` function will actually call an internal `Puny::register` method. This method places the test inside of a single array on the main `Puny\Puny` instance. This is possible because of how PHP evaluates an entire file when it is imported using `include` or `require`.

This happens for each test file and eventually, once all folders have been walked and all files have been included, Puny is left with an array of test names and callbacks.

> By building up this array, it implicitly forces test names to be unique. If two different files both have a test with the same name, only the last test file to be included will _actually_ be run because it overwrites the earlier test.

### Running tests

Now that there is a collection of tests to run, Puny will loop over this array and invoke each `callable` / `Closure`.

Each callback is invoked inside of a `try / catch` block. This means that any exceptions thrown by the test will be caught by Puny and can therefore be handled in a special way.

This is exactly how the `Puny\ok`, `Puny\eq` and `Puny\skip` function work. I'll use `Puny\ok` as an example:

```php
function ok(bool $check, string $id) {
    if (! $check) {
        throw new NotOkException($id);
    }

    return true;
}
```

This is the code for the `Puny\ok` helper. All it does is check if the `$check` is `false` (falsy) and throws an exception if it is.
Puny can then register a catch block for this exception, `NotOkException` and handle it accordingly.

```php
try {
    $callback();
} catch (NotOkException $e) {
    Console::error("Failed: {$e->getMessage()}");
  
    $this->failed++;
}
```

The exception is being handled so it will never be reported to the user in the console. Instead Puny uses it's own output to notify the user of a failure and also increase a counter for the number of failed tests.

The benefit to this approach is that the rest of the test suite can still be run whilst notifying the user of any failures.

The `Puny\eq` function uses the `Puny\ok` function internally, so there's no special conditions needed for that.

For the `Puny\skip` function to work, all we need to add is another `catch` block for a different exception:

```php
try {
    $callback();
} catch (NotOkException $e) {
    Console::error("Failed: {$e->getMessage()}");
  
    $this->failed++;
} catch (SkippedException $e) {
    Console::warning("Skipped: {$name}");
  
    $this->skipped++;
  
  	continue;
}
```

The `Puny\skip` function can then throw a new `SkippedException` when it's called.

```php
function skip() {
    throw new SkippedException;
}
```

Calling the `Puny\skip` function will also report back to the user in the console and `continue` the `foreach` loop, moving on to the next test.

## Conclusion

And that's all there is to it. Kind of, anyway. I've gone over the basic inner workings of Puny in this article but I'll be writing a follow-up in a couple of weeks that goes over how the `Puny\spy` helper function works.

If you are interested in giving Puny a try, head over to the [GitHub repository](https://github.com/ryangjchandler/puny) for more information.

If you've already used Puny, I'd love to know so message me on [Twitter](https://twitter.com/ryangjchandler).