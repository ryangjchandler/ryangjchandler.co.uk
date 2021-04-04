---
slug: learn-go-by-building-an-uptime-checker-getting-started
title: 'Learn Go by Building an Uptime Checker: Getting Started'
excerpt: 'Begin by installing Go and writing the oh so generic "Hello, World" application.'
published_at: 2021-01-26T14:00:00+00:00
---
In this series, I'm going to be building a simple uptime checker in [Go](https://golang.org/). The idea behind this project, as well as the series, is to teach you the basics of Go and how it compares to PHP and JavaScript.

This instalment will go over how to install Go on your machine and write a generic "Hello, World" program.

## Installing Go

Go's installation process is fairly simple. All you need to do is visit the Go documentation and follow the instructions on [the "Download and install" page](https://golang.org/doc/install).

If you're using Homebrew on macOS (or even Linux), you might want to run the following command instead:

```bash
brew install go
```

## Creating a new project

I'll begin by creating a new folder and a new `main.go` file in the root.

```bash
mkdir uptime-checker && touch uptime-checker/main.go && cd uptime-checker
```

To check that Go is installed correctly, I'll run the following command in the `uptime-checker` directory:

```bash
go run main.go
```

This command tells Go to run the `main.go` file that I just created.

If Go is installed correctly, the output should be something similar to this:

```bash
package main:
main.go:1:1: expected 'package', found 'EOF'
```

## Hello, World

The error that I got when running `main.go` is actually useful. It's telling me what I need to do to successfully execute the `main.go` file.

When you write some Go, you're writing one of two things:

1. Application
2. Library

Go uses a `package` keyword to differentiate between the two types of project. The error above is letting me know that since I'm trying to `run` the `main.go` file, I need a `package` declaration at the top of the file.

Like most compiled C-style languages, Go needs some sort of entry point. It determines this entry point / application root using both a `package` declaration and a `main` function.

```go
package main

func main() {

}
```

By adding the `package main` statement at the beginning of the file, Go knows that this is indeed an application instead of a library and that it's the entry file for our application.

The `main` function is what Go will look for and try to run when our application script is invoked.

This is very different to PHP and JavaScript, both of which being procedural languages that can evaluate code from the very beginning of the file without any need for an entry point or starting line.

If I run the script now using `go run main.go`, I won't get an error anymore and the output will instead be blank.

### Printing to the console

Now that the my `main.go` file has the bare minimum code, I want to start writing to the user's terminal / console.

Go comes with a [standard libary](https://pkg.go.dev/std). This is a collection of packages that is available in any Go program or library.

To access these standard modules, I need to use the `import` keyword. This keyword is used to import external libraries / packages, as well as the standard library.

This is very different when compared to PHP and browser-based JavaScript that have their standard libraries / functions available under the global namespace.

```go
package main

import "fmt"

func main() {

}
```

I've added the `import` statement above and decided to import the `fmt` package. This package is part of the standard library and comes with a wide range of formatting functions.

Now that I've imported the `fmt` package, I can access any of it's exported functions using the `fmt` declaration.

```go
package main

import "fmt"

func main() {
    fmt.Println("Hello, World!")
}
```

If I run this program now, I get the following output:

```bash
ryan@main uptime-checker % go run main.go
Hello, World
```

And there you have it. The "Hello, World" program in Go.

## Comparing to PHP and JavaScript

Let's take that Go program and compare it to the equivalent PHP and JavaScript code.

**PHP**

```php
<?php

echo "Hello, World"
```

**JavaScript**

```jsx
console.log("Hello, World")
```

Both PHP and JavaScript require *a lot* less code to get a basic "Hello, World" program going. In general, this comes down to the nature of the language.

As I mentioned before PHP and JavaScript has a standard library of functions and keywords in the global namespace, removing the need for imports.

You also don't need to declare any entry points since they are both procedural languages that evaluate from top to bottom.

## Exploring the syntax of Go

I haven't spoken too much about the syntax of Go yet so I'll go over some of the concepts seen in the `main.go` file so far.

**Functions**

Unlike PHP and JavaScript that generally use the `function` keyword for defining functions, Go uses the `func` keyword.

**Semi-colons**

Go **does not** require semi-colons at the end of all statements like PHP does. It's more similar to JavaScript in that they're optional *(most of the time)*.

**Imports**

Go uses the `import` keyword to pull in external libraries / packages. This is similar to JavaScript's `import` keyword, the biggest difference between the two being how the package is resolved and actually included in the current namespace.

In JavaScript, you have to tell the engine what you want to call any imports.

```jsx
import Alpine from 'alpinejs'
```

This will take the default export of the `alpinejs` package and declare it under a new `Alpine` variable.

In Go-land the name of the package is used as the declaration and it becomes an object-like structure, holding all of the exported functions of the package.

```go
import "fmt"
```

This would create a new `fmt` variable that you can use anywhere in the file. If you did need to rename the declaration, you can define the new identifier before the package string.

```go
import format "fmt"
```

Now the `fmt` package will be accessible using the `format` identifier.

You might have noticed that when calling an export function, the function's name starts with a capital letter.

This is a standard in Go where any function with a capital letter will be automatically exported. Here's the basic idea:

```go
package fmt

func Println() {

}

func print() {

}
```

Since `Println` starts with a capital later, it's automatically exported as part of the `fmt` package. The `print` function wouldn't be because it doesn't start with a capital letter.

## Sign off

In the next instalment, I'll show you how to start parsing command-line arguments and options so that we can read the URL to monitor.

If you enjoyed this article or have any feedback, let me know via [Twitter](https://twitter.com/ryangjchandler).