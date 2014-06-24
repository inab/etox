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
        $message="addCurationEntity2DocumentAction";
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
            $htmlCuration="<small><a class='check-no check' id=\"check-$entity2Document\" onclick=\"curateEntity2Document('$url_check',$entity2Document,'check')\"> </a> <a class='cross-yes cross' id=\"cross-$entity2Document\" onclick=\"curateEntity2Document('$url_cross',$entity2Document,'cross')\"> </a>$curation</small>";
        }elseif($curation==0){
            $htmlCuration="<small><a class='check-no check' id=\"check-$entity2Document\" onclick=\"curateEntity2Document('$url_check',$entity2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$entity2Document\" onclick=\"curateEntity2Document('$url_cross',$entity2Document,'cross')\"> </a>$curation</small>";
        }elseif($curation>0){
            $htmlCuration="<small><a class='check-yes check' id=\"check-$entity2Document\" onclick=\"curateEntity2Document('$url_check',$entity2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$entity2Document\" onclick=\"curateEntity2Document('$url_cross',$entity2Document,'cross')\"> </a>$curation</small>";
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
            $htmlCuration="<small><a class='check-no check' id=\"check-$cytochrome2Document\" onclick=\"curateEntity2Document('$url_check',$cytochrome2Document,'check')\"> </a> <a class='cross-yes cross' id=\"cross-$cytochrome2Document\" onclick=\"curateEntity2Document('$url_cross',$cytochrome2Document,'cross')\"> </a>$curation</small>";
        }elseif($curation==0){
            $htmlCuration="<small><a class='check-no check' id=\"check-$cytochrome2Document\" onclick=\"curateEntity2Document('$url_check',$cytochrome2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$cytochrome2Document\" onclick=\"curateEntity2Document('$url_cross',$cytochrome2Document,'cross')\"> </a>$curation</small>";
        }elseif($curation>0){
            $htmlCuration="<small><a class='check-yes check' id=\"check-$cytochrome2Document\" onclick=\"curateEntity2Document('$url_check',$cytochrome2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$cytochrome2Document\" onclick=\"curateEntity2Document('$url_cross',$cytochrome2Document,'cross')\"> </a>$curation</small>";
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
            $htmlCuration="<small><a class='check-no check' id=\"check-$marker2Document\" onclick=\"curateEntity2Document('$url_check',$marker2Document,'check')\"> </a> <a class='cross-yes cross' id=\"cross-$marker2Document\" onclick=\"curateEntity2Document('$url_cross',$marker2Document,'cross')\"> </a>$curation</small>";
        }elseif($curation==0){
            $htmlCuration="<small><a class='check-no check' id=\"check-$marker2Document\" onclick=\"curateEntity2Document('$url_check',$marker2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$marker2Document\" onclick=\"curateEntity2Document('$url_cross',$marker2Document,'cross')\"> </a>$curation</small>";
        }elseif($curation>0){
            $htmlCuration="<small><a class='check-yes check' id=\"check-$marker2Document\" onclick=\"curateEntity2Document('$url_check',$marker2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$marker2Document\" onclick=\"curateEntity2Document('$url_cross',$marker2Document,'cross')\"> </a>$curation</small>";
        }
        $response=array("responseCode"=>200,  "htmlCuration"=>$htmlCuration);
        return new Response(json_encode($response));
    }

    public function addCurationCompound2Term2DocumentAction($compound2Term2Document,$action)
    {
        $em = $this->getDoctrine()->getManager();
        $curation=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Compound2Term2Document')->updateCompound2Term2DocumentCuration($compound2Term2Document, $action);
        //Now, taking $curation into account, we generate the html code to return as json

        $url_check = $this->generateUrl(
            'ajax_compound2term2document_curation',
            array(
                'compound2Term2Document' => $compound2Term2Document,
                'action' => "check",
            )
        );
        $url_cross = $this->generateUrl(
            'ajax_compound2term2document_curation',
            array(
                'compound2Term2Document' => $compound2Term2Document,
                'action' => "cross",
            )
        );

        if($curation<0){
            $htmlCuration="<small><a class='check-no check' id=\"check-$compound2Term2Document\" onclick=\"curateCompound2Term2Document('$url_check',$compound2Term2Document,'check')\"> </a> <a class='cross-yes cross' id=\"cross-$compound2Term2Document\" onclick=\"curateCompound2Term2Document('$url_cross',$compound2Term2Document,'cross')\"> </a>$curation</small>";
        }elseif($curation==0){
            $htmlCuration="<small><a class='check-no check' id=\"check-$compound2Term2Document\" onclick=\"curateCompound2Term2Document('$url_check',$compound2Term2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$compound2Term2Document\" onclick=\"curateCompound2Term2Document('$url_cross',$compound2Term2Document,'cross')\"> </a>$curation</small>";
        }elseif($curation>0){
            $htmlCuration="<small><a class='check-yes check' id=\"check-$compound2Term2Document\" onclick=\"curateCompound2Term2Document('$url_check',$compound2Term2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$compound2Term2Document\" onclick=\"curateCompound2Term2Document('$url_cross',$compound2Term2Document,'cross')\"> </a>$curation</small>";
        }
        $response=array("responseCode"=>200,  "htmlCuration"=>$htmlCuration);
        return new Response(json_encode($response));
    }

    public function addCurationCompound2Cyp2DocumentAction($compound2Cyp2Document,$action)
    {
        $em = $this->getDoctrine()->getManager();
        $curation=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Compound2Cyp2Document')->updateCompound2Cyp2DocumentCuration($compound2Cyp2Document, $action);
        //Now, taking $curation into account, we generate the html code to return as json

        $url_check = $this->generateUrl(
            'ajax_compound2cyp2document_curation',
            array(
                'compound2Cyp2Document' => $compound2Cyp2Document,
                'action' => "check",
            )
        );
        $url_cross = $this->generateUrl(
            'ajax_compound2cyp2document_curation',
            array(
                'compound2Cyp2Document' => $compound2Cyp2Document,
                'action' => "cross",
            )
        );

        if($curation<0){
            $htmlCuration="<small><a class='check-no check' id=\"check-$compound2Cyp2Document\" onclick=\"curateCompound2Cyp2Document('$url_check',$compound2Cyp2Document,'check')\"> </a> <a class='cross-yes cross' id=\"cross-$compound2Cyp2Document\" onclick=\"curateCompound2Cyp2Document('$url_cross',$compound2Cyp2Document,'cross')\"> </a>$curation</small>";
        }elseif($curation==0){
            $htmlCuration="<small><a class='check-no check' id=\"check-$compound2Cyp2Document\" onclick=\"curateCompound2Cyp2Document('$url_check',$compound2Cyp2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$compound2Cyp2Document\" onclick=\"curateCompound2Cyp2Document('$url_cross',$compound2Cyp2Document,'cross')\"> </a>$curation</small>";
        }elseif($curation>0){
            $htmlCuration="<small><a class='check-yes check' id=\"check-$compound2Cyp2Document\" onclick=\"curateCompound2Cyp2Document('$url_check',$compound2Cyp2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$compound2Cyp2Document\" onclick=\"curateCompound2Cyp2Document('$url_cross',$compound2Cyp2Document,'cross')\"> </a>$curation</small>";
        }
        $response=array("responseCode"=>200,  "htmlCuration"=>$htmlCuration);
        return new Response(json_encode($response));
    }

    public function addCurationCompound2Marker2DocumentAction($compound2Marker2Document,$action)
    {
        $em = $this->getDoctrine()->getManager();
        $curation=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Compound2Marker2Document')->updateCompound2Marker2DocumentCuration($compound2Marker2Document, $action);
        //Now, taking $curation into account, we generate the html code to return as json

        $url_check = $this->generateUrl(
            'ajax_compound2marker2document_curation',
            array(
                'compound2Marker2Document' => $compound2Marker2Document,
                'action' => "check",
            )
        );
        $url_cross = $this->generateUrl(
            'ajax_compound2marker2document_curation',
            array(
                'compound2Marker2Document' => $compound2Marker2Document,
                'action' => "cross",
            )
        );

        if($curation<0){
            $htmlCuration="<small><a class='check-no check' id=\"check-$compound2Marker2Document\" onclick=\"curateCompound2Marker2Document('$url_check',$compound2Marker2Document,'check')\"> </a> <a class='cross-yes cross' id=\"cross-$compound2Marker2Document\" onclick=\"curateCompound2Marker2Document('$url_cross',$compound2Marker2Document,'cross')\"> </a>$curation</small>";
        }elseif($curation==0){
            $htmlCuration="<small><a class='check-no check' id=\"check-$compound2Marker2Document\" onclick=\"curateCompound2Marker2Document('$url_check',$compound2Marker2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$compound2Marker2Document\" onclick=\"curateCompound2Marker2Document('$url_cross',$compound2Marker2Document,'cross')\"> </a>$curation</small>";
        }elseif($curation>0){
            $htmlCuration="<small><a class='check-yes check' id=\"check-$compound2Marker2Document\" onclick=\"curateCompound2Marker2Document('$url_check',$compound2Marker2Document,'check')\"> </a> <a class='cross-no cross' id=\"cross-$compound2Marker2Document\" onclick=\"curateCompound2Marker2Document('$url_cross',$compound2Marker2Document,'cross')\"> </a>$curation</small>";
        }
        $response=array("responseCode"=>200,  "htmlCuration"=>$htmlCuration);
        return new Response(json_encode($response));
    }


}