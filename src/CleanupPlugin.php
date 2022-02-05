<?php
namespace Janakdom\Composer;

use Composer\Composer;
use Composer\Config;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Package\CompletePackage;
use Composer\Plugin\PluginInterface;
use Composer\Repository\WritableRepositoryInterface;
use Composer\Script\Event;
use Composer\Util\Filesystem;
use Composer\Package\BasePackage;

class CleanupPlugin implements PluginInterface, EventSubscriberInterface
{
    /** @var  Composer $composer */
    protected $composer;
    /** @var  IOInterface $io */
    protected $io;
    /** @var  Config $config */
    protected $config;
    /** @var  Filesystem $filesystem */
    protected $filesystem;

    /**
     * {@inheritDoc}
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
        $this->config = $composer->getConfig();
        $this->filesystem = new Filesystem();
	}
	
	/**
     * {@inheritDoc}
     */
	public function deactivate(Composer $composer, IOInterface $io)
	{
		//
	}

	/**
     * {@inheritDoc}
     */
	public function uninstall(Composer $composer, IOInterface $io)
	{
		//
	}

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return [
		    'post-install-cmd'	=> 'onPostInstallCmd',
		    'post-update-cmd'	=> 'onPostUpdateCmd'
        ];
    }

    public function onPostInstallCmd(Event $event)
    {
        $this->onVendorClear($event);
    }

    public function onPostUpdateCmd(Event $event)
    {
        $this->onVendorClear($event);
    }

    private function onVendorClear(Event $event) {
        $this->io->write('Clean vendor on \''.$event->getName().'\'');

        /** @var WritableRepositoryInterface $repository */
        $repository = $this->composer->getRepositoryManager()->getLocalRepository();

        /** @var CompletePackage $package */
        foreach($repository->getPackages() as $package){
            if ($package instanceof BasePackage) {
                $this->cleanPackage($package);
            }
        }
    }

    /**
     * Clean a package, based on its rules.
     *
     * @param BasePackage  $package  The package to clean
     * @return bool True if cleaned
     */
    protected function cleanPackage(BasePackage $package)
    {
        // Only clean 'dist' packages
        if ($package->getInstallationSource() !== 'dist') {
            $this->io->warning('Cannot clear package \''.$package->getName().'\', it is not dist.');
            return false;
        }

        $vendorDir = $this->config->get('vendor-dir');
        $targetDir = $package->getTargetDir();
        $packageName = $package->getPrettyName();
        $packageDir = $targetDir ? $packageName . '/' . $targetDir : $packageName ;

        $rules = CleanupRules::getRules($packageName);
        if(!$rules){
            $this->io->warning('Cannot clear package \''.$package->getName().'\'');
            return false;
        }

        $dir = $this->filesystem->normalizePath(realpath($vendorDir . '/' . $packageDir));
        if (!is_dir($dir)) {
            return false;
        }

        foreach((array)$rules as $part) {
            // Split patterns for single globs (should be max 260 chars)
            $patterns = explode(' ', trim($part));
            
            foreach ($patterns as $pattern) {
                try {
                    foreach (glob($dir.'/'.$pattern) as $file) {
                        $this->filesystem->remove($file);
                    }
                } catch (\Exception $e) {
                    $this->io->error("Could not parse $packageDir ($pattern): ".$e->getMessage());
                }
            }
        }

        return true;
    }
}
