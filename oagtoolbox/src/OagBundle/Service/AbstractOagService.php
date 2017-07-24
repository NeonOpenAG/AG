<?php

namespace OagBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractOagService extends AbstractService {

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

  abstract function getName();
}
