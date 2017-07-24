<?php
// src/OagBundle/Service/Geocoder.php
namespace OagBundle\Service;


class Cove extends AbstractAutoService {

  public function isAvailable() {
    $name = $this->getName();
    $cmd = sprintf('docker images openagdata/%s |wc -l', $name);
    $output = array();
    $retval = 0;
    $linecount = exec($cmd, $output, $retval);

    if ($retval == 0 && $linecount > 1) {
      $this->getContainer()->get('logger')->debug(
        sprintf('Docker %s is available', $name)
      );
      return true;
    }
    else {
      $this->getContainer()->get('logger')->info(
        sprintf(
          'Failed to stat docker %s: %s', $name, json_encode($output)
        )
      );
      return false;
    }
  }

  public function processUri($uri) {
    // TODO - fetch file, cache it, check content type, decode and then pass to cove line at a time
    $data = file_get_contents($uri);
    return $this->autocodeXml($data);
  }

  public function processString($text) {
    if (!$this->isAvailable()) {
      return $this->getFixtureData();
    }

    $descriptorspec = array(
      0 => array("pipe", "r"),
      1 => array("pipe", "w"),
      2 => array("pipe", "w"),
    );
    $cmd = "docker run -i -e PROCESS_DATA=true openagdata/cove";
    $this->getContainer()->get('logger')->debug(
      sprintf('Command: %s', $cmd)
    );

    $process = proc_open($cmd, $descriptorspec, $pipes);

    if (is_resource($process)) {
      fwrite($pipes[0], $text);
      fclose($pipes[0]);

      $xml = stream_get_contents($pipes[1]);
      fclose($pipes[1]);

      $err = stream_get_contents($pipes[2]);
      fclose($pipes[2]);

      $return_value = proc_close($process);

      $data = array(
        'xml' => $xml,
        'err' => explode("\n", $err),
        'status' => $return_value,
      );

      return $data;
    }
    else {
      // TODO Better exception handling.
      throw new \RuntimeException('CoVE Failed to start');
    }
  }

  private function getFixtureData() {
    // TODO - load from file, can we make this an asset?
    // https://symfony.com/doc/current/best_practices/web-assets.html
    $json = array(
      'xml' => '',
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
