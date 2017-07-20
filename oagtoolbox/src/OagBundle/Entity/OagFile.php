<?php

namespace OagBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OagFile
 *
 * @ORM\Table(name="oag_file")
 * @ORM\Entity(repositoryClass="OagBundle\Repository\OagFileRepository")
 */
class OagFile
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
   * @var string
   *
   * @ORM\Column(name="documentName", type="string", length=1024, unique=true)
   */
  private $documentName;

  /**
   * @var string
   *
   * @ORM\Column(name="mimeType", type="string", length=1024)
   */
  private $mimeType;

  /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
   * Set path
   *
   * @param string $path
   *
   * @return OagFile
   */
  public function setDocumentName($documentName) {
    $this->documentName = $documentName;

    return $this;
  }

  /**
   * Get path
   *
   * @return string
   */
  public function getDocumentName() {
    return $this->documentName;
  }

  /**
   * Set path
   *
   * @param string $path
   *
   * @return OagFile
   */
  public function setMimeType($mimeType) {
    $this->mimeType = $mimeType;

    return $this;
  }

  /**
   * Get path
   *
   * @return string
   */
  public function getMimeType() {
    return $this->mimeType;
  }

  public function XMLFileName() {
    $filename = $this->getDocumentName();
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if ($ext != 'xml') {
      $filename = $filename . '.xml';
    }
    return $filename;
  }

}

