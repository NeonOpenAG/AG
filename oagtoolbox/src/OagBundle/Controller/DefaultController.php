<?php

namespace OagBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use OagBundle\Service\Cove;

class DefaultController extends Controller
 {

  /**
   * @Route("/")
   */
  public function indexAction() {
    return $this->render(
        'OagBundle:Default:index.html.twig', array(
        'json' => 'Some JSON',
        'uri' => 'URI',
        )
    );
  }

  /**
   * @Route("/cove/")
   */
  public function coveAction() {
    $uri = $this->container->getParameter("oag")['cove']['uri'];

    $cove = $this->get(Cove::class);
    $json = $cove->autocodeText('somexml');

    $pretty_json = json_encode($json, JSON_PRETTY_PRINT);
    return $this->render(
        'OagBundle:Default:index.html.twig', array(
        'json' => $pretty_json,
        'uri' => $uri,
        )
    );
  }

}
