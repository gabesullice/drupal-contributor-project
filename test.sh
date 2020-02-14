#!/bin/sh

set -ev

SCRATCH_DIR=scratch

rm -rf "$SCRATCH_DIR"/vendor/drupal/*

mv "$SCRATCH_DIR"/vendor ./

rm -rf "$SCRATCH_DIR"

mkdir "$SCRATCH_DIR"

mv vendor "$SCRATCH_DIR"/

pushd "$SCRATCH_DIR"/

cp ../drupal-contrib-project/composer.json ./

composer install -v

composer config repositories.acquia-migrate vcs git@github.com:acquia/acquia_migrate.git

composer require -v drupal/acquia_migrate

popd
