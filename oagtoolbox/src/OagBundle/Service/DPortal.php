<?php
// src/OagBundle/Service/Geocoder.php
namespace OagBundle\Service;


class DPortal extends AbstractAutoService {

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

  public function visualise($fileid) {
    $repository = $this->getDoctrine()->getRepository(OagFile::class);
    $oagfile = $repository->find($fileid);

    if (!$oagfile) {
      // TODO throw 404
      throw new RuntimeException('OAG file not found: ' . $fileid);
    }

    $xmldir = $this->getParameter('oagxml_directory');
    if (!is_dir($xmldir)) {
      mkdir($xmldir, 0755, true);
    }
    $xmlfile = $xmldir . '/' . $oagfile->XMLFileName();

    exec("openag start dportal");
    exec("openag reset dportal");
    exec("openag import dportal " . $xmlfile);
  }

  public function getName() {
    return 'dportal';
  }

}
