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
    'application/x-xml',
  );

  /**
   * Returns the name of the extension.
   *
   * @return string The extension name
   */
  public function getName() {
    throw new \RuntimeException();
    return 'apply_filter_twig_extension';
  }

  public function getFilters() {
    return array(
      new \Twig_SimpleFilter('isCoveable', array($this, 'isCoveable')),
    );
  }

  public function isCoveable($mimeType) {
    if (in_array($mimeType, $this->coveMimeTypes)) {
      return true;
    }

    // Should we now test for correct csv/xlsx format?
    return false;
  }

}
