<?php

namespace OagBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractAutoService extends AbstractOagService {

  abstract function processUri($sometext);

  abstract function processString($sometext);
}
