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

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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
    $xmldir = $this->getParameter('oagxml_directory');
    if (!is_dir($xmldir)) {
      mkdir($xmldir, 0755, true);
    }

    $ids = array();

    foreach ($oagfiles as $oagfile) {
      $path = $uploadDir . '/' . $oagfile->getDocumentName();
      if (!file_exists($path)) {
        // Document removed from file system, remove from the DB.
        $em->remove($oagfile);
      }
      else {
        $data = array();

        $data['file'] = $oagfile->getDocumentName();

        $filename = $oagfile->XMLFileName();
        $xmlfile = $xmldir . '/' . $oagfile->getDocumentName();
        if (file_exists($xmlfile)) {
          $data['xml'] = $xmlfile;
        }

        $files[$oagfile->getId()] = $data;
        $ids['Delete ' . $oagfile->getId()] = $oagfile->getId();
      }
    }
    $em->flush();

    $defaultData = array();
    $target = $this->generateUrl('oagfile_confirm_delete');
    $formbuilder = $this->createFormBuilder(
      $defaultData, array('action' => $target)
    );
    $formbuilder->add('delete_list', ChoiceType::class, array(
      'choices' => $ids,
      'expanded' => true,
      'multiple' => true,
    ));

    return array(
      'files' => $files,
      'form' => $formbuilder->getForm()->createView(),
    );
  }

  /**
   * @Route("/confirm_delete", name="oagfile_confirm_delete")
   * @Template
   */
  public function confirmDeleteAction(Request $request) {
    if ($request->isMethod('POST')) {
      $form = $this->createFormBuilder(null)->getForm();
      $form->handleRequest($request);

      $data = $form->getExtraData();

      if (count($data['delete_list']) == 0) {
        $this->addFlash(
          'warn', 'No files where specified!'
        );
      }

      $files = [];

      $repository = $this->getDoctrine()->getRepository(OagFile::class);
      foreach ($data['delete_list'] as $id) {
        $oagfile = $repository->findOneBy(array('id' => $id));
        $files[$id] = $oagfile->getDocumentName();
      }

      return array(
        'files' => $files,
        'ids' => implode('+', array_keys($files)),
      );
    }

    return $this->redirectToRoute('app_index');
  }

  /**
   * @Route("/delete/{ids}", name="oagfile_delete")
   */
  public function deleteAction($ids) {
    $idlist = explode('+', $ids);

    $uploadDir = $this->getParameter('oagfiles_directory');
    $xmldir = $this->getParameter('oagxml_directory');

    $repository = $this->getDoctrine()->getRepository(OagFile::class);
    foreach ($idlist as $id) {
      $oagfile = $repository->findOneBy(array('id' => $id));
      $file = $uploadDir . '/' . $oagfile->getDocumentName();
      $xml = $xmldir . '/' . $oagfile->getDocumentName();
      if (file_exists($file)) {
        unlink($file);
      }
      if (file_exists($xml)) {
        unlink($xml);
      }
    }
    return $this->redirectToRoute('app_index');
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

      // TODO Check for too big files.
      if ($form->isSubmitted() && $form->isValid()) {
        $file = $oagfile->getDocumentName();

        $filename = $file->getClientOriginalName();

        $file->move(
          $this->getParameter('oagfiles_directory'), $filename
        );

        $oagfile->setDocumentName($filename);
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
    $contents = file_get_contents($path);
    $json = $cove->processString($contents);

    $xml = $json['xml'];
    $xmldir = $this->getParameter('oagxml_directory');
    if (!is_dir($xmldir)) {
      mkdir($xmldir, 0755, true);
    }
    $filename = $oagfile->XMLFileName();
    $xmlfile = $xmldir . '/' . $oagfile->getDocumentName();
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
