<?php

namespace OagBundle\Twig;

class OagExtension extends \Twig_Extension {

  protected $coveMimeTypes = array(
    'text/comma-separated-values',
    'text/csv',
    'application/csv',
    'application/excel',
    'application/vnd.ms-excel',
    'application/vnd.msexcel',
    'text/anytext',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'text/xml',
    'application/xml',
    'application/octet-stream',
    'text/html',
    'text/plain',
  );
  protected $classifierMimeTypes = array(
    'application/pdf',
    'application/x-pdf',
    'application/acrobat',
    'applications/vnd.pdf',
    'text/pdf',
    'text/x-pdf',
    'application/rtf',
    'application/x-rtf',
    'text/rtf',
    'text/richtext',
    'application/msword',
    'application/doc',
    'application/x-soffice',
    'text/plain',
    'application/txt',
    'browser/internal',
    'text/anytext',
    'widetext/plain',
    'widetext/paragraph',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'application/zip',
  );

  public function getFilters() {
    return array(
      new \Twig_SimpleFilter('isCoveable', array($this, 'isCoveable')),
      new \Twig_SimpleFilter('isClassifiable', array($this, 'isClassifiable')),
    );
  }

  public function isCoveable($mimeType) {
    if (in_array($mimeType, $this->coveMimeTypes)) {
      return true;
    }

    // Should we test file extension?
    // Should we now test for correct csv/xlsx format?
    return false;
  }

  public function isClassifiable($mimeType) {
    if (in_array($mimeType, $this->classifierMimeTypes)) {
      return true;
    }

    // Should we test file extension?
    // Should we now test for correct csv/xlsx format?
    return false;
  }

}
