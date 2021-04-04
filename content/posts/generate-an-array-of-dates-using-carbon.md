---
slug: generate-an-array-of-dates-using-carbon
title: 'Generate an Array of Dates Using Carbon'
excerpt: 'I find myself needing to loop over an array of dates quite often for forms at work. It''s surprisingly easy thanks to Carbon.'
published_at: 2020-06-02T18:00:00+00:00
---
When a customer at [Surewise](https://surewise.com) wants to take out a new insurance policy, they can only take one out with a start date within the next thirty days.

Date pickers are horrendnous with browser compatibility, given IE11 and Safari don't support them, so we instead choose to use a simple `<select>` element with the dates as `<option>` inside.

Here's how you can generate an array of dates for a given period:

```php  
use Carbon\{
    CarbonPeriod,
    Carbon
};

CarbonPeriod::create(
    Carbon::now(),
    Carbon::now()->addDays(30)
);
```

Calling this method will return an instance of `Carbon\CarbonPeriod` which has implements the  `Iterator` interface and can therefore be used inside of a `foreach` statement.

When looping over the `CarbonPeriod` instance, the iteration variable will be an instance of `Carbon\Carbon`, so you can call all of the regular `format` and `toDateTimeString()` methods.