<?php

namespace EtoxMicrome\Entity2DocumentBundle\Controller;

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
    public function addCurationEntity2DocumentAction($entity2Document,$action)
    {
        $em = $this->getDoctrine()->getManager();
        $curation=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->updateEntity2DocumentCuration($entity2Document, $action);
        //Now, taking $curation into account, we generate the html code to return as json

        $url_check = $this->generateUrl(
            'ajax_entity2document_curation',
            array(
                'entity2Document' => $entity2Document,
                'action' => "check",
            )
        );
        $url_cross = $this->generateUrl(
            'ajax_entity2document_curation',
            array(
                'entity2Document' => $entity2Document,
                'action' => "cross",
            )
        );

        if($curation<0){
            $htmlCuration="<small>(Annotate relation: <a class='check-no check' id=\"check-$entity2Document\" onclick=\"curateEntity2Document('$url_check',$entity2Document,'check')\"> </a> <a class='cross-yes cross' id=\"cross-$entity2Document\" onclick=\"curateEntity2Document('$url_cross',$entity2Document,'cross')\"> </a>)</small>";
        }elseif($curation==0){
            $htmlCuration="<small>(Annotate relation: <a class='check-no check' id=\"check-$entity2Document\" onclick=\"curateEntity2Document('$url_check',$entity2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$entity2Document\" onclick=\"curateEntity2Document('$url_cross',$entity2Document,'cross')\"> </a>)</small>";
        }elseif($curation>0){
            $htmlCuration="<small>(Annotate relation: <a class='check-yes check' id=\"check-$entity2Document\" onclick=\"curateEntity2Document('$url_check',$entity2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$entity2Document\" onclick=\"curateEntity2Document('$url_cross',$entity2Document,'cross')\"> </a>)</small>";
        }
        $response=array("responseCode"=>200,  "htmlCuration"=>$htmlCuration);
        return new Response(json_encode($response));
    }

    public function addCurationCytochrome2DocumentAction($cytochrome2Document,$action)
    {
        $em = $this->getDoctrine()->getManager();
        $curation=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Cytochrome2Document')->updateCytochrome2DocumentCuration($cytochrome2Document, $action);
        //Now, taking $curation into account, we generate the html code to return as json

        $url_check = $this->generateUrl(
            'ajax_cytochrome2document_curation',
            array(
                'cytochrome2Document' => $cytochrome2Document,
                'action' => "check",
            )
        );
        $url_cross = $this->generateUrl(
            'ajax_cytochrome2document_curation',
            array(
                'cytochrome2Document' => $cytochrome2Document,
                'action' => "cross",
            )
        );

        if($curation<0){
            $htmlCuration="<small>(Annotate relation: <a class='check-no check' id=\"check-$cytochrome2Document\" onclick=\"curateEntity2Document('$url_check',$cytochrome2Document,'check')\"> </a> <a class='cross-yes cross' id=\"cross-$cytochrome2Document\" onclick=\"curateEntity2Document('$url_cross',$cytochrome2Document,'cross')\"> </a>)</small>";
        }elseif($curation==0){
            $htmlCuration="<small>(Annotate relation: <a class='check-no check' id=\"check-$cytochrome2Document\" onclick=\"curateEntity2Document('$url_check',$cytochrome2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$cytochrome2Document\" onclick=\"curateEntity2Document('$url_cross',$cytochrome2Document,'cross')\"> </a>)</small>";
        }elseif($curation>0){
            $htmlCuration="<small>(Annotate relation: <a class='check-yes check' id=\"check-$cytochrome2Document\" onclick=\"curateEntity2Document('$url_check',$cytochrome2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$cytochrome2Document\" onclick=\"curateEntity2Document('$url_cross',$cytochrome2Document,'cross')\"> </a>)</small>";
        }
        $response=array("responseCode"=>200,  "htmlCuration"=>$htmlCuration);
        return new Response(json_encode($response));
    }

    public function addCurationMarker2DocumentAction($marker2Document,$action)
    {
        $em = $this->getDoctrine()->getManager();
        $curation=$em->getRepository('EtoxMicromeEntity2DocumentBundle:HepKeywordTermVariant2Document')->updateHepKeywordTermVariant2DocumentCuration($marker2Document, $action);
        //Now, taking $curation into account, we generate the html code to return as json

        $url_check = $this->generateUrl(
            'ajax_marker2document_curation',
            array(
                'marker2Document' => $marker2Document,
                'action' => "check",
            )
        );
        $url_cross = $this->generateUrl(
            'ajax_marker2document_curation',
            array(
                'marker2Document' => $marker2Document,
                'action' => "cross",
            )
        );

        if($curation<0){
            $htmlCuration="<small>(Annotate relation: <a class='check-no check' id=\"check-$marker2Document\" onclick=\"curateEntity2Document('$url_check',$marker2Document,'check')\"> </a> <a class='cross-yes cross' id=\"cross-$marker2Document\" onclick=\"curateEntity2Document('$url_cross',$marker2Document,'cross')\"> </a>)</small>";
        }elseif($curation==0){
            $htmlCuration="<small>(Annotate relation: <a class='check-no check' id=\"check-$marker2Document\" onclick=\"curateEntity2Document('$url_check',$marker2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$marker2Document\" onclick=\"curateEntity2Document('$url_cross',$marker2Document,'cross')\"> </a>)</small>";
        }elseif($curation>0){
            $htmlCuration="<small>(Annotate relation: <a class='check-yes check' id=\"check-$marker2Document\" onclick=\"curateEntity2Document('$url_check',$marker2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$marker2Document\" onclick=\"curateEntity2Document('$url_cross',$marker2Document,'cross')\"> </a>)</small>";
        }
        $response=array("responseCode"=>200,  "htmlCuration"=>$htmlCuration);
        return new Response(json_encode($response));
    }

}