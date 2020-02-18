Drupal Contributor Project
===

The Drupal Contributor Project is a composer project template for Drupal core
and contrib maintainers.

Drupal's official installation instructions recommend that Drupal be installed
using [Composer](getcomposer.org). However, when Drupal is installed using this
method, it is difficult to develop core patches because the resulting root
directory is not equivalent to a direct Git clone of the Drupal project.

Many times, to make Drupal contribution easier, it is simpler to do direct Git
checkouts of Drupal core and/or contributed projects. However, that approach has
many drawbacks. One must customize git ignore files, one cannot easily manage
a module's composer dependencies, and any patches required by a module that are
included in a `composer.json` file are not automatically applied. Thus, many
Drupal contributors choose not to use Composer for their day-to-day workflow.
This can often lead to bugs in `composer.json` and out-of-date `composer.json`
files.

This project is an attempt to make all that better. It does so by establishing
a Composer project that uses Git checkouts and symlinks to create a directory
structure that is conducive to Drupal contributions _and_ a composer-based
workflow.

The trade-off is a somewhat brittle installation that is likely not suitable for
"real", production Drupal applications.

## Usage

It's simple, replace the placeholder and run this single command:

```shell
composer create-project -s dev --repository='{"type":"vcs","url":"git@github.com:gabesullice/drupal-contributor-project.git"}' drupal/contributor-project {{ PROJECT_NAME }}
```

To develop a module that lives on Drupal.org, simply require it:

```shell
composer require drupal/cdn
```

_Note_: If your contrib module applies patches to Drupal core, you must run
`composer update` after requiring it.

The resulting directory structure will look like this:

```
composer.json
contrib
 ↳  modules
     ↳  cdn
         ↳  .git
  themes
  profiles
  libraries
web
 ↳  .git
    index.php
    sites
     ↳  default
         ↳  default.settings.php
            files
            # etc.
    modules
     ↳  contrib -> ../../contrib/modules     # symlink to the top-level contrib/modules directory.
    themes
     ↳  themes -> ../../contrib/themes       # symlink.
    profiles
     ↳  profiles -> ../../contrib/profiles   # symlink.
    libraries
     ↳  libraries -> ../../contrib/libraries # symlink.
    vendor -> ../vendor                      # symlink.
    # etc.
vendor
 ↳  bin
    autoload.php
    # etc.
```

## Tips & Tricks
You may already know about the `.gitigore` file to prevent Git from tracking
certain files and directories. Usually, that's great. However, if you have files
that you don't want to be tracked locally but you also do _not_ want to modify
the `.gitignore` file, you can add exlusions to a file named
`.git/info/exclude`.

This file behaves just like a `.gitignore` file at the root of your repository.

To ignore any changes to Drupal core caused by installing this project and
regular usage, try adding the following lines to a file located at
`web/.git/info/exclude`:

```
sites/default/files
sites/default/settings.php

modules/contrib
modules/custom

themes/contrib
themes/custom

profiles/contrib
profiles/custom

libraries/contrib
libraries/custom

vendor

PATCHES.txt
```

Built with 💙 by @TravisCarden & @GabeSullice at @Acquia.
