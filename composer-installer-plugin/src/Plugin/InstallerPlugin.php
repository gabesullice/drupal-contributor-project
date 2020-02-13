<?php

namespace DrupalContribInstaller\Composer\Plugin;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use DrupalContribInstaller\Composer\Installer\Plugin;

class InstallerPlugin implements PluginInterface {

  public function activate(Composer $composer, IOInterface $io) {
    $io->write('\DrupalContribInstaller\Composer\Plugin\InstallerPlugin::activate');
    throw new \Exception('Asplode!!!');
    $installer = new Plugin($io, $composer);
    $composer->getInstallationManager()->addInstaller($installer);
  }

}
