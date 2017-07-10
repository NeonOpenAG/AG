<?php
// src/OagBundle/Service/Geocoder.php
namespace OagBundle\Service;


class Cove extends OagAbstractService {

  public function autocodeUri($sometext) {
    return $this->autocodeText();
  }

  public function autocodeXml($sometext) {
    return $this->autocodeText();
  }

  public function autocodeText($sometext) {
    $uri = $this->getUri();

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

  public function getName() {
    return 'cove';
  }

}
