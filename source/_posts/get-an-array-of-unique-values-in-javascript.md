---
title: Get an Array of Unique Values in JavaScript
date: 2020-04-08
published: true
categories: [tips-and-tricks, javascript]
---

For anyone who has used PHP before, you're probably familiar with the `array_unique()` function. You would use it like this:

```php
array_unique([1, 2, 3, 4, 5, 5, 6, 7, 7]); // returns [1, 2, 3, 4, 5, 6, 7]
```

Unfortunately, JavaScript doesn't have a the core functionality to achieve the same result. Luckily for us, there is a couple of different ways to get there.

These methods are going to assume that you are using primitive values (string, number, etc).

## Distinct Filtering

This approach requires a method that filters the array down. We'll start by defining the `distinct()` method:

```javascript
function distinct(value, index, items) {
    return items.indexOf(value) === index;
}

// or a single-liner
const distinct = (value, index, items) => items.indexOf(value) === index;
```

All this function does it check to see if the `index` of our current `value` inside of the `items` array matches our current index. If it returns **true**, then we want to keep it in the array since it's the first occurrence. If it returns **false**, it means that the `value` has been found somewhere else in the array so it gets filtered out.

Of course, this function doesn't do the removing so we need to pass it into `Array.filter()`:

```javascript
const distinct = (value, index, items) => items.indexOf(value) === index;

let numbers = [1, 2, 3, 4, 5, 5, 6, 7, 7];

let distinctNumbers = numbers.filter(distinct); // returns [1, 2, 3, 4, 5, 6, 7]
```

That wasn't hard now, was it?

## Set objects

If you've not heard of `Set` objects before, they are essentially arrays that can store primitive values, as well as object references, but have enforced uniqueness. That means no two values can be the same inside of a `Set`, which helps us out a bunch.

```javascript
let distinctNumbers = new Set([1, 2, 3, 4, 5, 5, 6, 7, 7])
```

Our `numbers` variable now holds an instance of `Set` with `[1, 2, 3, 4, 5, 6, 7]`. For most of us, this wouldn't be a problem since `Set` has various methods such as `forEach()`, `values()` and `entries()` so we could do common operations on the `Set` directly, but what if we needed to use the `.indexOf()` method again? It won't work, correct!

The next step is transforming our `Set` into an `Array`. In modern browsers, that can be done really easily using the spread (`...`) operator.

```javascript
let distinctNumbers = [...new Set([1, 2, 3, 4, 5, 5, 6, 7, 7])]
```

That's all. We now have an array of unique values. If you wanted, you could package this into a nice little helper function called `arrayUnique`:

```javascript
const arrayUnique = (array) => [...new Set(array)]
```

Copy and paste that into your `utils.js` file or wherever you store those sort of functions.

## Sign off

Thanks for reading the article. Not much to read really, but it's a useful helper function to have until it gets implemented on the `Array` object.