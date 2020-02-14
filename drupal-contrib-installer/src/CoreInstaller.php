<?php

namespace DrupalContribInstaller\Composer;

use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;

class CoreInstaller extends LibraryInstaller {

  public function getInstallPath(PackageInterface $package) {
    if (!in_array($package->getPrettyName(), ['drupal/core', 'drupal/drupal'], TRUE)) {
      return parent::getInstallPath($package);
    }
    return $package->getPrettyName() === 'drupal/core'
      ? 'web/core'
      : 'web';
  }

  public function supports($package_type) {
    return in_array($package_type, ['project', 'drupal-core'], TRUE);
  }

}
