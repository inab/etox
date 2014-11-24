<?php

namespace EtoxMicrome\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function homeAction()
    {
        $respuesta = $this->render('FrontendBundle:Default:home.html.twig');
        return $respuesta;
    }

    public function showTutorialAction()
    {
        $respuesta = $this->render('FrontendBundle:Default:tutorial.html.twig');
        return $respuesta;
    }

    public function compoundName2CasAction()
    {
        $arrayCompoundsCas=array();
        //We read the file with the pairs  compoundName-CASregistry_number and save it into an arrayt
        $request = $this->get('request');
        $path = $this->get('kernel')->getRootDir(). "/../web/files/";
        $filepath=$path."compoundName2CAS.tsv";
        //ld($filepath);
        $arrayContent = file($filepath);
        foreach($arrayContent as $line)
        {
            #ld($line);
            //get row data
            $arrayLine = explode("\t", $line);
            $compoundName=$arrayLine[0];
            $cas=$arrayLine[1];
            $cas=trim($cas);
            $arrayCompoundsCas[$cas]=$compoundName;
        }


        $respuesta = $this->render('FrontendBundle:Default:compoundName2Cas.html.twig', array(
            'arrayCompoundsCas'      => $arrayCompoundsCas,
        ));
        return $respuesta;
    }
}
