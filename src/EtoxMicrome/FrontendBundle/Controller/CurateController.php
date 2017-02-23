<?php

namespace EtoxMicrome\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use EtoxMicrome\EvidenciaBundle\Form\EvidenciaType;

class CurateController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function showAbstractAction($pmid)
    {
        ld($pmid);
        /*
            We need all entities related to that abstract, not only this one.
            We can not generate a form with all the entities related to the abstract bond into the form since the entities are not directly related to the abstract but their id+qualifier are...
        */

        $em = $this->getDoctrine()->getManager();

        $abstract = $em->getRepository('EtoxMicromeDocumentBundle:Abstracts')->findOneByPmid($pmid);
        //ld($abstract);
        $arrayEntity2Abstract = $em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->findByAbstracts($abstract->getId());
        //ld($arrayEntity2Abstract);


        return $this->render('FrontendBundle:Curate:view.html.twig', array(
            'abstract'      => $abstract,
            'arrayEntity2Abstract'   => $arrayEntity2Abstract,
        ));

    }
}