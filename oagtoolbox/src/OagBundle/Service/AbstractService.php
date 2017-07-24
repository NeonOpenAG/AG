<?php

namespace OagBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractService {

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

}
