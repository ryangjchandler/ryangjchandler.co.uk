---
title: 'Running GitHub Actions for Certain Commit Messages'
slug: running-github-actions-for-certain-commit-messages
excerpt: 'A quick look at how you can configure your GitHub Actions workflows to only run when a certain phrase is present in the commit message.'
published_at: 2020-09-29T12:00:00+00:00
category_slug: github-actions
---
I'm going to be honest with you all for a second. I write a lot of `wip` commits. These commits are normally small changes that I want to push up to GitHub so that:

1. I don't lose things if anything goes wrong and my backup hasn't picked it up.
2. If I can't describe the change I have just made.
3. If I'm demonstrating something to somebody on a pull-request.

The problem is, my actions are setup to run on `push`, so every single `wip` commit gets run through the CI process, whether it be running tests, linting or formatting.

After doing some research, I found a way of preventing these from running on every single commit.

```yml
jobs:
  format:
    runs-on: ubuntu-latest
    if: "! contains(github.event.head_commit.message, 'wip')"
```

Now, whenever I push a `wip` commit or any commit that contains the word `wip`, it will be marked as skipped inside of GitHub actions.

You could also flip the logic and perhaps do something like:

```yml
jobs:
  format:
    runs-on: ubuntu-latest
    if: "contains(github.event.head_commit.message, '[build]')"
```

Any commit that contains `[build]` will now trigger these jobs, everything else will be skipped.

You can thank me later! 😉