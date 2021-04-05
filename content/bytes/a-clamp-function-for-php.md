---
title: 'A `clamp` function for PHP'
slug: a-clamp-function-for-php
created_at: 2021-04-05T19:08:18+00:00
updated_at: 2021-04-05T19:12:27+00:00
---
You can use this function to "clamp" a number between a `min` and `max`.

```php
function clamp($subject, $min, $max) {
    return max($min, min($max, $subject));
}
```

This is perfect for when you need a number to always be within a range, e.g. percentages must be greater than 0 and no more than 100.