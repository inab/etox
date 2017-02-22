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
    public function showCytoscapeAction($entityType, $entityName)
    {
        $orderBy="hepval";
        //We retrieve all the relations that have this entityName (Terms, Cytochromes, Markers, Compounds structurally related). With this information we load a dictionary and use it as an argument to generate strings that will render the plugin at cytoscape.html.twig
        $em = $this->getDoctrine()->getManager();
        $arrayReturn=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->createDictionaryRelationsCytoscape($entityName,$entityType);
        $dictionaryRelations=$arrayReturn[0];
        $dictionaryTypeRelations=$arrayReturn[1];


        //Now we generate the strings that will be used for rendering the cytoscape plugin ($stringNodes, $stringEdges)
        $arrayStrings=$em->getRepository('EtoxMicromeEntityBundle:TanimotoValues')->generateStringsForCytoscape($entityName, $entityType, $dictionaryRelations, $dictionaryTypeRelations);

        $stringNodes=$arrayStrings["stringNodes"];
        $stringEdges=$arrayStrings["stringEdges"];
        return $this->render('FrontendBundle:Cytoscape:cytoscape.html.twig', array(
            'stringNodes' => $stringNodes,
            'stringEdges' => $stringEdges,
        ));
    }
}
