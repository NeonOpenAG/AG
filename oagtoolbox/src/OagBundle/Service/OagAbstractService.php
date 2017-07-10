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

  abstract function autocodeUri($sometext);

  abstract function autocodeXml($sometext);

  abstract function autocodeText($sometext);

  abstract function getName();
}
