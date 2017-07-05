<?php
// src/OagBundle/Service/Geocoder.php
namespace OagBundle\Service;

use OagBundle\Service\OagServiceInterface;

class Cove implements OagServiceInterface {

  public function autocodeXml($sometext) {
    return $this->autocodeText();
  }

  public function autocodeText($sometext) {

    $json = array(
      'xml' => '/path/to/file',
      'errors' => array(
        'err1',
        'err2',
        'err3',
        'err4',
      ),
    );

    return $json;
  }

}
