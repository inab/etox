<?php

namespace EtoxMicrome\EntityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class SummariesController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function showSummaryAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $arrayCompounds=$em->getRepository('EtoxMicromeEntityBundle:CompoundDict')->getCompoundsSummary($id, 'a');//We get compounds starting with a/A. Rest of compounds will be retrieved by ajax function
        return $this->render('EtoxMicromeEntityBundle:EntitySummaries:index.html.twig', array(
            'arrayCompounds' => $arrayCompounds,
            'id' => $id,
        ));
    }

    public function showSummaryInitialAction($id, $initial)
    {
        $em = $this->getDoctrine()->getManager();
        $arrayCompounds=$em->getRepository('EtoxMicromeEntityBundle:CompoundDict')->getCompoundsSummary($id, $initial);//We get compounds starting with a/A. Rest of compounds will be retrieved by ajax function
        $htmlTableCompounds="<table id='compounds-table'>
                <thead>
                    <tr>
                        <th>Compound Name</th>
                        <th>DrugBank id</th>
                        <th>ChEBI</th>
                        <th>PubChem Compound</th>
                    </tr>
                </thead>
                <tbody>";

        foreach( $arrayCompounds as $compound){
            $name=$compound->getName();
            $drugBank=$compound->getDrugBank();
            $chebi=$compound->getChebi();
            $pubChemCompound=$compound->getPubChemCompound();
            $htmlTableCompounds=$htmlTableCompounds . "<tr><td>$name</td><td>$drugBank</td><td>$chebi</td><td>$pubChemCompound</td></tr>";
        }
        $htmlTableCompounds=$htmlTableCompounds . "</tbody></table>";


        $response=array("responseCode"=>200,  "htmlTableCompounds"=>$htmlTableCompounds);
        return new Response(json_encode($response));
    }

    public function showCytochromeSummaryAction()
    {
        $initial = "a";
        $orderBy = "name";
        return($this->showCytochromeSummaryInitialAction($initial,$orderBy));
    }

    public function showCytochromeSummaryInitialAction($initial,$orderBy)
    {

        $em = $this->getDoctrine()->getManager();
        $cytochromes=$em->getRepository('EtoxMicromeEntityBundle:Cytochrome')->getCytochromeSummary($initial, $orderBy);//We get cytochromes starting with a/A. Rest of compounds will be retrieved by ajax function
        $numberOfCytochromes=count($cytochromes);
        $paginator = $this->get('ideup.simple_paginator');
        $arrayCytochromes = $paginator
            ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), 'cytochromes')
            ->setItemsPerPage($this->container->getParameter('etoxMicrome.cytochromes_per_page'), 'cytochromes')
            ->paginate($cytochromes,'cytochromes')
            ->getResult()
        ;

        return $this->render('EtoxMicromeEntityBundle:EntitySummaries:indexCytochromes.html.twig', array(
            'initial' => $initial,
            'orderBy' => $orderBy,
            'arrayCytochromes' => $arrayCytochromes,
            'numberOfCytochromes' => $numberOfCytochromes,
        ));

        /*
        $em = $this->getDoctrine()->getManager();
        $arrayCytochromes=$em->getRepository('EtoxMicromeEntityBundle:Cytochrome')->getCytochromeSummary($initial);//We get cytochromes starting with a/A. Rest of compounds will be retrieved by ajax function
        $htmlTableCompounds="<table id='compounds-table'>
                <thead>
                    <tr>
                        <th>Uniprot id</th>
                        <th>Cytochrome Name</th>
                        <th>Canonical Name</th>
                        <th>Tax id</th>
                    </tr>
                </thead>
                <tbody>";

        foreach( $arrayCytochromes as $cytochrome){
            $uniprotId=$cytochrome->getEntityId();
            $name=$cytochrome->getName();
            $canonical=$cytochrome->getCanonical();
            $taxId=$cytochrome->getTax();
            $htmlTableCompounds=$htmlTableCompounds . "<tr><td>$uniprotId</td><td>$name</td><td>$canonical</td><td>$taxId</td></tr>";
        }
        $htmlTableCompounds=$htmlTableCompounds . "</tbody></table>";


        $response=array("responseCode"=>200,  "htmlTableCompounds"=>$htmlTableCompounds);
        return new Response(json_encode($response));
        */
    }
}
