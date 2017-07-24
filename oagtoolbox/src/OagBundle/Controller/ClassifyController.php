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
use PhpOffice\PhpWord\Shared\ZipArchive;

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
      return $classifier->getFixture();
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
      case 'application/pdf':
      case 'application/x-pdf':
      case 'application/acrobat':
      case 'applications/vnd.pdf':
      case 'text/pdf':
      case 'text/x-pdf':
        // pdf
        $decoder = new PDFExtractor();
        $decoder->setFilename($path);
        $decoder->decode();
        file_put_contents($sourceFile, $decoder->output());
        break;
      case 'text/plain':
      case 'application/txt':
      case 'browser/internal':
      case 'text/anytext':
      case 'widetext/plain':
      case 'widetext/paragraph':
        // txt
        $sourceFile = $path;
        break;
      case 'application/xml':
        // xml
        $sourceFile = $path;
        $isXml = true;
        break;
      case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
      case 'application/zip':
      case 'application/msword':
      case 'application/doc':
        // docx
        // phpword can't save to txt directly
        $tmpRtfFile = dirname($sourceFile) . '/' . basename($sourceFile, '.txt') . '.rtf';
        $phpWord = \PhpOffice\PhpWord\IOFactory::load($path, 'Word2007');
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'RTF');
        $objWriter->save($tmpRtfFile);
        // Now let the switch fall through to decode rtf
        $path = $tmpRtfFile;
      case 'text/rtf':
      case 'application/rtf':
      case 'application/x-rtf':
      case 'text/richtext':
        // rtf
        $decoder = new RTFExtractor();
        $decoder->setFilename($path);
        $decoder->decode();
        file_put_contents($sourceFile, $decoder->output());
        break;
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
