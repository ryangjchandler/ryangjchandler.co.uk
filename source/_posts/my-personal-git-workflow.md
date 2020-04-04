---
title: My Personal Git Workflow
date: 2020-04-05
published: false
categories: [php, deployment]
extends: _layouts.post
section: content
---

[Git](https://git-scm.com) is a command line tool for managing and versioning software. It was originally created by [Linus Torvalds](https://en.wikipedia.org/wiki/Linus_Torvalds), who also created the Linux kernel, in 2005 and is now maintained by [Junio Hamano](https://twitter.com/jch2355).

Various other version control systems and software exists, but I can imagine Git is the most popular, especially with platforms such as [GitHub](https://github.com) and [Bitbucket](https://bitbucket.org).

Each and every person will have their own workflow and personal preferences, but I thought I'd share some of my own in case anyone is looking for suggestions.

Before we dive in, this article is aimed towards those of you using **Linux or macOS** systems. Windows is a completely different ball game, so I'll leave those tips to people who know what they're talking about.

## Command line

The main way to access Git and harness it's power is through the command line. I think most modern OSes come pre-installed with Git, especially if they are BSD or GNU/Linux based. The version of Git might not always be the latest, but my aliases never use any special functionality.

When I'm working in the terminal, I like to be as efficient as possible. I don't want to type out super long commands, or have to use man pages. It should only take me 3-5 seconds to commit something to my repository. The best way I know to cut down the command size is using **aliases**.

An **alias** just acts as a shortcut for a longer, more formal command. They can also be used for common spelling mistakes.

To create an alias, you just need to open your `.bashrc` or `.zshrc` file which should be in your home directory and add a single line. If this file doesn't exist, create it because it's always super useful for customising and modifying your terminal experience. Here's the syntax:

```bash
alias sl="ls"
```

And that's it, we've created an alias. This alias in particular will cover any cases where I accidentally type `sl` instead of `ls` to list the contents of a directory.

### Git aliases

I do have quite a few git aliases, designed to reduce keyboard travel and usage. Most of them are pretty self explanatory, so here they are:

```bash
alias gs="git status --short"
alias gsf="git status"
alias ga="git add"
alias gaa="git add ."
alias gc="git commit -m"
alias gf="git fetch"
alias gck="git checkout"
alias gfc="git fetch && git checkout"
alias gp="git push origin HEAD"
alias branch="git checkout -b"
alias nuke="git reset --hard && git clean -fd"
```

Like I said, most of them are self explanatory. One that does look strange is the `gp` alias (`git push origin HEAD`). The reason I'm are using `HEAD` to push is so that it will always push to the current branch. I don't need to set the upstream or anything like that. If I wanted to set the upstream, I could still attach the `-u` flag to the end.

The only other strange one I'd like to mention is `gs`. Normally people will use `git status` on it's own (`gsf` as an alias), but in my opinion it fills up my terminal with a load of crap I don't care about. I just want a simple preview of what files have been changed, delete or are untracked. That's why the `gsf` alias exists. It stands for `git status` full and will give me the regular bloated output.

Out of the aliases, my favourite is probably `nuke`. I feel like such a boss when I use it, because it's destructive. It will just wipe all changes I've made since the last commit, hence the usage of `nuke`. You might have seem this alias elsewhere as `nah`. It's a common one.

The idea behind these aliases, as I mentioned, is reducing how many long commands I need to write on a daily basis as well as keyboard movement. All of these are short commands now and can be typed super quick. I can go from having no files staged / tracked, to having all of my changes added, committed and pushed within about 5 seconds.

## GUI

I like to run all of my Git commands through the terminal, but sometimes I'll open up a desktop application to compare large diffs and such.

For this purpose, I always turn to [GitHub Desktop](https://desktop.github.com/). It's an [Electron application](https://www.electronjs.org/), so not necessarily the fastest or most memory-friendly but it's super minimal and actually works with any Git repository, not just repositories on GitHub. I use it at work for our Bitbucket repositories and it's great.

The feature list for this application is quite small and simple, but that's on purpose. It can commit for you, fetch for you, merge pull requests and more recently, create new issues. It's definitely missing some features, but for the common Git user it should be fine.

## Branching

I briefly mentioned by branching strategy in my [previous post about deploying my Jigsaw site](/articles/deploying-my-jigsaw-site-april-2020), but I want to detail it some more here.

### `master`

Of course, I have a `master` branch. This branch always contains the **latest, stable code**. At any moment in time I should be able to pull this repository down and have the latest and greatest code, as well as expect very few (hopefully zero) errors.

Any pull request that comes in to a project should be targeting `master`, so long as it has been tested and is **stable**. 

`master` should **never** be used for deployment, since it is constantly changing. Every time a pull request gets merged, you don't want a deployment to automatically be sent. If you're committing directly to master (I really hope you're not), you also don't want a deployment to be triggered.

Just because `master` is stable, it doesn't necessarily mean all of the code in the branch is in production. You might need to merge 3 or 4 pull requests before deploying, so never assume it's been tested in a production environment.

Never, ever, ever should you commit straight to `master`, unless the project is still under active development. Once the project has reached a **stable** and working point, all changes should be made in separate branches and merged into `master`.

The reason I've highlighted **stable** so much in this section is because it's important. Stability is one of the most important things you should consider whilst building your application. It shouldn't be dripping water every 5 seconds, it should be able to take a .50 cal to the face and maybe get grazed.

### `production` and `staging`

My preference for deployment is using a `production` and `staging` branch. One is used for live deployments, which are also stable and follow similar rules to `master`, and the other is for testing new code in an environment that should mimic or be a clone of the live environment.

When code needs to be deployed, I like to `tag` a new release. This `tag` could be a timestamp, a version number, it could be anything. It's just used a point-in-time indicator for the deployment.

`production` should be stable all of the time. If you were to checkout the `production` branch locally, it should run smooth and be all shiny. 

`staging` doesn't follow this rule though. This branch could be so broken that it makes more sense to delete it and start again. I would use this branch to share new and upcoming features with clients or the team, so that they can pick it apart and find problems for me to fix. The one important thing to remember though is the environment itself should mimic the live one as closely as possible, just to be sure that there is no hiccups during a `production` deployment.

Both of these branches should never receive direct commits. You should be doing your work in a `feature` branch and merging it in to `staging`, or merging `master` into `production` for a deployment.

### Feature branches

Feature branches are quite common. If the feature itself has not been set in stone, I'll generally just create a toy branch to test it out and play around. If the feature is a must-have and wanted, I'll follow a different naming convention, prefixing the feature name with `feature/`.

For example, I want to add comments to my site. I would do this inside of a feature branch called `feature/comments`. If I was toying with the idea and it wasn't rock solid, then `comments` would also be fine.

When working in larger teams where you are the only person working on a feature, it's nice to add a suffix or prefix to the branch to indicate who is working on it. Taking the comments example, if I was working on my own I might call my branch `feature/ryan-comments` or `feature/comments-ryan`. Find a naming convention and stick to it.

### Hotfix branches

I don't know if I like these or not. Generally, a "hotfix" is something that needs to be done quickly or is urgent, but sometimes those same hotfixes can take 8 hours to debug, taking away from the key part "hot".

I do still use them though, following a similar naming convention to the feature branches of `hotfix/brief-name-of-fix-or-problem`. It's unlikely that only one person will be working on a hotfix, if it is so urgent.

## Sign off

I hope this gave you a nice little insight into my own Git workflow. Lots of people might have different workflows, but this is quite a common one I've found.

Feel free to share this article on Twitter and detail your own workflows, I'm always interested in changing mine.

Have a good one!