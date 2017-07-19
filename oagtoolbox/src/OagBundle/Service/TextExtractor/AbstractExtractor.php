<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OagBundle\Service\TextExtractor;

/**
 * Description of AbstractExtractor
 *
 * @author tobias
 */
abstract class AbstractExtractor {

  protected $path;
  protected $output;

  public function setFilename($path) {
    $this->path = $path;
  }

  abstract function decode();

  public function output() {
    return $this->output;
  }

}
