<?php

namespace OagBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use OagBundle\Service\Geocoder;

class DefaultController extends Controller
 {

  /**
   * @Route("/")
   */
  public function indexAction() {
    $geocoder = $this->get(Geocoder::class);
    $json = $geocoder->autocodeText('somexml');

    return $this->render('OagBundle:Default:index.html.twig', array('json' => $json));
  }

  /**
   * @Route("/cove/")
   */
  public function coveAction() {
    $cove = $this->get(Cove::class);
    $json = $cove->autocodeText('somexml');

    return $this->render('OagBundle:Default:index.html.twig', array('json' => $json));
  }

}
