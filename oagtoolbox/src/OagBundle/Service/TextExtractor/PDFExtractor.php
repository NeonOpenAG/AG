<?php

namespace OagBundle\Service\TextExtractor;

class PDFExtractor extends PDF2Text {

  public function decode() {
    $this->decodePDF();
  }

}
