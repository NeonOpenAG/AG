<?php

namespace OagBundle\Service\TextExtractor;

use Asika\Pdf2text;

class PDFExtractor extends AbstractExtractor {

  function __construct() {
    $installed = exec('which pdf2txt');
  }

  public function decode() {
    $reader = new Pdf2text();
    $this->output = $reader->decode($this->path);
  }

}
