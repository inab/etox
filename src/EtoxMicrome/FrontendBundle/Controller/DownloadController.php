<?php

namespace EtoxMicrome\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class DownloadController extends Controller
{

    public function downloadAction($filename)
    {

        $message="Downloading file ";
        //ld($filename);
        $request = $this->get('request');
        $path = $this->get('kernel')->getRootDir(). "/../web/files/";
        $filepath=$path.$filename;
        //ld($filepath);
        $content = file_get_contents($filepath);

        $response = new Response();

        //set headers
        $response->headers->set('Content-Type', 'application/octet-stream');
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$filename);

        $response->setContent($content);
        return $response;
    }
    public function downloadsdfAction($filename)
    {
        $em = $this->getDoctrine()->getManager();
        $arrayFilename=explode(".", $filename);
        $idCompound=$arrayFilename[0];
        $entity=$em->getRepository('EtoxMicromeEntityBundle:CompoundDict')->getEntityFromId($idCompound);
        $compoundName=$entity->getName();
        $message="Downloading file ";
        //ld($filename);
        $request = $this->get('request');
        $path = $this->get('kernel')->getRootDir(). "/../web/files/sdf/";
        $filepath=$path.$filename;
        #ldd($filepath);
        $content = file_get_contents($filepath);

        $response = new Response();

        //set headers
        $response->headers->set('Content-Type', 'application/octet-stream');
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$compoundName.'.mol');

        $response->setContent($content);
        return $response;
    }
}
