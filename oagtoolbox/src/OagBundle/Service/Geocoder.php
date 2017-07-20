<?php

namespace OagBundle\Service;

class Geocoder extends AbstractAutoService {

  public function processUri($sometext) {
    return $this->processString();
  }

  public function processString($sometext) {
    $uri = $this->getUri();

    $json = array(
      array(
        'project_id' => 'P-TD-KF0-005',
        'title' => '',
        'locations' => array(
          array(
            'name' => 'Salamat',
            'id' => 242048,
            'geometry' => array(
              'type' => 'Point',
              'coordinates' => array(
                '20.5', '11'
              )
            ),
            'featureDesignation' => array(
              'code' => 'ADM1',
              'name' => 'first-order administrative division'
            ),
            'type' => 'geocoding',
            'activityDescription' => 'Maize',
            'locationClass' => array(
              'code' => '1',
              'name' => 'Administrative Region',
              'language' => 'en',
              'description' => 'The designated geographic location is an administrative region'
            ),
            'exactness' => array(
              'code' => '1',
              'name' => 'Exact',
              'language' => 'en',
              'description' => 'The designated geographic location is exact'
            ),
            'country' => array(
              'code' => 216,
              'name' => 'Chad'
            ),
            'admin1' => array(
              'code' => 2812,
              'name' => 'Salamat'
            ),
            'admin2' => array(
              'code' => 32286,
              'name' => 'Barh Azoum'
            )
          )
        )
      )
    );

    return $json;
  }

  public function getName() {
    return 'geocoder';
  }

}
