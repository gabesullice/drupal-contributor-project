<?php

namespace DrupalContribInstaller\Composer;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\ScriptEvents;
use Composer\Util\Filesystem;

class InstallerActivator implements PluginInterface, EventSubscriberInterface {

  public function activate(Composer $composer, IOInterface $io) {
    $composer->getInstallationManager()->addInstaller(new CoreInstaller($io, $composer));
    $composer->getInstallationManager()->addInstaller(new ExtensionInstaller($io, $composer));
  }

  public static function getSubscribedEvents() {
    return [ScriptEvents::POST_UPDATE_CMD => ['ensureSymlinks']];
  }

  public function ensureSymlinks() {
    //"drush/Commands/contrib/{$name}": ["type:drupal-drush"],
    foreach (['contrib', 'custom'] as $extension_category) {
      $directories = array_map(function ($directory_mapping) {
        return array_map('realpath', $directory_mapping);
      }, [
        'modules' => ["{$extension_category}/modules", 'web/modules'],
        'profiles' => ["{$extension_category}/profiles", 'web/modules'],
        'themes' => ["{$extension_category}/themes", 'web/modules'],
        'libraries' => ["{$extension_category}/libraries", 'web/libraries'],
        'drush' => ["{$extension_category}/drush", 'web/drush'],
      ]);
      foreach ($directories as $extension_type => $directory_mapping) {
        list($target_directory, $source_directory) = $directory_mapping;
        $source_path = $source_directory;
        if ($extension_type !== 'drush') {
          $source_path .= "/{$extension_category}";
        }
        $this->ensureSymlink($target_directory, $source_path);
      }
    }
  }

  protected function ensureSymlink($target, $source) {
    $filesystem = new Filesystem();
    if (!file_exists($source) && file_exists($target)) {
      $filesystem->relativeSymlink($target, $source);
    }
  }

}
