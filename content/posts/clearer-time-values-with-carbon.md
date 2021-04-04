---
slug: clearer-time-values-with-carbon
title: 'Clearer Time Values with Carbon'
excerpt: 'How often do you see something like `2 * 24 * 60 * 60` and wonder what that value actually represents and what those magical numbers mean? Don''t worry, Carbon''s constants are here to help you out.'
published_at: 2020-06-08T21:00:00+00:00
---
Lots of applications involve date and time manipulation. Whether it's figuring out what day of the week it is, how many seconds are in a week or how many hours are in a century.

Quite often, you'll see something like:

```php
$minutesInAWeek = 7 * 24 * 60
```

On a small scale, it's quite clear what is going on, but if you wrap this bit of logic in a function or another calculation, you can quickly lose sight of what `60` represents.

Luckily, [Carbon](https://carbon.nesbot.com/) provides a set of [constants](https://carbon.nesbot.com/docs/#api-constants) that can clear it up, making it easy to see what each number represents.

Lets take our example above and use these constants to make what's happening clearer:

```php
use Carbon\Carbon;

$minutesInAWeek = Carbon::DAYS_PER_WEEK * Carbon::HOURS_PER_DAY * Carbon::MINUTES_PER_HOUR;
```

Yes, it's verbose. But this kind of verbosity is good, in my opinion.

If we wanted to take this further and figure out how many seconds are in a year, we could do:


```php
use Carbon\Carbon;

$minutesInAWeek = Carbon::DAYS_PER_WEEK * Carbon::HOURS_PER_DAY * Carbon::MINUTES_PER_HOUR;

$secondsInAYear = $minutesInAWeek * Carbon::SECONDS_PER_MINUTE * Carbon::WEEKS_PER_YEAR;
```

There's some more constants too, you can check out [the full list in the documentation](https://carbon.nesbot.com/docs/#api-constants).