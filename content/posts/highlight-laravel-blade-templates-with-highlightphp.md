---
title: 'Highlight Laravel Blade Templates with Highlight.php'
slug: highlight-laravel-blade-templates-with-highlightphp
excerpt: 'Out of the box, Highlight.php doesn''t support Laravel Blade templates. I''ll show you how to register a custom syntax so that you can start highlighting your Blade content.'
published_at: 2021-01-08T12:00:00+00:00
category_slug: php
---
Before we begin, this blog posts assumes you already have [Highlight.php](https://github.com/scrivo/highlight.php) setup in your application. If you don't already have it setup, consult the [official documentation](https://github.com/scrivo/highlight.php) or look into alternatives such as [`commonmark-highlighter`](https://github.com/spatie/commonmark-highlighter) that use this library under the hood.

## The syntax

Highlight.php uses JSON files for syntax definitions, where as Highlight.js uses JavaScript files. This is just down to the fact that one is written in PHP where JavaScript evaluation is basically impossible and the other is a JavaScript library, so JavaScript can be used for configuration.

Here is the JSON file for the Blade syntax definition:

```json
{
    "case_insensitive": true,
    "subLanguage": "xml",
    "contains": [
        {
            "className": "comment",
            "begin": "\\{\\{--",
            "end": "--\\}\\}"
        },
        {
            "className": "template-variable",
            "begin": "\\{\\{",
            "starts": {
                "end": "\\}\\}",
                "returnEnd": true,
                "subLanguage": "php"
            }
        },
        {
            "className": "template-variable",
            "begin": "\\}\\}"
        },
        {
            "className": "template-variable",
            "begin": "\\{!!",
            "starts": {
                "end": "!!\\}",
                "returnEnd": true,
                "subLanguage": "php"
            }
        },
        {
            "className": "template-variable",
            "begin": "!!\\}"
        },
        {
            "className": "template-tag",
            "begin": "@php",
            "starts": {
                "end": "@endphp",
                "returnEnd": true,
                "subLanguage": "php"
            },
            "relevance": 10
        },
        {
            "begin": "@[\\w]+",
            "end": "[\\W]",
            "excludeEnd": true,
            "className": "template-tag"
        }
    ]
}
```

At a very basic level, this JSON files uses RegEx patterns to describe starting and ending delimiters. Those patterns are used to match your code blocks against a particular type of token and then add a class to the wrapping HTML element.

As an example, the very first items inside of the `contains` key is an object that stores information about comments. The `className` describes which `hljs-` class will be added to that text node. In this case a `hljs-comment` class will be added when `{{--` is encountered.

When that first pattern is matched, it will continue to match the text until the `end` pattern matches. As a result, our Blade comments are rendered as:

```blade
{{-- This is a comment. --}}
```

Any objects that have a `starts` key indicate that matching the `begin` pattern should start a new sublanguage block. This is what lets you highlight text inside of `{{ }}` as PHP, instead of a plain-text string.

The same applies to the `@php` and `@endphp` blocks. Everything that is found within those 2 directives will be highlighted as PHP.

```blade
{{ \Example::method() }}

@php
$example = 2 + 2;

echo $example;
@endphp
```

The `@php` and `@endphp` rules also have a `relevance` key. The higher that value of this key, the more likely it is to be used to automatically match the current syntax.

If you don't specify which language you are currently rendering and your code contains an `@php` directive, Highlight.php will use this relevance and assume you're trying to render Blade.

### Storing our syntax

This is all down to personal preference, but I like to keep my `blade.json` file in a `resources/syntax` folder in my Laravel applications. You can of course place this anywhere you like, just be sure to change any references to it later on.

## Registering the syntax

Once you have created the `blade.json` file, we need to tell Highlight.php to use this new syntax definition. This is really simple and only requires a single line of code:

```php
\Highlight\Highlighter::registerLanguage('blade', resource_path('syntax/blade.json'), true);
```

The first argument is the identifier for the language. In this case, I'll use `blade`.

The second argument is where your `blade.json` file is stored. I've stored mine in `resources/syntax/blade.json` so I'm using the `resource_path()` helper to get the correct path.

The third argument is optional, but it will forcefully overwrite any existing `blade` definitions. At the time of writing, Highlight.php doesn't have it's own (obviously, that's why you're here) so I'm going to say `true` so that nothing unexpectedly breaks in the future.

> Ensure that you execute this code **before** attempting to highlight anything. In a Laravel application, you could put it inside of a `ServiceProvider`.

## Using the custom syntax

Once that's all done, you will be able to use `blade` code in your blocks. Here's an example:

```blade
<h1>
    @auth
        Hello, {{ $user->name }}!
    @else
        Hello!
    @endauth
</h1>

<livewire:user-profile user="{{ $user->name }}" />
```

## Planned improvements

As I mentioned before, code inside of `{{ }}` will try to be highlighted using the PHP syntax definitions. This is great, but when you try to right code inside of directives that expect expressions, it isn't highlighted correctly:

```blade
@if(2 + 2 === 5)
    {{ 5 }}
@endif
```

This is a limitation of Highlight.js and, in turn, Highlight.php. Since the tokeniser relies on a beginning and ending pattern, it's quite hard to match all content between a pair of matching parentheses.

There might be a way to solve this, but my RegEx skills are nowhere near good enough. If you've got any ideas, I'd love to know on [Twitter](https://twitter.com).

Another thing that I'd like to add in PHP highlighting inside of `<x:` or `<livewire:` attribute bindings. Since the syntax definition extends from XML, the attributes themselves can be highlighted but the content of those attributes is just rendered as a string.

This one is a bit easier to solve than the directive expressions, so I'll play around with the RegEx and update this article accordingly.

If you want a separate reference, I've put the slimmed down instructions into a [GitHub Gist here](https://gist.github.com/ryangjchandler/f939b4105cf665e564df638d93e8c7d7).

Got any ideas or improvements? Comment on the Gist above and I'll reply as best as I can.