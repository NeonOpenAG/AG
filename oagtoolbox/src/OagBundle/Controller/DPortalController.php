<?php

namespace OagBundle\Controller;

use OagBundle\Service\DPortal;
use OagBundle\Entity\OagFile;
use RuntimeException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/dportal")
 */
class DPortalController extends Controller
{
  /**
   * @Route("/{fileid}", requirements={"fileid": "\d+"})
   */
  public function indexAction($fileid) {
    $portal = $this->get(DPortal::class);

    $avaiable = false;
    if ($portal->isAvailable()) {
      $messages[] = 'DPortal is avaialable';
    }
    else {
      throw new RuntimeException('DPortal is not available in application scope');
    }

    $repository = $this->getDoctrine()->getRepository(OagFile::class);
    $oagfile = $repository->find($fileid);

    if (!$oagfile) {
      // TODO throw 404
      throw new RuntimeException('OAG file not found: ' . $fileid);
    }
    $portal->visualise($oagfile);

    return $this->redirect($this->getParameter('oag')['dportal']['uri']);
  }

}
