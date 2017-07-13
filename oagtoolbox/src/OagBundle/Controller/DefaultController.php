<?php

namespace OagBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use OagBundle\Service\Cove;
use Symfony\Component\HttpFoundation\Request;
use OagBundle\Entity\OagFile;
use OagBundle\Form\OagFileType;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class DefaultController extends Controller
 {

  /**
   * @Route("/", name="app_index")
   * @Template
   */
  public function indexAction() {

    // TODO - Can we amalgamate these two?
    $em = $this->getDoctrine()->getManager();
    $repository = $this->getDoctrine()->getRepository(OagFile::class);

    $files = array();
    $oagfiles = $repository->findAll();
    $uploadDir = $this->getParameter('oagfiles_directory');
    foreach ($oagfiles as $oagfile) {
      $path = $uploadDir . '/' . $oagfile->getPath();
      if (!file_exists($path)) {
        $em->remove($oagfile);
      }
      else {
        $data = array();

        $data['file'] = $oagfile->getPath();

        $xmldir = $this->getParameter('oagxml_directory');
        if (!is_dir($xmldir)) {
          mkdir($xmldir, 0755, true);
        }
        $filename = $oagfile->XMLFileName();
        $xmlfile = $xmldir . '/' . $oagfile->getPath();
        if (file_exists($xmlfile)) {
          $data['xml'] = $xmlfile;
        }

        $files[$oagfile->getId()] = $data;
      }
    }
    $em->flush();


    return array(
      'json' => 'Some JSON',
      'status' => 'URI',
      'files' => $files,
    );
  }

  /**
   * @Route("/dportal/{fileid}", name="app_dportal", requirements={"fileid": "\d+"})
   */
  public function dportalAction($fileid) {
    $repository = $this->getDoctrine()->getRepository(OagFile::class);
    $oagfile = $repository->find($fileid);
    if (!$oagfile) {
      // TODO throw 404
      throw new \RuntimeException('OAG file not found: ' . $fileid);
    }

    $xmldir = $this->getParameter('oagxml_directory');
    if (!is_dir($xmldir)) {
      mkdir($xmldir, 0755, true);
    }
    $xmlfile = $xmldir . '/' . $oagfile->XMLFileName();

    // TODO This ia filthy inline hack for harry's demo.  this needs to go into the dportal service
    exec("openag reset dportal");
    exec("openag import dportal " . $xmlfile);

    return $this->redirect('http://openag.neontribe.org:8011');
  }

  /**
   * @Route("/upload", name="oagfile_upload")
   * @Template
   */
  public function uploadAction(Request $request) {

    $em = $this->getDoctrine()->getManager();
    $oagfile = new OagFile();
    $form = $this->createForm(OagFileType::class, $oagfile);

    if ($request) {
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $file = $oagfile->getPath();

        $filename = $file->getClientOriginalName();

        $file->move(
          $this->getParameter('oagfiles_directory'), $filename
        );

        $oagfile->setPath($filename);
        $em->persist($oagfile);
        $em->flush();

        return $this->redirect($this->generateUrl('app_index'));
      }
    }

    return array(
      'form' => $form->createView(),
    );
  }

  /**
   * @Route("/download/{fileid}", name="download_file", requirements={"fileid": "\d+"})
   */
  public function downloadAction($fileid) {
    $repository = $this->getDoctrine()->getRepository(OagFile::class);
    $oagfile = $repository->find($fileid);
    if (!$oagfile) {
      // TODO throw 404
      throw new \RuntimeException('OAG file not found: ' . $fileid);
    }

    $xmldir = $this->getParameter('oagxml_directory');
    if (!is_dir($xmldir)) {
      mkdir($xmldir, 0755, true);
    }
    $xmlfile = $xmldir . '/' . $oagfile->XMLFileName();

    $response = new BinaryFileResponse($xmlfile);
    $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $oagfile->XMLFileName());
    $response->headers->set('Content-Type', 'text/xml');

    return $response;
  }

  /**
   * @Route("/cove/{fileid}", name="app_cove", requirements={"fileid": "\d+"})
   * @Template
   */
  public function coveAction($fileid) {
    $messages = [];
    $cove = $this->get(Cove::class);

    $avaiable = false;
    if ($cove->isAvailable()) {
      $messages[] = 'CoVE is avaialable';
    }
    else {
      $messages[] = 'CoVE is down, returning fixture data.';
    }

    $repository = $this->getDoctrine()->getRepository(OagFile::class);
    $oagfile = $repository->find($fileid);
    if (!$oagfile) {
      // TODO throw 404
      throw new \RuntimeException('OAG file not found: ' . $fileid);
    }
    // TODO - for bigger files we might need send as Uri
    $path = $this->getParameter('oagfiles_directory') . '/' . $oagfile->getPath();
    $contents = file_get_contents($path);
    $json = $cove->processString($contents);

    $xml = $json['xml'];
    $xmldir = $this->getParameter('oagxml_directory');
    if (!is_dir($xmldir)) {
      mkdir($xmldir, 0755, true);
    }
    $filename = $oagfile->XMLFileName();
    $xmlfile = $xmldir . '/' . $oagfile->getPath();
    file_put_contents($xmlfile, $xml);

    $err = $json['err'];
    $status = $json['status'];

    $pretty_json = json_encode($json, JSON_PRETTY_PRINT);
    return $this->render(
        'OagBundle:Default:cove.html.twig', array(
        'messages' => $messages,
        'available' => $avaiable,
        'xml' => $xmlfile,
        'err' => $err,
        'status' => $status,
        'id' => $oagfile->getId(),
        )
    );
  }

}
