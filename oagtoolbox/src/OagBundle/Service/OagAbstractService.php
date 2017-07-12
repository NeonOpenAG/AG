<?php

namespace OagBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class OagAbstractService {

  private $container;

  /**
   * Sets the container.
   *
   * @param ContainerInterface|null $container A ContainerInterface instance or null
   */
  public function setContainer(ContainerInterface $container = null) {
    $this->container = $container;
  }

  public function getContainer() {
    return $this->container;
  }

  public function getUri() {
    $oag = $this->getContainer()->getParameter('oag');

    $name = $this->getName();
    $uri = $oag[$name]['uri'];

    return $uri;
  }

  public function isAvailable() {
    $name = $this->getName();
    $cmd = sprintf('docker images openagdata/%s |wc -l', $name);
    $output = array();
    $retval = 0;
    $linecount = exec($cmd, $output, $retval);

    if ($retval == 0 && $linecount > 1) {
      $this->getContainer()->get('logger')->debug(
        sprintf('Docker %s is available', $name)
      );
      return true;
    }
    else {
      $this->getContainer()->get('logger')->info(
        sprintf(
          'Failed to stat docker %s: %s', $name, json_encode($output)
        )
      );
      return false;
    }
  }

  abstract function processUri($sometext);

  abstract function processString($sometext);

  abstract function getName();
}
