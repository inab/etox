<?php

namespace EtoxMicrome\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CytoscapeController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function showCytoscapeAction()
    {
        $respuesta = $this->render('FrontendBundle:Cytoscape:cytoscape.html.twig');
        return $respuesta;
    }
}
