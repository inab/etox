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
    public function showSummaryAction($id, $initial, $orderBy)
    {
        $message="Here!";
        $em = $this->getDoctrine()->getManager();
        /*
            $conn = $this->container->get('database_connection');
            $sql = 'SELECT res.id, COUNT(*)...';
            $rows = $conn->query($sql);
        */

        //This if_elseif statement is for getting direction for sorting ( numerical values need DESC sorting while string values need ASC)
        if($orderBy=="drugbankname" or $orderBy=="drugbankid" or $orderBy=="approval"){
            $direction="ASC";
        }elseif($orderBy=="term_counter" or $orderBy=="cyp_counter" or $orderBy=="marker_counter" or $orderBy=="hepval_counter" or $orderBy=="svm_confidence_counter" or $orderBy=="pattern_counter" or $orderBy=="term_counter" or $orderBy=="rule_counter" or $orderBy=="total_mentions"){
            $direction="DESC";
        }


        $capitalInitial=strtoupper($initial);
        $sql = "SELECT * from compoundlistsummary where drugbankname like :initial or  drugbankname like :capitalInitial order by \"$orderBy\" $direction ";
        $db = $em->getConnection();
        $stmt = $db->prepare($sql);
        $params = array('initial' => $initial."%", 'capitalInitial' => $capitalInitial."%");
        $stmt->execute($params);
        $arrayDrugbanks = $stmt->fetchAll();

        $paginator = $this->get('ideup.simple_paginator');
        $drugBanks = $paginator
            ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), 'drugbanks')
            ->setItemsPerPage($this->container->getParameter('etoxMicrome.summaries_per_page'), 'drugbanks')
            ->paginate($arrayDrugbanks,'drugbanks')
            ->getResult()
        ;
        return $this->render('EtoxMicromeEntityBundle:EntitySummaries:index.html.twig', array(
            'drugBanks' => $drugBanks,
            'initial' => $initial,
            'id' => $id,
        ));

        /*
        if(($id=="drugBank")or($id=="drugbank")){
            $arrayDrugbanks=$em->getRepository('EtoxMicromeEntityBundle:Drugbank')->getDrugbanks($initial);
            //ld($arrayDrugbanks);
            $arrayCompounds=$em->getRepository('EtoxMicromeEntityBundle:CompoundDict')->getCompoundsSummary($id, $initial);

            $dictionaryNames=array();
            $dictionaryAliases=array();
            $dictionaryCountTermRelations=array();
            $dictionaryCountCypRelations=array();
            $dictionaryCountMarkerRelations=array();
            $dictionaryCountDocuments=array();

            //First we create dictionaryAliases. with keys=drugbankId and values= all aliases of the names for the drugbankId
            foreach($arrayDrugbanks as $drugBank){
                $drugBankId=$drugBank->getDrugbankid();
                $drugBankName=$drugBank->getDrugbankname();
                $dictionaryNames[$drugBankId]=$drugBankName;
                if (array_key_exists($drugBankId, $dictionaryAliases)){
                    //If already in dictionaryAliases, we add new more Aliases to array
                    $arrayAliases=$dictionaryAliases[$drugBankId];
                    $arrayAliases[]=$drugBankName;
                    $arrayAliases=array_unique($arrayAliases);
                    $dictionaryAliases[$drugBankId]=$arrayAliases;
                }else{
                    $arrayNames=array();
                    $arrayNames[]=$drugBankName;
                    $dictionaryAliases[$drugBankId]=$arrayNames;
                }
            }
            //Second we create the $dictionaryAliases
            foreach($arrayCompounds as $compound){
                $nameCompound=$compound->getName();
                $drugBankId=$compound->getDrugBank();
                if (array_key_exists($drugBankId, $dictionaryAliases)){
                    //If already in dictionaryAliases, we add new more Aliases to array
                    $arrayAliases=$dictionaryAliases[$drugBankId];
                    $arrayAliases[]=$nameCompound;
                    $arrayAliases=array_unique($arrayAliases);
                    $dictionaryAliases[$drugBankId]=$arrayAliases;
                }else{
                    $arrayNames=array();
                    $arrayNames[]=$nameCompound;
                    $dictionaryAliases[$drugBankId]=$arrayNames;
                    //we get the
                }
            }
            //Third we create the $dictionaryCountTermRelations. with keys=drugbankId and values= counter of relations in termRelations table
            foreach($arrayDrugbanks as $drugBank){
                $totalCounterTermRelations=0;
                $totalCounterCypRelations=0;
                $totalCounterMarkerRelations=0;
                //$totalCounterDocuments=0;
                $drugBankId=$drugBank->getDrugbankid();
                //We test for all the Aliases of this drugbankId
                $arrayAliases=$dictionaryAliases[$drugBankId];
                $stop=0;
                foreach($arrayAliases as $alias){
                    //Prior to count aparitions in relations table, we need to expand query with this $drugBankId
                    //$arrayCompounds=$em->getRepository('EtoxMicromeEntityBundle:CompoundDict')->getEntityFromDrugbankId($drugBankId);//We get compounds starting with a/A. Rest of compounds will be retrieved by ajax function
                        $counterTerm=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Compound2Term2Document')->countCompound2TermRelations($alias);
                        $counterCyp=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Compound2Cyp2Document')->countCompound2CypRelations($alias);
                        $counterMarker=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Compound2Marker2Document')->countCompound2MarkerRelations($alias);
                        $counterDocuments=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->countCompound2Document($alias);
                        $totalCounterTermRelations=$totalCounterTermRelations+$counterTerm;
                        $totalCounterCypRelations=$totalCounterCypRelations+$counterCyp;
                        $totalCounterMarkerRelations=$totalCounterMarkerRelations+$counterMarker;
                        //$totalCounterDocuments=$totalCounterDocuments+$counterDocuments;
                }
                $dictionaryCountTermRelations[$drugBankId]=$totalCounterTermRelations;
                $dictionaryCountCypRelations[$drugBankId]=$totalCounterCypRelations;
                $dictionaryCountMarkerRelations[$drugBankId]=$totalCounterMarkerRelations;
                //$dictionaryCountDocuments[$drugBankId]=$totalCounterDocuments;
            }
            //We build from this data a dictionary with keys=unique_DrugBank_id, values=Aliases for this Name
            $paginator = $this->get('ideup.simple_paginator');
            $drugBanks = $paginator
                ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), 'drugbanks')
                ->setItemsPerPage($this->container->getParameter('etoxMicrome.summaries_per_page'), 'drugbanks')
                ->paginate($arrayDrugbanks,'drugbanks')
                ->getResult()
            ;
            return $this->render('EtoxMicromeEntityBundle:EntitySummaries:index.html.twig', array(
                'drugBanks' => $drugBanks,
                'dictionaryAliases' => $dictionaryAliases,
                'dictionaryNames' => $dictionaryNames,
                'dictionaryCountTermRelations' => $dictionaryCountTermRelations,
                'dictionaryCountCypRelations' => $dictionaryCountCypRelations,
                'dictionaryCountMarkerRelations' => $dictionaryCountMarkerRelations,
                'id' => $id,

            ));
        }
        */
    }

    public function GInitialAction($id, $initial)
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

    public function showCytochromeSummaryAction($specie,$initial)
    {
        $em = $this->getDoctrine()->getManager();
        //First we extract a list of cytochromes from cytochrome2document, of the specie+initial given:
        if($specie=="human"){
            $specie="9606";
        }
        $cytochromes=$em->getRepository('EtoxMicromeEntityBundle:Cytochrome')->getCytochromeList($initial,$specie);
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
            'specie' => $specie,
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
