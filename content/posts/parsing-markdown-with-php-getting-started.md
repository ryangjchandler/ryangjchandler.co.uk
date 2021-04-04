---
title: 'Parsing Markdown with PHP: Getting Started'
slug: parsing-markdown-with-php-getting-started
excerpt: 'Markdown is a great way of making notes, writing articles and generally managing content. Let''s take a look at how quickly you can begin using Markdown in your PHP applications.'
published_at: 2020-11-07T17:00:00+00:00
category_slug: php
---
I'm a huge fan of Markdown. I use it, literally, everywhere I can. The article that you're reading right now was written in Markdown. If I'm ever making notes, I'm using an application that supports Markdown.

Personally, I find it to be the most consistent way of writing. Yes, there are lots of different flavours but they all have the same base.

Here's an example of some Markdown:

```markdown
# Let's get started with a heading.

This is some **bold** text.

These are _italics_.

Here is a small bit of `code`
```

Markdown was inspired by text-to-HTML filters. They're tools designed to take some non-HTML text and transform them into good ol' hypertext.

I won't go over the basics of Markdown in this series. The best place to read about that is on the [author's website (John Gruber).](https://daringfireball.net/projects/markdown/)

This series will be using tools to transform Markdown that follows the [CommonMark](https://commonmark.org/) specification into HTML. 

## Getting started

First thing that you need to do to start using Markdown in a PHP application is, you guessed it, install a Composer package.

Since I'm going to be using the CommonMark specification, we need to use a tool that supports that spec.

Luckily the wonderful people over at The PHP League have developed a package for that, `league/commonmark`

Run the following command to get it installed:

```bash
composer require league/commonmark
```

## Parsing your first Markdown

Now that the package is installed, you can start using it straight away. 

First, create a new instance of the `League\CommonMark\CommonMarkConverter` class.

```php
use League\CommonMark\CommonMarkConverter;

$converter = new CommonMarkConverter;
```

Next, call the `convertToHtml()` method on the object and pass through a string of Markdown.

```php
use League\CommonMark\CommonMarkConverter;

$converter = new CommonMarkConverter;

$html = $converter->convertToHtml('# Hello World');
```

The `$html` variable will now hold the HTML equivalent of the Markdown provided, in this case it will be `<h1>Hello World</h1>`.

## Sanitising the Markdown

Since Markdown is converted to HTML, it makes sense that HTML can be written within the Markdown. 

When you're transforming user input, this can be risky and might open up the opportunity for an XSS attack.

The PHP League have thought about this though and added an option to the converter that will help out.

To begin using these configuration options, you need to provide an array when constructing the `League\CommonMark\CommonMarkConverter` object.

```php
use League\CommonMark\CommonMarkConverter;

$converter = new CommonMarkConverter([
    'html_input' => 'escape'
]);

$html = $converter->convertToHtml('# Hello World');
```

If you now change the Markdown being parsed and include some HTML, the result will be escaped.

```php
use League\CommonMark\CommonMarkConverter;

$converter = new CommonMarkConverter([
    'html_input' => 'escape'
]);

$html = $converter->convertToHtml('<h1>Hello World</h1>');
```

After being transformed, `$html` will now hold the string `&lt;h1&gt;Hello World&lt;/h1&gt;` which is the escaped version of the HTML being transformed.

> If you're interested in some of the other options available, visit the package's documentation on _[Configuration](https://commonmark.thephpleague.com/1.5/configuration/)_.

## Sign off

Thanks for reading this article. In the next instalment, I'll be showing you some helpful extensions you can use to make your Markdown writing experience less painful.

Thanks for reading! 👋