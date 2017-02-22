<?php

namespace EtoxMicrome\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use EtoxMicrome\EvidenciaBundle\Form\EvidenciaType;

class OnlyCuratedController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function viewCuratedEntitiesAction()
    {
		//We need to show a list of compounds that have been curated.
        $em = $this->getDoctrine()->getManager();
        
		$paginator = $this->get('ideup.simple_paginator');
		
		$arrayEntity2Document = $paginator
                                ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), "documents")
                                ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), "documents")
                                ->paginate($em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getCuratedEntity2DocumentDQL('CompoundDict'), 'documents')
                                ->getResult()
                        ;
        
        ldd($arrayEntity2Document);
        
        return $this->render('FrontendBundle:Curate:view.html.twig', array(
            'abstract'      => $abstract,
            'arrayEntity2Abstract'   => $arrayEntity2Abstract,
        ));

    }
    
    public function viewCuratedEntitiesNameAction($entityName)
    {
		//We need to show a list of compounds that have been curated.
        $em = $this->getDoctrine()->getManager();
        
		$paginator = $this->get('ideup.simple_paginator');
		
		$arrayEntity2Document = $paginator
                                ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), "documents")
                                ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), "documents")
                                ->paginate($em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getCuratedEntity2DocumentNameDQL('CompoundDict', $entityName), 'documents')
                                ->getResult()
                        ;
        
        ldd($arrayEntity2Document);
        
        return $this->render('FrontendBundle:Curate:view.html.twig', array(
            'abstract'      => $abstract,
            'arrayEntity2Abstract'   => $arrayEntity2Abstract,
        ));

    }
}