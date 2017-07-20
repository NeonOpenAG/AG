<?php

namespace OagBundle\Service;

use OagBundle\Service\TextExtractor\ApplicationOctetStream;
use OagBundle\Service\TextExtractor\ApplicationPdf;
use OagBundle\Service\TextExtractor\ApplicationXml;
use OagBundle\Service\TextExtractor\TextPlain;

class Classifier extends AbstractOagService {

  public function processUri($sometext) {
    return $this->processString();
  }

  public function isAvailable() {
    $uri = $this->getUri();
//
//    $request = curl_init();
//    curl_setopt($request, CURLOPT_URL, $uri);
//    curl_exec($request);
//
//    $responseCode = curl_getinfo($request, CURLINFO_HTTP_CODE);
//    curl_close($request);
//    return ($responseCode >= 200 && $responseCode <= 209);
//
    // The classifier is VERY slow to respond, use a port check instead.
    // TODO Does this work with https
    $parts = parse_url($uri);
    $host = $parts['host'];
    $port = 80;
    if (isset($parts['port'])) {
      $port = $parts['port'];
    }
    elseif (isset($parts['scheme']) && $parts['scheme'] == 'https') {
      $port = 443;
    }
    $connection = @fsockopen($host, $port);
    return is_resource($connection);
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
    curl_setopt($request, CURLOPT_POST, true);
    curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
//    curl_setopt($request, CURLOPT_VERBOSE, true);
//    curl_setopt($request, CURLOPT_HEADER, true);

    $payload = array(
      'text1' => $contents,
      'limit' => 0,
      'anchor' => 0,
      'ext' => 'fc',
      'threshold' => 'low',
      'rollup' => 'true',
      'chunk' => 'True',
    );

    curl_setopt($request, CURLOPT_POSTFIELDS, http_build_query($payload));

    $data = curl_exec($request);
    $responseCode = curl_getinfo($request, CURLINFO_HTTP_CODE);
    curl_close($request);

    $response = array(
      'status' => ($responseCode >= 200 && $responseCode <= 209)?0:1,
    );

    return array_merge($response, json_decode($data, true));
  }

  public function getName() {
    return 'classifier';
  }
}
