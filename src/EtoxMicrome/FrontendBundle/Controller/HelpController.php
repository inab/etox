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
}
