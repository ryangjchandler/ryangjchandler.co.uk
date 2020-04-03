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