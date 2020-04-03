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
