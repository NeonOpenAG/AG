<?php

namespace OagBundle\Tests\Controller;

use Doctrine\ORM\EntityManager;
use OagBundle\Entity\OagFile;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ClassifyControllerTest extends WebTestCase {

  /**
   * @var EntityManager
   */
  private $em;

  public function setUp() {
    self::bootKernel();

    $this->em = static::$kernel->getContainer()
      ->get('doctrine')
      ->getManager();

    // Upload a file
    $client = static::createClient();
    $crawler = $client->request('GET', '/upload');

    // Upload.
    $buttonCrawlerNode = $crawler->selectButton('Upload');
    // print_r($buttonCrawlerNode);

    $files = glob($client->getContainer()->getParameter('oag_test_assets_directory') . '/*');
    foreach ($files as $file) {
      $mimetype = mime_content_type($file);
      $document = new UploadedFile($file, basename($file), $mimetype);

      $form = $buttonCrawlerNode->form(array(
        'oag_file[documentName]' => $document,
      ));
      $client->submit($form);
    }
  }

  public function testIndex() {
    $client = static::createClient();

    $files = glob($client->getContainer()->getParameter('oag_test_assets_directory') . '/*');
    foreach ($files as $file) {
      $oagfile = $this->em->getRepository(OagFile::class)->findOneBy(array('documentName' => basename($file)));
      $crawler = $client->request('GET', '/classify/' . $oagfile->getId());
    }
  }

}
