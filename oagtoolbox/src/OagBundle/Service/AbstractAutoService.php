<?php

namespace OagBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractAutoService {

  abstract function processUri($sometext);

  abstract function processString($sometext);

  abstract function getName();
}
