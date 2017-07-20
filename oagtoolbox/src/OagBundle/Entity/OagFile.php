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
     * @ORM\Column(name="path", type="string", length=1024, unique=true)
     */
    private $path;


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
    public function setDocuemntName($path) {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getDocumentName() {
        return $this->path;
    }

  public function XMLFileName() {
    $filename = $this->getPath();
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if ($ext != 'xml') {
      $filename = $filename . '.xml';
    }
    return $filename;
  }

}

