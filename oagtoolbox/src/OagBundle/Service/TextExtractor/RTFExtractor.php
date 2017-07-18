<?php

namespace OagBundle\Service\TextExtractor;

class RTFExtractor {

  protected $path;
  protected $output;

  public function setFilename($path) {
    $this->path = $path;
  }

  public function decode() {
    $this->output = preg_replace('"{\*?\\\\.+(;})|\\s?\\\[A-Za-z0-9]+|\\s?{\\s?\\\[A-Za-z0-9‹]+\\s?|\\s?}\\s?"', '', file_get_contents($this->path));
  }

  public function output() {
    return $this->output;
  }

}
