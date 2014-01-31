<?php

namespace EtoxMicrome\Entity2AbstractBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class CurationController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function addCurationEntity2AbstractAction($entity2Abstract,$action)
    {
        $em = $this->getDoctrine()->getManager();
        $curation=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->updateEntity2AbstractCuration($entity2Abstract, $action);
        //Now, taking $curation into account, we generate the html code to return as json

        $url_check = $this->generateUrl(
            'ajax_entity2abstract_curation',
            array(
                'entity2Abstract' => $entity2Abstract,
                'action' => "check",
            )
        );
        $url_cross = $this->generateUrl(
            'ajax_entity2abstract_curation',
            array(
                'entity2Abstract' => $entity2Abstract,
                'action' => "cross",
            )
        );

        if($curation<0){
            $htmlCuration="<small>(Annotate relation: <a class='check-no check $curation' id=\"check-$entity2Abstract\" onclick=\"curateEntity2Abstract('$url_check',$entity2Abstract,'check')\"> </a> <a class='cross-yes cross' id=\"cross-$entity2Abstract\" onclick=\"curateEntity2Abstract('$url_cross',$entity2Abstract,'cross')\"> </a>)</small>";
        }elseif($curation==0){
            $htmlCuration="<small>(Annotate relation: <a class='check-no check $curation' id=\"check-$entity2Abstract\" onclick=\"curateEntity2Document('$url_check',$entity2Abstract,'check')\"> </a> <a class='cross-no cross' id=\"cross-$entity2Abstract\" onclick=\"curateEntity2Abstract('$url_cross',$entity2Abstract,'cross')\"> </a>)</small>";
        }elseif($curation>0){
            $htmlCuration="<small>(Annotate relation: <a class='check-yes check $curation' id=\"check-$entity2Abstract\" onclick=\"curateEntity2Document('$url_check',$entity2Abstract,'check')\"> </a> <a class='cross-no cross' id=\"cross-$entity2Abstract\" onclick=\"curateEntity2Abstract('$url_cross',$entity2Abstract,'cross')\"> </a>)</small>";
        }
        $response=array("responseCode"=>200,  "htmlCuration"=>$htmlCuration);
        return new Response(json_encode($response));
    }
}
