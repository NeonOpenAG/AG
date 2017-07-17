<?php

namespace OagBundle\Service;

class Classifier extends OagAbstractService {

  public function processUri($sometext) {
    return $this->processString();
  }

  public function isAvailable() {
    $uri = $this->getUri();

    $request = curl_init();
    curl_setopt($request, CURLOPT_URL, $uri);
    curl_setopt($request, CURLOPT_GET);
    curl_exec($request);

    $responseCode = curl_getinfo($request, CURLINFO_HTTP_CODE);
    curl_close($request);
    return ($responseCode >= 200 && $responseCode <= 209);
  }

  public function getFixtureData() {
    $fixture = array(
      'success' => true,
      'duration' => 4.584875984758,
      'data' => array(
        array(
          'XM-DAC-1234-Project1' => array(
            'code' => 'c_541',
            'confidence' => 0.98738467746633,
            'decription' => 'apples'
          )
        )
      )
    );
    return $fixture;
  }

  public function processString($contents) {
    if (!$this->isAvailable()) {
      return $this->getFixtureData();
    }

    $uri = $this->getUri();
    $request = curl_init();
    curl_setopt($request, CURLOPT_URL, $uri);
    curl_setopt($request, CURLOPT_POST);

    $payload = http_build_query(array(
      'data' => $contents
    ));

    curl_setopt($request, CURLOPT_POSTFIELDS, $payload);

    $data = curl_exec($request);
    $responseCode = curl_getinfo($request, CURLINFO_HTTP_CODE);
    curl_close($request);

    $response = array(
      'status' => ($responseCode >= 200 && $responseCode <= 209) ? 0 : 1,
      'data' => $data
    );

    return $response;
  }

  public function getName() {
    return 'classifier';
  }
}
