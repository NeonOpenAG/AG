<?php

namespace OagBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use OagBundle\Service\Classifier;
use Symfony\Component\HttpFoundation\Request;
use OagBundle\Entity\OagFile;
use OagBundle\Form\OagFileType;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use OagBundle\Service\TextExtractor\PDFExtractor;
use OagBundle\Service\TextExtractor\RTFExtractor;

/**
 * @Route("/classify")
 * @Template
 */
class ClassifyController extends Controller {

  /**
   * @Route("/{fileid}", requirements={"fileid": "\d+"})
   * @Template
   */
  public function indexAction($fileid) {
    $messages = [];
    $classifier = $this->get(Classifier::class);

    $avaiable = false;
    if ($classifier->isAvailable()) {
      $messages[] = 'Classifier is avaialable';
    }
    else {
      $messages[] = 'Classifier is down, returning fixture data.';
      // TODO Ant Fixture data please
    }

    $repository = $this->getDoctrine()->getRepository(OagFile::class);
    $oagfile = $repository->find($fileid);
    if (!$oagfile) {
      // TODO throw 404
      throw new \RuntimeException('OAG file not found: ' . $fileid);
    }
    // TODO - for bigger files we might need send as Uri
    $path = $this->getParameter('oagfiles_directory') . '/' . $oagfile->getDocumentName();
    $mimetype = mime_content_type($path);
    $messages[] = sprintf('File %s detected as %s', $path, $mimetype);

    $isXml = false;
    $sourceFile = tempnam(sys_get_temp_dir(), 'oag') . '.txt';
    switch ($mimetype) {
      case 'application/pdf':
        // pdf
        $decoder = new PDFExtractor();
        $decoder->setFilename($path);
        $decoder->decode();
        file_put_contents($sourceFile, $decoder->output());
        break;
      case 'text/plain':
        // txt
        $sourceFile = $path;
        break;
      case 'application/xml':
        // xml
        $sourceFile = $path;
        $isXml = true;
        break;
      case 'text/rtf':
        // rtf
        $decoder = new RTFExtractor();
        $decoder->setFilename($path);
        $decoder->decode();
        file_put_contents($sourceFile, $decoder->output());
    }
    $this->container->get('logger')->info(sprintf('Processing file %s', $sourceFile));

    $contents = file_get_contents($sourceFile);
    if ($isXml) {
      // hit the XML endpoint...
    }
    $json = $classifier->processString($contents);

    return array(
      'messages' => $messages,
      'response' => $json,
    );
  }

}
