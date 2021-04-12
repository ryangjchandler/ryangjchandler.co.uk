---
title: 'Quickly swap 2 variables in PHP'
slug: quickly-swap-2-variables-in-php
updated_at: 2021-04-12T08:54:11+00:00
created_at: 2021-04-12T08:54:11+00:00
---
You can use PHP's `list()` construct to quickly swap the value of 2 variables. You can also use the short-hand list notation.

```php
$a = 2;
$b = 1;

list($a, $b) = [$b, $a];
```

Now `$a` will hold the value of `$b = 1` and `$b` will hold the value of `$a = 2`.

The `list()` syntax is a bit outdated now, so you could also use the short-hand notation.

```php
$a = 2;
$b = 1;

[$a, $b] = [$b, $a];
```