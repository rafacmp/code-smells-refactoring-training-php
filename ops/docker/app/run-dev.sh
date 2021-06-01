#!/bin/sh
set -e
set -u
set -o pipefail

#command sudo -u root composer config --global github-oauth.github.com $GITHUB_TOKEN


#command sudo -u root npm install --prefix ./nuxt --unsafe-perm #comment this line if you are working with `make dev-sync`
command php-fpm
