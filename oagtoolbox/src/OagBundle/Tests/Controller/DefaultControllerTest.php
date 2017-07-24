<?php

namespace OagBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DefaultControllerTest extends WebTestCase {

  public function testIndex() {
    $client = static::createClient();

    // Index.
    $crawler = $client->request('GET', '/');
    $this->assertCount(1, $crawler->filter('h1'));
    $this->assertCount(1, $crawler->filter('.upload-link'), 'Check upload link exists.');
    $this->assertCount(1, $crawler->filter('.home-link', 'Check Home link exists.'));
    $this->assertEquals('Open Ag Toolbox', $crawler->filter('h1')->text());
    $this->assertCount(1, $crawler->filter('table.document-table'), 'Check documen table exists.');

    // Upload.
    $buttonCrawlerNode = $crawler->selectButton('Upload');
    $form = $buttonCrawlerNode->form(array('oag_file[documentName]' => ''));
    $client->submit($form);

    // Delete.
  }

}
