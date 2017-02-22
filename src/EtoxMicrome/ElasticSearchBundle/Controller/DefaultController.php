<?php

namespace EtoxMicrome\ElasticSearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction()
    {
        $message="Inside indexAction of DefaultController of EtoxMicromeElasticSearchBundle";
        ldd($message);
    }
}
