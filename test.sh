#!/bin/sh

set -ev

SCRATCH_DIR=scratch

rm -rf "$SCRATCH_DIR"

mkdir "$SCRATCH_DIR"

cp ./composer.json "$SCRATCH_DIR"/

pushd "$SCRATCH_DIR"/

composer install -v

composer config repositories.acquia-migrate vcs git@github.com:acquia/acquia_migrate.git

composer require -v drupal/acquia_migrate

composer update

popd
