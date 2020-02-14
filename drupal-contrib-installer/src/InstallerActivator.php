<?php

namespace DrupalContribInstaller\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class InstallerActivator implements PluginInterface {

  public function activate(Composer $composer, IOInterface $io) {
    $composer->getInstallationManager()->addInstaller(new CoreInstaller($io, $composer));
    $composer->getInstallationManager()->addInstaller(new Installer($io, $composer));
  }

}
