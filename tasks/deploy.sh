#!/usr/bin/env bash

# git reset HEAD^ # start by resetting against HEAD

version_file=./.version # change this to your desired version file
source_branch=master
production_branch=production
author_string="Ryan's Deployment Script <deployments@ryangjchandler.co.uk>"
new_tag_date=$(date +"%Y-%m-%d %H-%M-%S")
new_tag=$(date +"%Y%m%d%H%M%S") # set a new tag for the deployment

echo "Previous deployment: $(git describe --abbrev=0 --tags)"
echo "New deployment: ${new_tag}"

if [[ -f "${version_file}" ]]; # only remove the version file if it exists
then
    rm $version_file 
fi

echo "${new_tag}" >> ./.version # write the new tag to the version file

# only commit the new version file it is has actually changed
# this will work since we reset against the HEAD at beginning
if [[ -n $(git status --short) ]];
then
    git add .version
    git commit --author="${author_string}" -m "Version number for deployment ${new_tag} [${new_tag_date}]"
    git push --force origin HEAD # this is a dangerous force push, but I like to live life on the edge

    git fetch
    git pull # pull just in case we missed something
    git checkout ${production_branch}
    git pull # pull just in case we missed something
    git merge ${source_branch} # merge source branch (i.e. master) into production
    git commit --author="${author_string}" -m "New deployment ${new_tag} [${new_tag_date}]"
    git push --force origin ${production_branch} # another dangerous force push
fi

git fetch && git checkout ${source_branch} # return to source branch

echo "Deployment finished."