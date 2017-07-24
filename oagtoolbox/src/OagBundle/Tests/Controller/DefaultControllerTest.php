<?php

namespace OagBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\Common\Persistence\ObjectManager;
use OagBundle\Entity\OagFile;

/**
 * ./vendor/bin/simple-phpunit -c phpunit.xml --coverage-html web/test-coverage
 */
class DefaultControllerTest extends WebTestCase {

  /**
   * @var \Doctrine\ORM\EntityManager
   */
  private $em;

  /**
   * @var \Doctrine\Common\Persistence\ObjectManager
   */
  private $objectManager;

  /**
   * {@inheritDoc}
   */
  protected function setUp() {
    self::bootKernel();

    $this->em = static::$kernel->getContainer()
      ->get('doctrine')
      ->getManager();

    $docs = array();
    $docs[] = $this->createOagFile(1, 'animalfarm.pdf', 'application/pdf');
    $docs[] = $this->createOagFile(2, 'animalfarm.rtf', 'text/rtf');
    $docs[] = $this->createOagFile(3, 'animalfarm.txt', 'text/plain');
    $docs[] = $this->createOagFile(4, 'basic_iati_unordered_valid.xlsx', 'application/octet-stream');
    $docs[] = $this->createOagFile(5, 'after_enrichment_activities.xml', 'text/xml');

    $documentRepository = $this->createMock(ObjectRepository::class);
    // use getMock() on PHPUnit 5.3 or below
    // $employeeRepository = $this->getMock(ObjectRepository::class);
    $documentRepository->expects($this->any())
      ->method('findAll')
      ->willReturn($docs);

    // Last, mock the EntityManager to return the mock of the repository
    $this->objectManager = $this->createMock(ObjectManager::class);
    // use getMock() on PHPUnit 5.3 or below
    // $objectManager = $this->getMock(ObjectManager::class);
    $this->objectManager->expects($this->any())
      ->method('getRepository')
      ->willReturn($documentRepository);
  }

  public function testIndex() {
    $client = static::createClient();

    $crawler = $client->request('GET', '/');
    $this->assertCount(1, $crawler->filter('h1'));
    $this->assertCount(1, $crawler->filter('.upload-link'), 'Check upload link exists.');
    $this->assertCount(1, $crawler->filter('.home-link', 'Check Home link exists.'));
    $this->assertEquals('Open Ag Toolbox', $crawler->filter('h1')->text());
    $this->assertCount(1, $crawler->filter('table.document-table'), 'Check documen table exists.');
  }

  public function testConfirmDelete() {
    $repository = $this->objectManager->getRepository(OagFile::class);
    $ids = array();
    $oagfiles = $repository->findAll();
    foreach ($oagfiles as $oagfile) {
      $ids[] = $oagfile->getId();
    }
    $params = array(
      'delete_list' => implode('+', array_keys($ids)),
    );

    $client = static::createClient();
    $crawler = $client->request(
      'POST', '/confirm_delete', $params, array(), array('CONTENT_TYPE' => 'application/json')
    );
  }

  public function testDelete() {
    // We can clean the DB totally here.
    $ids = [];
    $oagfiles = $this->em->getRepository(OagFile::class)->findAll();
    foreach ($oagfiles as $oagfile) {
      $ids[] = $oagfile->getId();
    }

    $client = static::createClient();

    $crawler = $client->request('GET', '/delete/' . implode('+', $ids));
  }

  public function testUpload() {
    $client = static::createClient();
    $crawler = $client->request('GET', '/upload');

    // Upload.
    $buttonCrawlerNode = $crawler->selectButton('Upload');
    // print_r($buttonCrawlerNode);

    $file = $client->getContainer()->getParameter('oag_test_assets_directory') . '/after_enrichment_activities.xml';
    $document = new UploadedFile($file, basename($file), 'text/html');

    $form = $buttonCrawlerNode->form(array(
      'oag_file[documentName]' => $document,
    ));
    $client->submit($form);

    $filename = $client->getContainer()->getParameter('oagfiles_directory') . '/' . basename($file);
    $this->assertFileExists($filename, 'Uploaded file not on the file system.');

    $oagfile = $this->em->getRepository(OagFile::class)->findOneBy(
      array('documentName' => basename($file))
    );
    $this->assertNotNull($oagfile, 'Uploaded file not found in DB');
  }

  private function createOagFile($id, $name, $mimetype) {
    $entityMock = $this->createMock(OagFile::class, array('getId'));
    $entityMock->expects($this->any())
      ->method('getId')
      ->will($this->returnValue($id));
    $entityMock->setDocumentName($name);
    $entityMock->setMimeType($mimetype);

    return $entityMock;
//    $doc = new OagFile();
//    $doc->setId($id);
//    $doc->setDocumentName($name);
//    $doc->setMimeType($mimetype);
//    return $doc;
  }

}
