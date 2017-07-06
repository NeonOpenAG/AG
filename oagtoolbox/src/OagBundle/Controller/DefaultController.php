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

    $pretty_json = json_encode($json, JSON_PRETTY_PRINT);
    return $this->render('OagBundle:Default:index.html.twig', array('json' => $pretty_json));
  }

  /**
   * @Route("/cove/")
   */
  public function coveAction() {
    $cove = $this->get(Cove::class);
    $json = $cove->autocodeText('somexml');

    $pretty_json = json_encode($json, JSON_PRETTY_PRINT);
    return $this->render('OagBundle:Default:index.html.twig', array('json' => $pretty_json));
  }

}
