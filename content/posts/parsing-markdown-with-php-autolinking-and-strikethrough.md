---
slug: parsing-markdown-with-php-autolinking-and-strikethrough
title: 'Parsing Markdown with PHP: Autolinking and Strikethrough'
excerpt: 'Let''s take a look at how you can extend the CommonMark converter to make working with links easier and allow you to strikethrough text.'
published_at: 2020-11-09T17:00:00+00:00
---
When you want to use links in your Markdown, you would normally use the following syntax:

```markdown
[Text for the link](https://example.com)
```

Sometimes you don't need text for the link. Instead you want the URL itself to be clickable, so you end up doing something like this:

```markdown
[https://example.com](https://example.com)
```

Some editors and Markdown parsers, such as GitHub's one, are smart and will automatically makes URLs clickable in your text. This is known as "autolinking".

The same thing can be achieved with the CommonMark parser that we have been using in this series.

## Setting up the environment

Before we can get autolinking, we need to first change how our parser is being setup. Previously, I showed you how to parse Markdown like this:

```php
use League\CommonMark\CommonMarkConverter;

$converter = new CommonMarkConverter;

$html = $converter->convertToHtml('# Hello World');
```

The `league/commonmark` package also provides a nice extensible API available through, what they call, [custom environments](https://commonmark.thephpleague.com/1.5/customization/environment/). 

To create a custom environment, you need to create a new instance of the `League\CommonMark\Environment` class. Instead of instantiating it via the `new` keyword, you instead need to use a "named constructor".

> A named constructor is a static method on the class that is responsible for instantiating that class in a particular fashion.

The named constructor ensures that all of the default renderers and parsers are setup on the converter object so that you don't have to do it yourself.

Here's how it's done:

```php
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;

$environment = Environment::createCommonMarkEnvironment();

$converter = new CommonMarkConverter;

$html = $converter->convertToHtml('# Hello World');
```

Now that the environment has been created, it needs to be provided to the `CommonMarkConverter` object. 

As you saw in the last instalment, the first argument to the constructor is an array of options. The environment needs to be passed through as the second argument, like so:

```php
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;

$environment = Environment::createCommonMarkEnvironment();

$converter = new CommonMarkConverter([], $environment);

$html = $converter->convertToHtml('# Hello World');
```

## Adding the autolink extension

With the environment setup, the extension can be added using the `Environment::addExtension()` method.

Each extension is declared as a separate class. In this case, the autolinking extension is declared under the `League\CommonMark\Extension\Autolink\AutolinkExtension` class.

The `Environment::addExtension()` method will expect a new instance of the extension:

```php
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Extension\Autolink\AutolinkExtension;

$environment = Environment::createCommonMarkEnvironment();

$environment->addExtension(new AutolinkExtension);

$converter = new CommonMarkConverter([], $environment);

$html = $converter->convertToHtml('This is an awesome website, check out https://ryangjchandler.co.uk now!');
```

With all of this setup, you can use URLs as links in your Markdown. Running the following Markdown through the converter:

```markdown
This is an awesome website, check out https://ryangjchandler.co.uk now!
```

Will result in the following HTML:

```html
This is an awesome website, check out <a href="https://ryangjchandler.co.uk">https://ryangjchandler.co.uk</a> now!
```

## Striking through text

Although I can't think of many places where I ever need to strikethrough text, it *can* be useful sometimes. A good use case could be in a GitHub issue where you want to strikethrough something you have said previously and update it.

Out of the box, that isn't supported. The syntax for striking through also changes between specifications, but in this case, it's going to be something like this:

```markdown
The next piece of text should be ~~striked~~ out.
```

To add support for this, you need to add another extension to the environment.

The extension needed is the `League\CommonMark\Extension\Strikethrough\StrikethroughExtension` extension.

```php
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Extension\Strikethrough\StrikethroughExtension;

$environment = Environment::createCommonMarkEnvironment();

$environment->addExtension(new StrikethroughExtension);

$converter = new CommonMarkConverter([], $environment);

$html = $converter->convertToHtml('The next piece of text should be ~~striked~~ out.');
```

## Sign off

Thanks for reading this article. In the next instalment, I'll be showing you how you can use tables in your Markdown.

Thanks for reading! 👋