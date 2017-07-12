<?php

namespace OagBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use OagBundle\Service\Cove;
use Symfony\Component\HttpFoundation\Request;
use OagBundle\Entity\OagFile;
use OagBundle\Form\OagFileType;

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
        $files[$oagfile->getId()] = $oagfile->getPath();
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

    $pretty_json = json_encode($json, JSON_PRETTY_PRINT);
    return $this->render(
        'OagBundle:Default:cove.html.twig', array(
        'messages' => $messages,
        'available' => $avaiable,
        'json' => $pretty_json,
        )
    );
  }

}
