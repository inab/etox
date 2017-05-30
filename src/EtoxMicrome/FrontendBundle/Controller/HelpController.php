<?php

namespace EtoxMicrome\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class HelpController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function showHelpAction()
    {
        $respuesta = $this->render('FrontendBundle:Help:help.html.twig');
        return $respuesta;
    }

    public function showTutorialAction()
    {
        $respuesta = $this->render('FrontendBundle:Help:tutorial.html.twig');
        return $respuesta;
    }

    public function showDocumentacionAction()
    {
        $respuesta = $this->render('FrontendBundle:Help:documentacion.html.twig');
        return $respuesta;
    }

    public function showResourcesAction()
    {
        $respuesta = $this->render('FrontendBundle:Help:resources.html.twig');
        return $respuesta;
    }

    public function showHowToCiteAction()
    {
        $respuesta = $this->render('FrontendBundle:Help:how-to-cite.html.twig');
        return $respuesta;
    }
}
