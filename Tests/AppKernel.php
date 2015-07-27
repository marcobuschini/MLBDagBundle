<?php
namespace MLB\DagBundle\Tests;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
  public function registerBundles()
  {
    $bundles = array(
      new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
      new \Symfony\Bundle\SecurityBundle\SecurityBundle(),
      new \Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
      new \Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
      new \MLB\DagBundle\MLBDagBundle(),
    );

    return $bundles;
  }

  public function registerContainerConfiguration(LoaderInterface $locader)
  {
    $loader->load(__DIR__.'/config/config.yml');
  }
}
