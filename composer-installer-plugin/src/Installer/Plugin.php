<?php

namespace DrupalContribInstaller\Composer\Installer;

use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;

class Plugin extends LibraryInstaller {

  public function getInstallPath(PackageInterface $package) {
    $project_name = explode('/', $package->getName())[1];
    $this->io->write('\DrupalContribInstaller\Composer\Installer\Plugin::getInstallPath - ' . $project_name);
    return "contrib/modules/{$project_name}";
  }

  public function supports($package_type) {
    $this->io->write('\DrupalContribInstaller\Composer\Installer\Plugin::supports - ' . $package_type);
    throw new \Exception('Are you serious?!');
    return 'drupal-module' === $package_type;
  }

}
