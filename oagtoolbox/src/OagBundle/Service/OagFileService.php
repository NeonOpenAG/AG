<?php

namespace OagBundle\Service;

class OagFileService extends AbstractService {

  public function getXMLFileName($oagFile) {
    $filename = $oagFile->getDocumentName();
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if ($ext != 'xml') {
      $filename .= '.xml';
    }
    return $filename;
  }

}
