---
title: Deploying my Jigsaw Site (April 2020)
date: 2020-04-03
published: true
categories: [php, deployment]
extends: _layouts.post
section: content
---

As of this moment in time (3th April 2020), this site is deployed on [Netlify](https://netlify.com) and built with [Jigsaw](https://jigsaw.tighten.co) (a static site generator from the very generous and clever folks at [Tighten](https://tighten.co)).

For me, this combination is _nearly_ perfect. My day job is working as a "full stack" web developer, working mostly with the [Laravel framework](https://laravel.com) so most of Jigsaw's core features like Blade templates are second nature. I will write an article on why I chose Jigsaw soon, but that's the basis of it.

It's not quite the perfect setup though. Netlify is great, like really great. It's got lots of handy tools and is a solid tool, but their free plan is a bit too limited on build minutes. For most this wouldn't be a problem, but I like to constantly improve and experiment so those build minutes would disappear very, _very_ quickly.

When you initially setup Netlify, automatic deployments are turned on, at least I think they are. After only a week of having a personal site, I'd used up half of my monthly quota. That's **not** good, so I needed to change my deployment strategy.

Here's how the deployment was running before I made these changes:

1. Make changes on branch.
2. Merge into `master`.
3. Netlify automatically builds my site and deploys to their CDNs.

That's all it was, really simple. So I made some changes and this is my new deployment process:

1. Make changes on branch and send in a pull request.
2. Merge into `master` which automatically closes any issues.
3. Pull `master` on a local copy of the site.
4. Run `composer deploy`.
5. Netlify automatically builds my site from the **`production`** and deploys to their CDNs.

## The new process

There's only 2 extra steps now, but the details of those steps matter most.

### Sending in a pull request

It seems strange, I know. Why send in a pull request to my own project when I'm the only person working on it? Well, it automates a small part of the process for me. See, I like to use GitHub's issues to keep track of changes I want to make. It's my basic project management tool. 

When I send in a pull request, I can mention the issue ID in the description like "Closes #1" and it will automatically get closed when the pull request is merged. Any automation is good automation in my eyes.

### Running `composer deploy`

This is the magical step in my eyes. Previously, my site was being deployed from the `master` branch which is never really good practice. My own branching strategy says (nowhere in writing) that `master` should always contain the latest stable changes, but it should never be used for deployment. 

My main reasoning behind this is being able to rollback on deployments. A simple way to handle rollbacks is by un-doing a commit. Doing this on `master` would mean it does not have the latest stable changes anymore. If I use a `production` branch instead, `master` does not get affected.

I also like to have a clear timestamp of a deployment. With a Git repository, the simplest way to do this is by tagging the repository and initiating a release, because in reality that's all it is.

To simplify both of those steps and take some of the management off of me, I decided to write a Bash script that handles it all for me. This script can be found at [`tasks/deploy.sh`](https://github.com/ryangjchandler/ryangjchandler.co.uk/blob/a353d8bad8b7d7ab7e18ce1150ec5e67e70594cc/tasks/deploy.sh) for reference. 

I'm able to run it via Composer by using a custom script inside of my `composer.json` file:

```json
{
    ...
    "scripts": {
        "deploy": "./tasks/deploy.sh"
    }
}
```

Let's take a look at that `tasks/deploy.sh` script and briefly explain what it's doing (<strong class="text-red-700">WARNING: the file is long</strong>):

<details open="true">
    <summary>Hide code block</summary>
    <div class="pt-4">

```bash
#!/usr/bin/env bash

# add some colours for script output
green=$(tput setaf 2)
reset=$(tput sgr0)
bold=$(tput bold)

version_file=./.version # change this to your desired version file
source_branch=master
production_branch=production
author_string="Ryan's Deployment Script <deployments@ryangjchandler.co.uk>"
new_tag_date=$(date +"%Y-%m-%d %H-%M-%S")
new_tag=$(date +"%Y%m%d%H%M%S") # set a new tag for the deployment

echo "${bold}${green}Previous deployment:${reset} $(git describe --abbrev=0 --tags)"
echo "${bold}${green}New deployment:${reset} ${new_tag}"

if [[ -f "${version_file}" ]]; # only remove the version file if it exists
then
    rm $version_file >> /dev/null 2>&1
fi

echo "${new_tag}" >> ./.version # write the new tag to the version file

# only commit the new version file it is has actually changed
# this will work since we reset against the HEAD at beginning
if [[ -n $(git status --short) ]];
then
    git add .version >> /dev/null 2>&1
    git commit --author="${author_string}" -m "Version number for deployment ${new_tag} [${new_tag_date}]" >> /dev/null 2>&1
    git push --force origin HEAD >> /dev/null 2>&1 # this is a dangerous force push, but I like to live life on the edge

    git fetch >> /dev/null 2>&1
    git pull >> /dev/null 2>&1 # pull just in case we missed something
    git checkout ${production_branch} >> /dev/null 2>&1
    git pull >> /dev/null 2>&1 # pull just in case we missed something
    git merge ${source_branch} >> /dev/null 2>&1 # merge source branch (i.e. master) into production
    git commit --author="${author_string}" -m "New deployment ${new_tag} [${new_tag_date}]" >> /dev/null 2>&1
    git tag -a "${new_tag}" -m "New deployment ${new_tag} [${new_tag_date}]" >> /dev/null 2>&1
    git push --force origin ${production_branch} --tags >> /dev/null 2>&1 # another dangerous force push
fi

git fetch && git checkout ${source_branch} >> /dev/null 2>&1 # return to source branch

echo "${bold}${green}Deployment finished${reset}."
```

</div>

</details>

We can ignore the colour related stuff at the top. It helps to make it look pretty, and you'll also need `tput` installed on your machine.

The first real step is setting up the deployment variables. For the script to execute, it needs to know what the `source_branch` is (`master`), the `production_branch` (`production`) and some extras. The `author_string` represents the user who is making the deployment commit. I'm using a fake user, so it looks a bit ugly on GitHub. It does help me quickly distinguish between deployment commits and other commits though, so I'm happy to use it. The `new_tag_date` is set as early as possible, along with the `new_tag`. Both are using the current date and time, just in different formats.

I chose to use the current date and time for some easy identification of when the deployment occurred, without needing to click into the "Releases" section on GitHub. I can see all of that from the commit itself.

With these variables set, I can output some informative stuff into the terminal. Just sharing what the previous deployments tag was and then the new deployment tag.

The next part will check to see if a `.version` file exists in the root of my project. If it does, it gets deleted. Let's talk about this for a second.

### The `.version` file

This file is used to keep track of the latest version, hence the name. In theory, you could go into the "Releases" section on GitHub and find out, or check the previous deployment commit but that's too much effort. I can also use this file to see what deployment is currently live, specifically after a rollback.

I'm just removing the file and writing the new tag to a fresh version of it. Nothing special going on here.

### Actually deploying the code

With the `.version` file handled we can move onto actually getting the latest code live and with that, the first we need to do is check if there are _any_ changes to be committed. In the case that the previous `.version` changes failed, there would be no changed files so the deployment commits will never unnecessarily be made.

`-n` just checks if a string is **not** empty. Again, nothing special going on here. 

The next part is simple still, just good ol' `git` commands. I'm then adding the `.version` file and committing it with a pre deployment message, indicating that a deployment is about to be processed. All of these commands are being pushed to `/dev/null` so the output doesn't appear in my console.

The next part is a bit risky because we're going to force push to `master` using the `--force` flag. This will stop any failed pushes due to out of sync `HEAD`s being shown or required merges. I wouldn't do this normally, but I'm an adult and know the risks so it's fine by me.

Now for the speed explanation of what happens next...

Then it will `fetch` the latest changes just to be certain everything is up to date, `pull` just in case, `checkout production` so it is on the deployment branch, `pull` again, `merge master` so that all of the latest and stable changes are ready for deployment, `commit -m` the deployment message with the custom author using the `--author` flag, `tag` a new release using the `new_tag` variable set towards the start and finally, `--force push` to the deployment branch with tags using the `--tags` flag.

After all of that, Netlify will pick up that changes have been made to `production`. It then runs my deployment commands (`yarn production`) inside of their build container using `PHP_VERSION=7.4` as an environment variable and pushes the `build_production` folder to their CDNs.

Whilst that is running elsewhere, the script will `fetch` and `checkout` my source branch (`master`) to ensure I don't accidentally commit changes to the `production` branch.

And **that is it! 🎉**

## Improvements to be made

Like I've said, Netlify is great but it's so limited on build minutes. That's the main reason I didn't want to automatically build from `master`. 

The other problem I have is the automated deployments. Each time a deployment is made, all of my assets are rebuilt (CSS and images transferred) before my site actually builds. With Netlify there's no easy way to run multiple commands like there is with GitHub Actions, so my first improvement would be ditching Netlify altogether and moving to GitHub Pages. This would let me run deployment from GitHub Actions and check certain conditions, like "has my CSS file changed?" or "did my `tailwind.config.js` change?". With those changes, my deployment & build times would be reduced dramatically.

It would also be nice to have everything unified in one space. My webmentions are updated every 12 hours using a GitHub Actions workflow, so having all of my workflows on the same platform would create less friction for myself when developing and maintaining the site.

## Sign off

Hopefully you've made it this far. The deployment process isn't too complicated at the moment, but these sort of things change quite often so when I do decide to move to GitHub Pages, I'll be sure to write a new article about how and why I did it. 

If you found it interesting or helpful at all, you can share this article on Twitter and write some nice stuff about it. It will be shown in the "Webmentions" section below.

I won't keep you any longer, have a good one!