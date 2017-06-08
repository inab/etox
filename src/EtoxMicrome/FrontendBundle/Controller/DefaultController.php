<?php

namespace EtoxMicrome\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

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

    public function showNewsAction()
    {
        $respuesta = $this->render('FrontendBundle:Default:news.html.twig');
        return $respuesta;
    }

    public function downloadPDFAction($filename){
        $request = $this->get('request');
        $path = $this->get('kernel')->getRootDir(). "/../web/limtoxpdf/$filename";
        $response = new BinaryFileResponse($path);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT,"$filename");
        return $response;
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

    public function compoundName2t2d2CasAction()
    {
        $arrayCompoundsCas=array();
        $arrayCompoundsCasDone=array();
        //We read the file with the pairs  compoundName-CASregistry_number and save it into an arrayt
        $request = $this->get('request');
        $path = $this->get('kernel')->getRootDir(). "/../web/files/";
        $filepath=$path."compoundName2t2d2CAS.tsv";

        $filepathDone=$path."compoundName2CAS_already_done.tsv";
        $arrayContentDone = file($filepathDone);
        foreach($arrayContentDone as $line)
        {
            #ld($line);
            //get row data
            $arrayLine = explode("\t", $line);
            $compoundName=$arrayLine[0];
            $cas=$arrayLine[1];
            $cas=trim($cas);
            $arrayCompoundsCasDone[$cas]=$compoundName;
        }
        //ld($filepath);
        $arrayContent = file($filepath);
        foreach($arrayContent as $line)
        {
            #ld($line);
            //get row data
            $arrayLine = explode("\t", $line);
            $compoundName=$arrayLine[0];
            if (! array_key_exists($compoundName, $arrayCompoundsCasDone)){
                $cas=$arrayLine[1];
                $cas=trim($cas);
                $arrayCompoundsCas[$cas]=$compoundName;
            }
        }

        $respuesta = $this->render('FrontendBundle:Default:compoundName2Cas.html.twig', array(
            'arrayCompoundsCas'      => $arrayCompoundsCas,
        ));
        return $respuesta;
    }
}
