<?php

// src/OagBundle/Service/Geocoder.php

namespace OagBundle\Service;

use OagBundle\Service\OagServiceInterface;

class Geocoder implements OagServiceInterface {

  public function autocodeXml($sometext) {
    return $this->autocodeText();
  }

  public function autocodeText($sometext) {
    $json = array(
      0 =>
      array(
        'project_id' => 'P-TD-KF0-005',
        'title' => '',
        'locations' =>
        array(
          0 =>
          array(
            'name' => 'Salamat',
            'id' => 242048,
            'geometry' =>
            array(
              'type' => 'Point',
              'coordinates' =>
              array(
                0 => '20.5',
                1 => '11',
              ),
            ),
            'featureDesignation' =>
            array(
              'code' => 'ADM1',
              'name' => 'first-order administrative division',
            ),
            'type' => 'geocoding',
            'activityDescription' => 'Maize ',
            'locationClass' =>
            array(
              'code' => '1',
              'name' => 'Administrative Region',
              'language' => 'en',
              'description' => 'The designated geographic location is an administrative region (state, county, province, district, municipality etc.)',
            ),
            'exactness' =>
            array(
              'code' => '1',
              'name' => 'Exact',
              'language' => 'en',
              'description' => 'The designated geographic location is exact',
            ),
            'country' =>
            array(
              'code' => 216,
              'name' => 'Chad',
            ),
            'admin1' =>
            array(
              'code' => 2812,
              'name' => 'Salamat',
            ),
            'admin2' =>
            array(
              'code' => 32286,
              'name' => 'Barh Azoum',
            ),
            'rollbackData' =>
            array(
              'name' => 'Salamat',
              'id' => 242048,
              'geometry' =>
              array(
                'type' => 'Point',
                'coordinates' =>
                array(
                  0 => '20.5',
                  1 => '11',
                ),
              ),
              'featureDesignation' =>
              array(
                'code' => 'ADM1',
                'name' => 'first-order administrative division',
              ),
              'type' => 'geocoding',
              'activityDescription' => 'Maize ',
              'locationClass' =>
              array(
                'code' => '1',
                'name' => 'Administrative Region',
                'language' => 'en',
                'description' => 'The designated geographic location is an administrative region (state, county, province, district, municipality etc.)',
              ),
              'exactness' =>
              array(
                'code' => '1',
                'name' => 'Exact',
                'language' => 'en',
                'description' => 'The designated geographic location is exact',
              ),
              'country' =>
              array(
                'code' => 216,
                'name' => 'Chad',
              ),
              'admin1' =>
              array(
                'code' => 2812,
                'name' => 'Salamat',
              ),
              'admin2' =>
              array(
                'code' => 32286,
                'name' => 'Barh Azoum',
              ),
              'rollbackData' =>
              array(
                'name' => 'Salamat',
                'id' => 242048,
                'geometry' =>
                array(
                  'type' => 'Point',
                  'coordinates' =>
                  array(
                    0 => '20.5',
                    1 => '11',
                  ),
                ),
                'featureDesignation' =>
                array(
                  'code' => 'ADM1',
                  'name' => 'first-order administrative division',
                ),
                'type' => 'geocoding',
                'activityDescription' => 'Maize ',
                'locationClass' =>
                array(
                  'code' => '1',
                  'name' => 'Administrative Region',
                  'language' => 'en',
                  'description' => 'The designated geographic location is an administrative region (state, county, province, district, municipality etc.)',
                ),
                'exactness' =>
                array(
                  'code' => '1',
                  'name' => 'Exact',
                  'language' => 'en',
                  'description' => 'The designated geographic location is exact',
                ),
                'country' =>
                array(
                  'code' => 216,
                  'name' => 'Chad',
                ),
                'admin1' =>
                array(
                  'code' => 2812,
                  'name' => 'Salamat',
                ),
                'admin2' =>
                array(
                  'code' => 32286,
                  'name' => 'Barh Azoum',
                ),
                'rollbackData' => NULL,
              ),
            ),
          ),
          1 =>
          array(
            'name' => 'Massakory',
            'id' => 2428228,
            'geometry' =>
            array(
              'type' => 'Point',
              'coordinates' =>
              array(
                0 => '15.72927',
                1 => '12.996',
              ),
            ),
            'featureDesignation' =>
            array(
              'code' => 'PPLA',
              'name' => 'seat of a first-order administrative division',
            ),
            'type' => 'geocoding',
            'activityDescription' => 'Building school',
            'locationClass' =>
            array(
              'code' => '2',
              'name' => 'Populated Place',
              'language' => 'en',
              'description' => 'The designated geographic location is a populated place (town, village, farm etc.)',
            ),
            'exactness' =>
            array(
              'code' => '2',
              'name' => 'Approximate',
              'language' => 'en',
              'description' => 'The designated geographic location is approximate',
            ),
            'country' =>
            array(
              'code' => 216,
              'name' => 'Chad',
            ),
            'admin1' =>
            array(
              'code' => 2802,
              'name' => 'Hadjer-Lamis',
            ),
            'admin2' =>
            array(
              'code' => 32256,
              'name' => 'Dagana',
            ),
          ),
        ),
      ),
    );

    return $json;
  }

}
