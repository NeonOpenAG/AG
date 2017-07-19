<?php

namespace OagBundle\Service\TextExtractor;

class RTFExtractor extends AbstractExtractor {

  public function decode() {
    $this->output = preg_replace('"{\*?\\\\.+(;})|\\s?\\\[A-Za-z0-9]+|\\s?{\\s?\\\[A-Za-z0-9‹]+\\s?|\\s?}\\s?"', '', file_get_contents($this->path));
  }

}
