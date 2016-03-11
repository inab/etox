<?php

namespace EtoxMicrome\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;


class SearchController extends Controller
{
    public function getOrderBy($orderBy, $valToSearch)
    {
        switch ($orderBy) {
            case "score":
                $orderBy=$valToSearch;
                break;
            case "pattern":
                $orderBy="patternCount";
                break;
            case "rule":
                $orderBy="ruleScore";
                break;
            case "term":
                $orderBy="hepTermVarScore";
                break;
            case "neprhoval":
                $orderBy="nephroval";
                break;
            case "cardioval":
                $orderBy="cardioval";
                break;
            case "thyroval":
                $orderBy="thyroval";
                break;
            case "phosphoval":
                $orderBy="phosphoval";
                break;
        }
        return $orderBy;
    }

    public function getValToSearch($field)
    {
        switch ($field) {
            case "hepatotoxicity":
                $valToSearch="hepval";
                break;
            case "cardiotoxicity":
                $valToSearch="cardioval";
                break;
            case "nephrotoxicity":
                $valToSearch="nephroval";
                break;
            case "thyrotoxicity":
                $valToSearch="thyroval";
                break;
            case "phospholipidosis":
                $valToSearch="phosphoval";
                break;

        }
        return $valToSearch;
    }

    public function getPropertyScore($entity2Whatever, $valToSearch)
    {
        $className=$entity2Whatever->getClassName();
        switch ($valToSearch) {
            case "hepval":
                if($className=="Entity2Abstract"){
                    $score=$entity2Whatever->getAbstracts()->getHepval();
                }elseif($className=="Entity2Document"){
                    $score=$entity2Whatever->getDocument()->getHepval();
                }elseif($className=="Cytochrome2Document"){
                    $score=$entity2Whatever->getDocument()->getHepval();
                }
                break;
            case "cardval":
                if($className=="Entity2Abstract"){
                    $score=$entity2Whatever->getAbstracts()->getCardval();
                }elseif($className=="Entity2Document"){
                    $score=$entity2Whatever->getDocument()->getCardval();
                }elseif($className=="Cytochrome2Document"){
                    $score=$entity2Whatever->getDocument()->getCardval();
                }
                break;
            case "nephval":
                if($className=="Entity2Abstract"){
                    $score=$entity2Whatever->getAbstracts()->getNephval();
                }elseif($className=="Entity2Document"){
                    $score=$entity2Whatever->getDocument()->getNephval();
                }elseif($className=="Cytochrome2Document"){
                    $score=$entity2Whatever->getDocument()->getNephval();
                }
                break;
            case "phosval":
                if($className=="Entity2Abstract"){
                    $score=$entity2Whatever->getAbstracts()->getPhosval();
                }elseif($className=="Entity2Document"){
                    $score=$entity2Whatever->getDocument()->getPhosval();
                }elseif($className=="Cytochrome2Document"){
                    $score=$entity2Whatever->getDocument()->getPhosval();
                }
                break;
        }
        return $score;
    }

    public function filter_by_source($arrayResults, $source){
        $message="filter_by_source $source";
        ldd($message);
        ldd($result);
    }

    public function performIntersectionArrayDocuments($arrayDocuments_1, $arrayDocuments_2)
    {
        //This function receives two arrays of objects with different types, documentsWithCompounds and documentswithcytochromes
        //Returns an array with the intersection based in the id of each document
        $message="inside performIntersectionArrayDocuments";

        $count1=count($arrayDocuments_1);
        $count2=count($arrayDocuments_2);
        //ld($count1);
        //ld($count2);
        $intersectionArray=array();
        //First of all we return an empty array if any arrayDocuments... is empty because there won't be intersection
        if($count1==0 or $count2==0){
            return $intersectionArray;
        }
        //We create an array with the ids of the second array: $arrayIds
        $arrayIds=array();
        foreach($arrayDocuments_2 as $document){
            $arraySource=$document->getSource();
            $sentenceId=$arraySource['sentenceId'];
            array_push($arrayIds, $sentenceId);
        }
        //Now we iterate over the first array and if an id exists inside $arrayIds it will take part of the intersection array
        foreach($arrayDocuments_1 as $document){
            $arraySource=$document->getSource();
            $sentenceId=$arraySource['sentenceId'];
            if(in_array($sentenceId, $arrayIds)){
                //$em = $this->getDoctrine()->getManager();
                //$document=$em->getRepository('EtoxMicromeDocumentBundle:Document')->getDocumentFromSentenceId($sentenceId);
                array_push($intersectionArray, $document);
            }
        }
        return $intersectionArray;
    }

    public function getTotalMaxMinArrayForEntities($arrayEntity2Document, $orderBy, $field){
        //Same function as before but this time whe dont have an array of Results but an array of compound2term/cyp/...2document
        $max=-10000;
        $min=10000;
        $totalHits=count($arrayEntity2Document);
        if($totalHits==0){
            $arrayResults[0]=0;
            $arrayResults[1]=0;
            $arrayResults[2]=0;
            return $arrayResults;
        }
        $className=$arrayEntity2Document[0]->getClassName();
        if($orderBy=="hepval" or $orderBy=="score"){
            foreach($arrayEntity2Document as $entity2Document){
                $data=$entity2Document->getHepval();
                if($data>$max){
                    $max=$data;
                }
                if($data<$min){
                    $min=$data;
                }
            }
        }elseif($orderBy=="svmConfidence" ){
            foreach($arrayEntity2Document as $entity2Document){
                $data=$entity2Document->getSvmConfidence();
                if($data>$max){
                    $max=$data;
                }
                if($data<$min){
                    $min=$data;
                }
            }
        }elseif($orderBy=="pattern" ){
            foreach($arrayEntity2Document as $entity2Document){
                $data=$entity2Document->getPatternCount();
                if($data>$max){
                    $max=$data;
                }
                if($data<$min){
                    $min=$data;
                }
            }
        }elseif($orderBy=="term" ){
            foreach($arrayEntity2Document as $entity2Document){
                $data=$entity2Document->getHepTermVarScore();
                if($data>$max){
                    $max=$data;
                }
                if($data<$min){
                    $min=$data;
                }
            }
        }elseif($orderBy=="rule" ){
            foreach($arrayEntity2Document as $entity2Document){
                $data=$entity2Document->getRuleScore();
                if($data>$max){
                    $max=$data;
                }
                if($data<$min){
                    $min=$data;
                }
            }
        }

        $arrayResults=array();
        $arrayResults[0]=$totalHits;
        $arrayResults[1]=$max;
        $arrayResults[2]=$min;

        return $arrayResults;
    }

    public function getTotalMaxMinArray($arrayDocumentsIntersection, $orderBy, $field){
        $max=-10000;
        $min=10000;
        $totalHits=count($arrayDocumentsIntersection);
        if($totalHits==0){
            $arrayResults[0]=0;
            $arrayResults[1]=0;
            $arrayResults[2]=0;
            return $arrayResults;
        }
        $valToSearch=$this->getValToSearch($field);
        $orderBy=$this->getOrderBy($orderBy, $valToSearch);
        foreach($arrayDocumentsIntersection as $result){
            $arraySource=$result->getSource();
            $data=$arraySource[$orderBy];
            if($data>$max){
                $max=$data;
            }
            if($data<$min){
                $min=$data;
            }
        }
        $arrayResults=array();
        $arrayResults[0]=$totalHits;
        $arrayResults[1]=$max;
        $arrayResults[2]=$min;

        return $arrayResults;
    }

    public function getTotalMaxMinArrayForRelations($arrayCompound2Relation2Documents, $orderBy, $field){
        //Same function as before but this time whe dont have an array of Results but an array of compound2term/cyp/...2document
        $max=-10000;
        $min=10000;
        $totalHits=count($arrayCompound2Relation2Documents);
        if($totalHits==0){
            $arrayResults[0]=0;
            $arrayResults[1]=0;
            $arrayResults[2]=0;
            return $arrayResults;
        }
        $className=$arrayCompound2Relation2Documents[0]->getClassName();
        if($className=="Compound2Term2Document"){
            foreach($arrayCompound2Relation2Documents as $compound2Relation2Document){
                $data=$compound2Relation2Document->getRelationScore();
                if($data>$max){
                    $max=$data;
                }
                if($data<$min){
                    $min=$data;
                }
            }
        }
        if($className=="Compound2Cyp2Document"){
            if($orderBy=="hepval" or $orderBy=="inductionScore"){
                foreach($arrayCompound2Relation2Documents as $compound2Relation2Document){
                    $data=$compound2Relation2Document->getInductionScore();
                    if($data>$max){
                        $max=$data;
                    }
                    if($data<$min){
                        $min=$data;
                    }
                }
            }elseif($orderBy=="inhibitionScore"){
                foreach($arrayCompound2Relation2Documents as $compound2Relation2Document){
                    $data=$compound2Relation2Document->getInhibitionScore();
                    if($data>$max){
                        $max=$data;
                    }
                    if($data<$min){
                        $min=$data;
                    }
                }
            }elseif($orderBy=="metabolismScore"){
                foreach($arrayCompound2Relation2Documents as $compound2Relation2Document){
                    $data=$compound2Relation2Document->getMetabolismScore();
                    if($data>$max){
                        $max=$data;
                    }
                    if($data<$min){
                        $min=$data;
                    }
                }
            }else{
                foreach($arrayCompound2Relation2Documents as $compound2Relation2Document){
                    $data=$compound2Relation2Document->getInductionScore();
                    if($data>$max){
                        $max=$data;
                    }
                    if($data<$min){
                        $min=$data;
                    }
                }
            }
        }
        if($className=="Compound2Marker2Document"){
            foreach($arrayCompound2Relation2Documents as $compound2Relation2Document){
                $data=$compound2Relation2Document->getRelationScore();
                if($data>$max){
                    $max=$data;
                }
                if($data<$min){
                    $min=$data;
                }
            }
        }
        $arrayResults=array();
        $arrayResults[0]=$totalHits;
        $arrayResults[1]=$max;
        $arrayResults[2]=$min;

        return $arrayResults;
    }




    public function queryExpansionCompoundDict($entity, $entityType, $whatToSearch){
            $message="query expansion CompoundDict whatToSearch-> name";
            //CompoundDict query expansion. We get all the possible id related to the $entity->name
            $dictionaryIds=array();
            $arrayEntityId=array();

            //We create a dictionary with key=numberOfId, value=id. We keep it only if it's not "". After we will iterate over this pairs to extend the query
            $chemIdPlus=$entity->getChemIdPlus();
            if($chemIdPlus!=""){
                $dictionaryIds['chemIdPlus']=$chemIdPlus;
            }
            $chebi=$entity->getChebi();
            if($chebi!=""){
                $dictionaryIds['chebi']=$chebi;
            }
            $casRegistryNumber=$entity->getCasRegistryNumber();
            if($casRegistryNumber!=""){
                $dictionaryIds['casRegistryNumber']=$casRegistryNumber;
            }
            $pubChemCompound=$entity->getPubChemCompound();
            if($pubChemCompound!=""){
                $dictionaryIds['pubChemCompound']=$pubChemCompound;
            }
            $pubChemSubstance=$entity->getPubChemSubstance();
            if($pubChemSubstance!=""){
                $dictionaryIds['pubChemSubstance']=$pubChemSubstance;
            }
            $inChi=$entity->getInChi();
            if($inChi!=""){
                $dictionaryIds['inChi']=$inChi;
            }
            $drugBank=$entity->getDrugBank();
            if($drugBank!=""){
                $dictionaryIds['drugBank']=$drugBank;
            }
            $humanMetabolome=$entity->getHumanMetabolome();
            if($humanMetabolome!=""){
                $dictionaryIds['humanMetabolome']=$humanMetabolome;
            }
            $keggCompound=$entity->getKeggCompound();
            if($keggCompound!=""){
                $dictionaryIds['keggCompound']=$keggCompound;
            }
            $keggDrug=$entity->getKeggDrug();
            if($keggDrug!=""){
                $dictionaryIds['keggDrug']=$keggDrug;
            }
            $mesh=$entity->getMesh();
            if($mesh!=""){
                $dictionaryIds['mesh']=$mesh;
            }
            $smile=$entity->getSmile();
            if($smile!=""){
                $dictionaryIds['smile']=$smile;
            }
            $casRegistryNumber=$entity->getCasRegistryNumber();
            if($casRegistryNumber!=""){
                $dictionaryIds['casRegistryNumber']=$casRegistryNumber;
            }
            #ld($dictionaryIds);
            $arrayTmp=array();
            foreach ($dictionaryIds as $key => $value) {
                //We get id for each key->value in CompoundDict.
                //We call getEntityFromGenericId($key, $value); That search the id from DocumentDict which have a field $key=$value.
                //e.g getEntityFromGenericId("chebi", "(DMSO)");
                $em = $this->getDoctrine()->getManager();
                $arrayTmp=$em->getRepository('EtoxMicromeEntityBundle:'.$entityType)->getIdFromGenericField($key, $value, $arrayEntityId);
                $arrayEntityId=array_merge($arrayEntityId,$arrayTmp);
            }
            $arrayEntityId[]=$entity->getId();//We add the first entityId which we already know that fits.
            $arrayEntityId=array_unique($arrayEntityId);//We get rid of the duplicates
            return $arrayEntityId;
    }

    public function queryExpansionCompoundMesh($entity, $entityType, $whatToSearch){
        //First we take the name of the entity and search for a compoundMesh with that name
        $name=$entity->getName();
        //ld($name);
        $em = $this->getDoctrine()->getManager();
        $entity=$em->getRepository('EtoxMicromeEntityBundle:CompoundMesh')->getEntityFromName($name);
        //ld($entity);
        //CompoundDict query expansion. We get all the possible id related to the name
        $dictionaryIds=array();
        $arrayEntityId=array();

        if($entity==NULL){
            return $arrayEntityId;
        }

        //We create a dictionary with key=numberOfId, value=id. We keep it only if it's not "". After we will iterate over this pairs to extend the query


        $identifier=$entity->getIdentifier();
        //ld($identifier);
        if(($identifier!="") and ($identifier!=0)){
            $dictionaryIds['identifier']=$identifier;
        }
        $meshUi=$entity->getMeshUi();
        if(($meshUi!="") and ($meshUi!=0)){
            $dictionaryIds['mehsUi']=$identifier;
        }
        $arrayTmp=array();
        foreach ($dictionaryIds as $key => $value) {
            //We get id for each key->value in CompoundDict.
            //We call getEntityFromGenericId($key, $value); That search the id from DocumentDict which have a field $key=$value.
            //e.g getEntityFromGenericId("chebi", "(DMSO)");
            $arrayTmp=$em->getRepository('EtoxMicromeEntityBundle:CompoundMesh')->getNameFromGenericField($key, $value, $arrayEntityId);
            $arrayEntityId=array_merge($arrayEntityId,$arrayTmp);
        }
        $arrayEntityId[]=$entity->getName();//We add the first entityId which we already know that fits.
        $arrayEntityId=array_unique($arrayEntityId);//We get rid of the duplicates
        return $arrayEntityId;
    }

    public function queryExpansionCytochrome($entity, $entityType, $whatToSearch){
        $message="inside queryExpansionCytochrome";
        //CompoundDict query expansion. We get all the possible id related to the name
        $dictionaryIds=array();
        $arrayEntityId=array();
        //We create a dictionary with key=numberOfId, value=id. We keep it only if it's not "". After we will iterate over this pairs to extend the query

        //Query expansion for Cytochromes differs dependingo on the $whatToSearch parameter.
        if($whatToSearch=="name"){
            //we have to search for entityIds and canonicals with this same name
            $dictionaryIds['entityId']=$entity->getEntityId();
            $dictionaryIds['canonical']=$entity->getCanonical();

        }elseif($whatToSearch=="id"){
            //we have to search for cytochromes with this same entityId
            $dictionaryIds['entityId']=$entity->getEntityId();

        }elseif($whatToSearch=="canonical"){
            //we have to search for canonicals with this same canonical
            $dictionaryIds['canonical']=$entity->getCanonical();
        }


        $arrayTmp=array();
        foreach ($dictionaryIds as $key => $value) {
            //We get id for each key->value in CompoundDict.
            //We call getEntityFromGenericId($key, $value); That search the id from DocumentDict which have a field $key=$value.
            //e.g getEntityFromGenericId("chebi", "(DMSO)");
            $em = $this->getDoctrine()->getManager();
            $arrayTmp=$em->getRepository('EtoxMicromeEntityBundle:'.$entityType)->getIdFromGenericField($key, $value, $arrayEntityId);
            $arrayEntityId=array_merge($arrayEntityId,$arrayTmp);
        }
        $arrayEntityId[]=$entity->getId();//We add the first entityId which we already know that fits.
        $arrayEntityId=array_unique($arrayEntityId);//We get rid of the duplicates
        return $arrayEntityId;
    }

    public function queryExpansionMarker($entity, $entityType, $whatToSearch){
        $message="inside queryExpansionMarker";
        //CompoundDict query expansion. We get all the possible id related to the name
        $dictionaryIds=array();
        $arrayEntityId=array();
        //We create a dictionary with key=numberOfId, value=id. We keep it only if it's not "". After we will iterate over this pairs to extend the query

        //Query expansion for HepatotoxKeyword differs dependingo on the $whatToSearch parameter.
        if($whatToSearch=="name"){
            //we have to search for all the names that have the same entityId
            $dictionaryIds['entityId']=$entity->getEntityId();

        }elseif($whatToSearch=="id"){
            //we have to search for names with this same entityId
            $dictionaryIds['name']=$entity->getName();
        }elseif($whatToSearch=="compoundsMarkersRelations"){
            //we have to search for names with this same entityId
            $dictionaryIds['entityId']=$entity->getEntityId();
        }


        $arrayTmp=array();
        foreach ($dictionaryIds as $key => $value) {
            //We get id for each key->value in CompoundDict.
            //We call getEntityFromGenericId($key, $value); That search the id from DocumentDict which have a field $key=$value.
            //e.g getEntityFromGenericId("chebi", "(DMSO)");
            $em = $this->getDoctrine()->getManager();
            $arrayTmp=$em->getRepository('EtoxMicromeEntityBundle:'.$entityType)->getIdFromGenericField($key, $value, $arrayEntityId);
            $arrayEntityId=array_merge($arrayEntityId,$arrayTmp);
        }
        $arrayEntityId[]=$entity->getId();//We add the first entityId which we already know that fits.
        $arrayEntityId=array_unique($arrayEntityId);//We get rid of the duplicates
        return $arrayEntityId;
    }

    public function queryExpansionHepatotoxKeyword($entity, $entityType, $whatToSearch){
        //We get a HepatotoxKeyword entityType, we recover its normalyzed term and create an array with all the id with that norm term in order to search with all of them
        $em = $this->getDoctrine()->getManager();
        $norm=$entity->getNorm();
        $arrayEntityId = array();
        $arrayEntityId=$em->getRepository('EtoxMicromeEntityBundle:HepatotoxKeyword')->getIdFromGenericField("norm", $norm, $arrayEntityId);
        return $arrayEntityId;
    }


     public function queryExpansion($entity, $entityType, $whatToSearch)
    {
        //Function that receives an entityId and a entityType and creates an array with all the entityIds after the query expansion is done. Note that query expansion depends on entityType.
        $arrayEntityId = array();//We create a new array for the entityIds

        //Now we add the new entityIds as a result of the query expansion.
        switch ($entityType) {
            case "CompoundDict":
                //CompoundDict query expansion
                $arrayEntityId=$this->queryExpansionCompoundDict($entity, $entityType, $whatToSearch);
                break;
            case "CompoundMesh":
                //CompoundMesh query expansion
                $arrayEntityId=$this->queryExpansionCompoundMesh($entity, $entityType, $whatToSearch);
                break;
            case "Cytochrome":
                //Cytochrome query expansion
                $arrayEntityId=$this->queryExpansionCytochrome($entity, $entityType, $whatToSearch);
                break;
            case "Marker":
                //Marker query expansion
                $arrayEntityId=$this->queryExpansionMarker($entity, $entityType, $whatToSearch);
                break;
            case "HepatotoxKeyword":
                //HepatotoxKeyword query expansion
                $arrayEntityId=$this->queryExpansionHepatotoxKeyword($entity, $entityType, $whatToSearch);
                break;


        }
        return $arrayEntityId;

    }

    public function homeAction()
    {
        $respuesta = $this->render('FrontendBundle:Default:home.html.twig');
        return $respuesta;
    }

    public function searchAction()
    {
        $field = $this->container->getParameter('etoxMicrome.default_field');//{"hepatotoxicity","embryotoxicity", etc...}
        $whatToSearch = $this->container->getParameter('etoxMicrome.default_whatToSearch');//{"name","id", "structure", "canonical"}
        $entityType= $this->container->getParameter('etoxMicrome.default_entityType');//{compound","cyp","marker","keyword"}
        $source= $this->container->getParameter('etoxMicrome.default_source');//{"pubmed","fulltext","nda","epar"}
        $entityName = $this->container->getParameter('etoxMicrome.default_entityName');
        $orderBy = $this->container->getParameter('etoxMicrome.default_orderby'); //{"score","patternCount","ruleScore","termScore"}

        return($this->searchFieldWhatToSearchEntityTypeSourceEntityAction($field, $whatToSearch, $entityType, $source, $entityName, $orderBy));
    }

    public function searchInchiAction($orderBy)
    {
        $request = $this->get('request');
        $inChi=$request->query->get('InChI');
        $entityName=$inChi;
        $field = $this->container->getParameter('etoxMicrome.default_field');//{"hepatotoxicity","embryotoxicity", etc...}
        $whatToSearch = "inChi";//{"name","id", "structure", "canonical"}
        $entityType= "CompoundDict";//{compound","cyp","marker","keyword"}
        $source= $this->container->getParameter('etoxMicrome.default_source');//{"pubmed","fulltext","nda","epar"}
        $em = $this->getDoctrine()->getManager();
        $arrayCompounds = $em->getRepository('EtoxMicromeEntityBundle:CompoundDict')->getEntityFromInchi($inChi);
        if (count($arrayCompounds)==0){
            return $this->render('FrontendBundle:Default:no_results.html.twig', array(
                'field' => $field,
                'whatToSearch' => $whatToSearch,
                'entityType' => $entityType,
                'entity' => $inChi,
                'entityName' => $entityName,
            ));
        }
        else{
             //We create an array of cytochromes from an array with their enityId
            $arrayNames=array();
            foreach ($arrayCompounds as $compound){
                $arrayEntityName[] = $compound->getName();
            }
            $arrayEntityName=array_unique($arrayEntityName);//We get rid of the duplicates
            $compound2Documents=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntity2DocumentFromFieldDQL($field, $entityType, $arrayEntityName, $source, $orderBy)->getResult();
            if (count($compound2Documents)==0){
                return $this->render('FrontendBundle:Default:no_results.html.twig', array(
                    'field' => $field,
                    'whatToSearch' => $whatToSearch,
                    'entityType' => $entityType,
                    'entity' => $inChi,
                    'entityName' => $entityName,
                ));
            }
            $arrayTotalMaxMin=$this->getTotalMaxMinArrayForEntities($compound2Documents, $orderBy, $field);
            $meanScore=$this->getMmmrScoreFromEntities($compound2Documents, $orderBy, 'mean');
            $medianScore=$this->getMmmrScoreFromEntities($compound2Documents, $orderBy, 'median');
            $paginator = $this->get('ideup.simple_paginator');
            $arrayEntity2Document = $paginator
                ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), "documents")
                ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), "documents")
                ->paginate($em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntity2DocumentFromFieldDQL($field, $entityType, $arrayEntityName, $source, $orderBy), 'documents')
                ->getResult()
            ;
            return $this->render('FrontendBundle:Search_inchi:index.html.twig', array(
                'field' => $field,
                'whatToSearch' => $whatToSearch,
                'entityType' => $entityType,
                'source' => $source,
                'entityBackup' => $entityName,
                'arrayEntityName' => $arrayEntityName,
                'arrayEntity2Document' => $arrayEntity2Document,
                'entityName' => $entityName,
                'arrayTotalMaxMin' => $arrayTotalMaxMin,
                'orderBy' => $orderBy,
                'meanScore' => $meanScore,
                'medianScore' => $medianScore,
            ));
        }
    }

    public function searchFieldAction($field)
    {   //search page with default values (Abstract origin, Hepatotoxicity field and dictionary method)
        //$field = $this->container->getParameter('etoxMicrome.default_field');//{"hepatotoxicity","embryotoxicity", etc...}
        $whatToSearch = $this->container->getParameter('etoxMicrome.default_whatToSearch');//{"name","id", "structure", "canonical"}
        $entityType= $this->container->getParameter('etoxMicrome.default_entityType');//{compound","cyp","marker","keyword"}
        $source= $this->container->getParameter('etoxMicrome.default_source');//{"pubmed","fulltext","nda","epar"}
        $entityName = $this->container->getParameter('etoxMicrome.default_entityName');
        $orderBy = $this->container->getParameter('etoxMicrome.default_orderby'); //{"score","patternCount","ruleScore","termScore"}

        return($this->searchFieldWhatToSearchEntityTypeSourceEntityAction($field, $whatToSearch, $entityType, $source, $entityName, $orderBy));
    }

    public function searchFieldWhatToSearchAction($field, $whatToSearch)
    {
       //$field = $this->container->getParameter('etoxMicrome.default_field');//{"hepatotoxicity","embryotoxicity", etc...}
        //$whatToSearch = $this->container->getParameter('etoxMicrome.default_whatToSearch');//{"name","id", "structure", "canonical"}
        $entityType= $this->container->getParameter('etoxMicrome.default_entityType');//{compound","cyp","marker","keyword"}
        $source= $this->container->getParameter('etoxMicrome.default_source');//{"pubmed","fulltext","nda","epar"}
        $entityName = $this->container->getParameter('etoxMicrome.default_entityName');
        $orderBy = $this->container->getParameter('etoxMicrome.default_orderby'); //{"score","patternCount","ruleScore","termScore"}

        return($this->searchFieldWhatToSearchEntityTypeSourceEntityAction($field, $whatToSearch, $entityType, $source, $entityName, $orderBy));
    }

    public function searchFieldWhatToSearchEntityTypeAction($field, $searchInto, $whatToSearch, $entityType)
    {
        //$field = $this->container->getParameter('etoxMicrome.default_field');//{"hepatotoxicity","embryotoxicity", etc...}
        //$whatToSearch = $this->container->getParameter('etoxMicrome.default_whatToSearch');//{"name","id", "structure", "canonical"}
        //$entityType= $this->container->getParameter('etoxMicrome.default_entityType');//{compound","cyp","marker","keyword"}
        $source= $this->container->getParameter('etoxMicrome.default_source');//{"pubmed","fulltext","nda","epar"}
        $entityName = $this->container->getParameter('etoxMicrome.default_entityName');
        $orderBy = $this->container->getParameter('etoxMicrome.default_orderby'); //{"score","patternCount","ruleScore","termScore"}

        return($this->searchFieldWhatToSearchEntityTypeSourceEntityAction($field, $whatToSearch, $entityType, $source, $entityName, $orderBy));
    }

    public function searchFieldWhatToSearchEntityTypeSourceAction($field, $searchInto, $whatToSearch, $entityType, $source)
    {
        //$field = $this->container->getParameter('etoxMicrome.default_field');//{"hepatotoxicity","embryotoxicity", etc...}
        //$whatToSearch = $this->container->getParameter('etoxMicrome.default_whatToSearch');//{"name","id", "structure", "canonical"}
        //$entityType= $this->container->getParameter('etoxMicrome.default_entityType');//{compound","cyp","marker","keyword"}
        //$source= $this->container->getParameter('etoxMicrome.default_source');//{"pubmed","fulltext","nda","epar"}
        $entityName = $this->container->getParameter('etoxMicrome.default_entityName');
        $orderBy = $this->container->getParameter('etoxMicrome.default_orderby'); //{"score","patternCount","ruleScore","termScore"}

        return($this->searchFieldWhatToSearchEntityTypeSourceEntityAction($field, $whatToSearch, $entityType, $source, $entityName, $orderBy));
    }

    public function writeFileWithArrayAbstractDocument($arrayEntity2Abstract, $arrayEntity2Document, $field, $whatToSearch, $entityType, $entityName)
    {
        $message="inside writeFileWithArrayAbstractDocument";
        if($entityType=="CompoundDict"){
            $entityType="Compound";
        }
        //ld(count($arrayEntity2Abstract));
        //ld(count($arrayEntity2Document));
        $zip = new \ZipArchive();

        $path = $this->get('kernel')->getRootDir(). "/../web/files";
        $date=date("Y-m-d_H:i:s");
        $filename = "etoxOutputFile-".$date;
        $pathToFile="$path/$filename";
        $pathToZip="$pathToFile.zip";
        if ($zip->open($pathToZip, \ZIPARCHIVE::CREATE | \ZIPARCHIVE::CREATE)!==TRUE) {
            exit("cannot open <$pathToZip>\n");
        }
        $fp = fopen($pathToFile, 'w');

        $count=0;
        $line="Searching parameters:\n
\tToxicity type:\t $field\n
\tWhat to search:\t $whatToSearch\n
\tType of entity:\t $entityType\n
\tTerm:\t $entityName\n
***********************************************************************************************\n
Evidences found in Sentences:\n
#registry\"\t\"SVM\"\t\"Confidence\"\t\"Pattern Count\"\t\"Term Score\"\t\"Rule Score\"\t\"Sentence Text\")\n
***********************************************************************************************\n";
        fwrite($fp, $line);
        foreach($arrayEntity2Document as $entity2Document){
            $valToSearch=$this->getValToSearch($field);
            $score=$this->getPropertyScore($entity2Document, $valToSearch);
            $svmConfidence=$entity2Document->getSvmConfidence();
            $patternCount=$entity2Document->getPatternCount();
            $term=$entity2Document->getHepTermVarScore();
            $rule=$entity2Document->getRuleScore();
            $text=$entity2Document->getDocument()->getText();
            $line="$count\t$score\t$svmConfidence\t$patternCount\t$term\t$rule\t$text\n";
            if($score>0){
                fwrite($fp, $line);
            }
            $count=$count+1;
            /*
            if ($count==5){
                ldd($message);
            }
            */
        }

        $count=0;
        $line="Searching parameters:\n
\tToxicity type:\t $field\n
\tWhat to search:\t $whatToSearch\n
\tType of entity:\t $entityType\n
\tTerm:\t $entityName\n
***********************************************************************************************\n
Evidences found in Abstracts:(Output fields:\t\"#registry\"\t\"Abstract text\"\t\"Pubmed link\"\t\"Score\")\n
***********************************************************************************************\n";
        fwrite($fp, $line);
        foreach($arrayEntity2Abstract as $entity2Abstract){
            $line="$count\t".$entity2Abstract->getAbstracts()->getText()."\t";
            $pubmedLink="http://www.ncbi.nlm.nih.gov/pubmed/".$entity2Abstract->getAbstracts()->getPmid();
            $line=$line.$pubmedLink."\t";
            $valToSearch=$this->getValToSearch($field);
            $score=$this->getPropertyScore($entity2Abstract, $valToSearch);
            $line=$line.$score."\t";
            $line=$line."\n";
            if($score>0){
                fwrite($fp, $line);
            }
            $count=$count+1;
        }

        fclose($fp);


        $zip->addFile($pathToFile);
        $zip->close();

        return ($filename.".zip");
    }
    public function writeFileWithArrayDocument($arrayEntity2Document, $field, $whatToSearch, $entityType, $entityName)
    {
        $message="inside writeFileWithArrayDocument";
        //ld(count($arrayEntity2Abstract));
        //ld(count($arrayEntity2Document));
        $zip = new \ZipArchive();

        $path = $this->get('kernel')->getRootDir(). "/../web/files";
        $date=date("Y-m-d_H:i:s");
        $filename = "etoxOutputFile-".$date;
        $pathToFile="$path/$filename";
        $pathToZip="$pathToFile.zip";
        if ($zip->open($pathToZip, \ZIPARCHIVE::CREATE | \ZIPARCHIVE::CREATE)!==TRUE) {
            exit("cannot open <$pathToZip>\n");
        }
        $fp = fopen($pathToFile, 'w');
        $count=0;
        $line="Searching parameters:\n
\tToxicity type:\t $field\n
\tWhat to search:\t $whatToSearch\n
\tType of entity:\t $entityType\n
\tTerm:\t $entityName\n
***********************************************************************************************\n
Evidences found in Sentences:\n
#registry\"\t\"SVM\"\t\"Confidence\"\t\"Pattern Count\"\t\"Term\"\t\"Rule score\"\t\"Sentence\")\n
***********************************************************************************************\n";
        fwrite($fp, $line);
        foreach($arrayEntity2Document as $entity2Document){
            if ($entityType=="Cytochrome"){
                $valToSearch=$this->getValToSearch($field);
                $score=$this->getPropertyScore($entity2Document, $valToSearch);
                $text=$entity2Document->getDocument()->getText();
                $svmConfidence=$entity2Document->getSvmConfidence();
                $patternCount=$entity2Document->getPatternCount();
                $term=$entity2Document->getHepTermVarScore();
                $rule=$entity2Document->getRuleScore();
                $text=$entity2Document->getDocument()->getText();
                $line="$count\t$score\t$svmConfidence\t$patternCount\t$term\t$rule\t$text\n";
            }
            $line="$count\t".$entity2Document->getDocument()->getText()."\t";


            $line=$line.$score."\t";
            $line=$line."\n";
            if($score>0){
                fwrite($fp, $line);
            }
            $count=$count+1;
            /*
            if ($count==5){
                ldd($message);
            }
            */
        }

        fclose($fp);


        $zip->addFile($pathToFile);
        $zip->close();

        return ($filename.".zip");
    }

    public function writeFileWithArrayCuratedTermRelations($arrayCuratedTermRelations)
    {
        $em = $this->getDoctrine()->getManager();
        $message="inside writeFileWithArrayCuratedTermRelations";
        //ld(count($arrayEntity2Abstract));
        //ld(count($arrayEntity2Document));
        $zip = new \ZipArchive();

        $path = $this->get('kernel')->getRootDir(). "/../web/files/curated_reports";
        $date=date("Y-m-d_H:i:s");
        $filename = "compound2termRelations-".$date;
        $pathToFile="$path/$filename";
        $pathToZip="$pathToFile.zip";
        if ($zip->open($pathToZip, \ZIPARCHIVE::CREATE | \ZIPARCHIVE::CREATE)!==TRUE) {
            exit("cannot open <$pathToZip>\n");
        }
        $fp = fopen($pathToFile, 'w');
        $count=0;
        $line="line number\"\t\"CAS-RN\"\t\"compoundName\"\t\"term\"\t\"sentence\"\t\"Curation\"\t\"pmid\"\n";
        fwrite($fp, $line);
        foreach($arrayCuratedTermRelations as $curated2term2document){

            $compoundName=$curated2term2document->getCompoundName();
            $term=$curated2term2document->getTerm();
            $sentence=$curated2term2document->getSentence();
            $curation=$curated2term2document->getCuration();
            $pmid=$curated2term2document->getDocument()->getUid();
            $compoundEntity=$em->getRepository('EtoxMicromeEntityBundle:CompoundDict')->getEntityFromName($compoundName);
            $casRegistryNumber=$compoundEntity->getCasRegistryNumber();



            $line="$count\t$casRegistryNumber\t$compoundName\t$term\t$sentence\t$curation\t$pmid\n";
            fwrite($fp, $line);
            $count=$count+1;
            /*
            if ($count==5){
                ldd($message);
            }
            */
        }

        fclose($fp);


        $zip->addFile($pathToFile);
        $zip->close();

        return ($filename.".zip");
    }


    public function exportFunction($field, $whatToSearch, $entityType, $entityName, $source, $orderBy){
        $message="exportFunction";
        $messageCompound="llega a compound";
        $messageCytochrome="llega a cytochrome";
        $messageMarker="llega a marker o a keywords...";
        $em = $this->getDoctrine()->getManager();
        //////////////////////////////////////////////////////////////
        //First of all we generate the file that will be downloaded.//
        //////////////////////////////////////////////////////////////

        //We get first of all the evidences found in Abstracts
        $entityBackup=$entityName;
        if($whatToSearch=="name"){
            //We get the entity from the entity
            $entity=$em->getRepository('EtoxMicromeEntityBundle:'.$entityType)->getEntityFromName($entityName);
        }elseif($whatToSearch=="id"){
            //We get the entity from the entityId
            $entity=$em->getRepository('EtoxMicromeEntityBundle:'.$entityType)->searchEntityGivenAnId($entityName);
        }elseif($whatToSearch=="structure"){
            //We get the entity from the structure
            $entity=$em->getRepository('EtoxMicromeEntityBundle:'.$entityType)->searchEntityGivenAnStructureText($entityName);
        }elseif($whatToSearch=="canonical"){
            //We get the entity from the canonical
            $entity=$em->getRepository('EtoxMicromeEntityBundle:'.$entityType)->searchEntityGivenACanonical($entityName);
        }
        if(count($entity)!=0){
            #We have the entityId. We need to do a QUERY EXPANSION depending on the typeOfEntity we have
            $arrayEntityId=$this->queryExpansion($entity, $entityType, $whatToSearch);
            //WARNING!! If the query expansion with a CompoundDict doesn't return any entity, we do the expansion with CompoundMesh!!
            if (($entityType=="CompoundDict") and (count($arrayEntityId)==1)){
                $arrayEntityId=$this->queryExpansion($entity, "CompoundMesh", $whatToSearch);
            }
        }else{
            //We don't have entities. We render the template with No results
            return $this->render('FrontendBundle:Default:no_results.html.twig', array(
                'field' => $field,
                'whatToSearch' => $whatToSearch,
                'entityType' => $entityType,
                'entity' => $entityBackup,
            ));

        }
        $arrayEntityId=array_unique($arrayEntityId);//We get rid of the duplicates
        if($entityType=="Cytochrome"){
            //We create an array of cytochromes from an array with their enityId
            $arrayEntities=array();
            $arrayNames=array();
            $arrayCanonicals=array();
            foreach ($arrayEntityId as $entityId){
                $cytochrome = $em->getRepository('EtoxMicromeEntityBundle:Cytochrome')->getEntityFromId($entityId);
                $arrayEntities[] = $cytochrome;
                $arrayNames[] = $cytochrome->getName();
                $arrayCanonicals[] = $cytochrome->getCanonical();
            }

            $arrayNames=array_unique($arrayNames);//We get rid of the duplicates
            $arrayCanonicals=array_unique($arrayCanonicals);//We get rid of the duplicates

            $arrayEntity2Document = $em->getRepository('EtoxMicromeEntity2DocumentBundle:Cytochrome2Document')->getCytochrome2DocumentFromField($field, $entityType, $arrayNames, $arrayCanonicals, $source, $orderBy);
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //////////////////////////////save inside file///////////////////////////////////////////////////////////////////////
            $filename=$this->writeFileWithArrayDocument($arrayEntity2Document, $field, $whatToSearch, $entityType, $entityName);
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        }else
        { //For Compounds and Markers
            //In order to relate entities with documents, we have to use the names of the entities instead of their entityId. Therefore we translate $arrayEntityId to $arrayEntityName
            $arrayEntityName=array();
            $em = $this->getDoctrine()->getManager();
            foreach($arrayEntityId as $entityId){
                $entidad=$em->getRepository('EtoxMicromeEntityBundle:'.$entityType)->getEntityFromId($entityId);
                $arrayEntityName[]=($entidad->getName());
            }
            $arrayEntityName=array_unique($arrayEntityName);//We get rid of the duplicates
            if($entityType=="CompoundDict" or $entityType=="CompoundMesh"){
                //We search into Abstracts only if we are looking for Compounds
                $arrayEntity2Document = $em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntity2DocumentFromField($field, $entityType, $arrayEntityName, $source, $orderBy);
                $arrayEntity2Abstract = $em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntity2AbstractFromField($field, "CompoundMesh", $arrayEntityName, $orderBy);

                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                ////////////////////////////////////////save inside file///////////////////////////////////////////////////////////////////////////////////////////
                $filename=$this->writeFileWithArrayAbstractDocument($arrayEntity2Abstract, $arrayEntity2Document, $field, $whatToSearch, $entityType, $entityName);
                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




            }else{//Neither Compounds nor Cytochromes
                //We just search into Documents
                $arrayEntity2Document = $em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntity2DocumentFromField($field, $entityType, $arrayEntityName);

                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //////////////////////////////save inside file///////////////////////////////////////////////////////////////////////
                $filename=$this->writeFileWithArrayDocument($arrayEntity2Document, $field, $whatToSearch, $entityType, $entityName);
                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            }
        }
        return ($filename);


    }

    public function downloadCuratedTermRelationsAction(){
        $em = $this->getDoctrine()->getManager();
        //////////////////////////////////////////////////////////////
        //First of all we generate the file that will be downloaded.//
        //////////////////////////////////////////////////////////////
        $arrayCuratedTermRelations=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Compound2Term2Document')->getCuratedTermRelations();
        $filename=$this->writeFileWithArrayCuratedTermRelations($arrayCuratedTermRelations);
        //ld($filename);
        $request = $this->get('request');
        $path = $this->get('kernel')->getRootDir(). "/../web/files/curated_reports/";
        $filepath=$path.$filename;
        #ldd($filepath);
        $content = file_get_contents($filepath);

        $response = new Response();

        //set headers
        $response->headers->set('Content-Type', 'application/octet-stream');
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$filename);

        $response->setContent($content);
        return $response;




    }

    public function mmmr($array, $output = 'mean'){
        //Function to get mean(default), median, mode and range of $array input
        if(!is_array($array)){
            return FALSE;
        }else{
            switch($output){
                case 'mean':
                    $count = count($array);
                    $sum = array_sum($array);
                    $total = $sum / $count;
                break;
                case 'median':
                    rsort($array);
                    $middle = round(count($array) / 2);
                    $total = $array[$middle-1];
                break;
                case 'range':
                    sort($array);
                    $sml = $array[0];
                    rsort($array);
                    $lrg = $array[0];
                    $total = $lrg - $sml;
                break;
            }
            return $total;
        }
    }
    public function getMmmrScore($resultSetDocuments, $orderBy, $operation = 'mean'){
        //Function that receives a resultSetDocuments and extracts the mean value of the score

        $arrayResults=$resultSetDocuments->getResults();
        if(count($arrayResults)==0){
            return 0;
        }
        $arrayInput=array();
        foreach($arrayResults as $result){
            if($orderBy=="score"){
                $orderBy="hepval";
            }elseif($orderBy=="pattern"){
                $orderBy="patternCount";
            }elseif($orderBy=="rule"){
                $orderBy="ruleScore";
            }elseif($orderBy=="term"){
                $orderBy="hepTermVarScore";
            }
            $arrayData=$result->getSource();
            $data=$arrayData[$orderBy];
            if($data==null){
                $data=0;
            }
            $arrayInput[]=$data;
        }
        if(count($arrayInput)!=0){
            $output=$this->mmmr($arrayInput, $operation);
        }
        else{
            $output=0;
        }
        return $output;
    }

     public function getMmmrScoreFromEntities($arrayEntity2Document, $orderBy, $operation = 'mean'){
        $message="getMmmrScoreFromRelation";
        //Function that receives a resultSetDocuments and extracts the mean value of the score
        //First we have to see what className is coming, then we sort by different scores/fields...
        $arrayInput=array();
        if(count($arrayEntity2Document)==0){
            return 0;
        }
        if($orderBy=="hepval" or $orderBy=="score"){
            foreach($arrayEntity2Document as $entity2Document){
                $data=$entity2Document->getHepval();
                if($data==null){
                    $data=0;
                }
                $arrayInput[]=$data;
            }
        }elseif($orderBy=="svmConfidence" ){
            foreach($arrayEntity2Document as $entity2Document){
                $data=$entity2Document->getSvmConfidence();
                if($data==null){
                    $data=0;
                }
                $arrayInput[]=$data;
            }
        }elseif($orderBy=="pattern" ){
            foreach($arrayEntity2Document as $entity2Document){
                $data=$entity2Document->getPatternCount();
                if($data==null){
                    $data=0;
                }
                $arrayInput[]=$data;
            }
        }elseif($orderBy=="term" ){
            foreach($arrayEntity2Document as $entity2Document){
                $data=$entity2Document->getHepTermVarScore();
                if($data==null){
                    $data=0;
                }
                $arrayInput[]=$data;
            }
        }
        elseif($orderBy=="rule" ){
            foreach($arrayEntity2Document as $entity2Document){
                $data=$entity2Document->getRuleScore();
                if($data==null){
                    $data=0;
                }
                $arrayInput[]=$data;
            }
        }
        if(count($arrayInput)!=0){
            $output=$this->mmmr($arrayInput, $operation);
        }
        else{
            $output=0;
        }
        return $output;
    }

    public function getMmmrScoreFromIntersection($resultSetDocuments, $orderBy, $operation = 'mean'){
        //Function that receives a resultSetDocuments and extracts the mean value of the score
        $arrayInput=array();
        if(count($resultSetDocuments)==0){
            return 0;
        }
        if($orderBy=="score"){
                $orderBy="hepval";
            }elseif($orderBy=="pattern"){
                $orderBy="patternCount";
            }elseif($orderBy=="rule"){
                $orderBy="ruleScore";
            }elseif($orderBy=="term"){
                $orderBy="hepTermVarScore";
            }
        foreach($resultSetDocuments as $result){
            $arrayData=$result->getSource();
            $data=$arrayData[$orderBy];
            if($data==null){
                $data=0;
            }
            $arrayInput[]=$data;
        }
        if(count($arrayInput)!=0){
            $output=$this->mmmr($arrayInput, $operation);
        }
        else{
            $output=0;
        }
        return $output;
    }

    public function getMmmrScoreFromRelation($arrayCompound2Relation2Documents, $orderBy, $operation = 'mean'){
        $message="getMmmrScoreFromRelation";
        //Function that receives a resultSetDocuments and extracts the mean value of the score
        //First we have to see what className is coming, then we sort by different scores/fields...
        $arrayInput=array();
        if(count($arrayCompound2Relation2Documents)==0){
            return 0;
        }
        $className=$arrayCompound2Relation2Documents[0]->getClassName();
        if($className=="Compound2Term2Document"){
            foreach($arrayCompound2Relation2Documents as $compound2Relation2Document){
                $data=$compound2Relation2Document->getRelationScore();
                if($data==null){
                    $data=0;
                }
                $arrayInput[]=$data;
            }
        }

        if($className=="Compound2Cyp2Document"){

            if($orderBy=="hepval"){
                //by default we summarize by inductionScore
                foreach($arrayCompound2Relation2Documents as $compound2Relation2Document){
                    $data=$compound2Relation2Document->getInductionScore();
                    if($data==null){
                        $data=0;
                    }
                    $arrayInput[]=$data;
                }
            }elseif($orderBy=="inhibitionScore"){
                //by default we summarize by inductionScore
                foreach($arrayCompound2Relation2Documents as $compound2Relation2Document){
                    $data=$compound2Relation2Document->getInhibitionScore();
                    if($data==null){
                        $data=0;
                    }
                    $arrayInput[]=$data;
                }
            }elseif($orderBy=="metabolismScore"){
                //by default we summarize by inductionScore
                foreach($arrayCompound2Relation2Documents as $compound2Relation2Document){
                    $data=$compound2Relation2Document->getMetabolismScore();
                    if($data==null){
                        $data=0;
                    }
                    $arrayInput[]=$data;
                }
            }else{
                //by default we summarize by inductionScore
                foreach($arrayCompound2Relation2Documents as $compound2Relation2Document){
                    $data=$compound2Relation2Document->getInductionScore();
                    if($data==null){
                        $data=0;
                    }
                    $arrayInput[]=$data;
                }
            }

        }
        if($className=="Compound2Marker2Document"){
            foreach($arrayCompound2Relation2Documents as $compound2Relation2Document){
                $data=$compound2Relation2Document->getRelationScore();
                if($data==null){
                    $data=0;
                }
                $arrayInput[]=$data;
            }
        }

        if(count($arrayInput)!=0){
            $output=$this->mmmr($arrayInput, $operation);
        }
        else{
            $output=0;
        }
        return $output;
    }

    public function getRidOfDuplicatedEntries($compound2Documents){
        //Temporary function to get rid of the duplicated based in the unique index of document_id and name of the compound2Document
        $arrayOutput=array();
        $dictionaryOfArrays=array();

        foreach($compound2Documents as $entity2Document){
            $documentId=$entity2Document->getDocument()->getId();
            $name=$entity2Document->getName();
            if (array_key_exists($documentId, $dictionaryOfArrays)) {
                //If exists the key then we look for the name
                $arrayNames=$dictionaryOfArrays[$documentId];
                if (in_array($name, $arrayNames)) {
                    //If found inside the array we don't do anything
                }else{
                    //If not found, we add to both arrays
                    $arrayOutput[]=$entity2Document;
                    $arrayNames[]=$name;
                    $dictionaryOfArrays[$documentId]=$arrayNames;
                }
            }else{
                //We add to both arrays
                $arrayTmp=array();
                $arrayTmp[]=$name;
                $dictionaryOfArrays[$documentId]=$arrayTmp;
                $arrayOutput[]=$entity2Document;
            }
            //The structure is a dictionary of arrays. If the element exists we don't add the $entity2Document to the $arrayOutput
        }
        return($arrayOutput);

    }

    public function searchGeneAction($whatToSearch, $source, $entityName)
    {
        $message="inside searchGeneOrderByAction";
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////In this lines we check if the user wants to download the results of the searching process. If so, the exportFunction is called//////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //$source="geneName" or "geneId";
        //$whatToSearch="any","withCompounds"...etc
        $orderBy = $this->container->getParameter('etoxMicrome.default_orderby'); //
        return($this->searchGeneOrderbyAction($whatToSearch, $source, $entityName, $orderBy));

    }

    public function searchGeneOrderByAction($whatToSearch, $source, $entityName, $orderBy)
    {
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////In this lines we check if the user wants to download the results of the searching process. If so, the exportFunction is called//////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $field="hepatotoxicity";
        $entityType="gene";
        //$source="geneName" or "geneId";
        //$whatToSearch="any","withCompounds"...etc

        $message="inside searchGeneOrderByAction";
        $entityBackup=$entityName;
        $em = $this->getDoctrine()->getManager();
        //We add the paginator
        $paginator = $this->get('ideup.simple_paginator');
        //The search will be performed using the gene_id. If gene_name is used, then we get its gene_id from the genedictionary table
        $arrayGeneIds=[];
        $arrayAbstracts=[];
        if ($source=="geneName"){
            $arrayGenes=$em->getRepository('EtoxMicromeEntityBundle:GeneDictionary')->findByGeneName($entityName);
            //We generate an array of geneIds that will be used as the result of the query expansion
            foreach($arrayGenes as $gene){
                array_push($arrayGeneIds, $gene->getGeneId());
            }
        }elseif($source=="geneId"){
            array_push($arrayGeneIds, $entityName);
        }
        $arrayGeneIds=array_unique($arrayGeneIds);
        //Searching for genes can only be performed against either abstracts(any) or abstractswithcompounds(withCompounds)


        //For the $whatToSearch == "any" part, we search against abstracts table using each gene_id in $arrayGeneIds

        //foreach($arrayGeneIds as $geneId){

        //    $arrayGene2Abstract=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Gene2Abstract')->findByGeneId($geneId);
        //    $arrayAbstracts=array_merge($arrayGene2Abstract,$arrayAbstracts);
        //}



        //$gene2Abstracts=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Gene2Abstract')->getGene2AbstractFromGeneIDsDQL($arrayGeneIds, $orderBy)->getResult();
        //ld(count($gene2Abstracts));
        //$arrayTotalMaxMin=$this->getTotalMaxMinArrayForEntities($compound2Abstracts, $orderBy, $field);
        //$meanScore=$this->getMmmrScoreFromEntities($compound2Abstracts, $orderBy, 'mean');
        //$medianScore=$this->getMmmrScoreFromEntities($compound2Abstracts, $orderBy, 'median');

        if (count($arrayGeneIds) == 0){
            return $this->render('FrontendBundle:Default:no_results.html.twig', array(
                'field' => $field,
                'whatToSearch' => $whatToSearch,
                'entityType' => $entityType,
                'entity' => $entityBackup,
                'entityName' => $entityName,
            ));

        }else{
            ldd($message);
            $arrayGene2Abstract = $paginator
                ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), "abstracts")
                ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), "abstracts")
                ->paginate($em->getRepository('EtoxMicromeEntity2AbstractBundle:Gene2Abstract')->getGene2AbstractsFromGeneIDsDQL($arrayGeneIds, $orderBy), 'abstracts')
                ->getResult()
            ;
        }


        if($whatToSearch=="withCompounds"){
            //We just have to filter the previous result against the abstractWithCompounds table. If the abstract exists in abstractsWithCompounds table, then we keep it. Otherwise we don't
            foreach($arrayAbstracts as $gene2abstract){
                //We have to test if each abstract is in abstractWithCompounds table
                $abstractWithCompound=$em->getRepository('EtoxMicromeDocumentBundle:AbstractWithCompound')->findByPmid($gene2abstract->getPmid());
                ld($abstractWithCompound);
                ldd($gene2abstract);
            }
        }

        #ld($arrayGene2Abstract[0]);
        #ldd($arrayGene2Abstract);
        #ld($field);
        #ld($source);
        #ld($entityName);
        #ld($whatToSearch);
        return $this->render('FrontendBundle:Search_gene2abstract:index.html.twig', array(
            'field' => $field,
            'entityType' => $entityType,
            'keyword' => $entityName,
            'arrayGene2Abstract' => $arrayGene2Abstract,
            'whatToSearch' => $whatToSearch,
            'source' => $source,
            'entityName' => $entityName,
            'entityBackup' => $entityBackup,
            'orderBy' => $orderBy,
            //'hitsShowed' => $hitsShowed,
            //'meanScore' => $meanScore,
            //'medianScore' => $medianScore,
        ));
    }


    public function searchFieldWhatToSearchEntityTypeSourceEntityAction($field, $whatToSearch, $entityType, $source, $entityName, $orderBy)
    {
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////In this lines we check if the user wants to download the results of the searching process. If so, the exportFunction is called//////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $message="inside searchField..EntityAction";
        $request = $this->get('request');
        $download=$request->query->get('download');
        $arraySourcesDocuments=array("all","pubmed","fulltext", "epar","nda");
        $arraySourcesAbstracts=array("abstract");
        $arrayFormats=array("csv","pdf","xls");
        if (in_array($download, $arrayFormats)){
            $filename=$this->exportFunction($field, $whatToSearch, $entityType, $entityName, $source, $orderBy);
            return $this->render('FrontendBundle:Default:download_file.html.twig', array(
            'field' => $field,
            'whatToSearch' => $whatToSearch,
            'entityType' => $entityType,
            'entity' => $entityName,
            'filename' => $filename,
            'orderBy' => $orderBy,
            'format' => $download,
            ));
        exit();
        }
        //$field = $this->container->getParameter('etoxMicrome.default_field');//{"hepatotoxicity","embryotoxicity", etc...}
        //$whatToSearch = $this->container->getParameter('etoxMicrome.default_whatToSearch');//{"name","id", "structure", "canonical"}
        //$entityType= $this->container->getParameter('etoxMicrome.default_entityType');//{compound","cyp","marker","keyword"}
        //$entityName = $this->container->getParameter('etoxMicrome.default_entityName');
        $em = $this->getDoctrine()->getManager();
        //We add the paginator
        $paginator = $this->get('ideup.simple_paginator');
        //First of all we have to find the entityId of the entity received...
        //As we know the entityType, we can get the repository to search into...
        $entityType=ucfirst($entityType);
        $entityBackup=$entityName;
        if($whatToSearch=="name"){
            //We get the entity from the entity
            $entity=$em->getRepository('EtoxMicromeEntityBundle:'.$entityType)->getEntityFromName($entityName);
        }elseif($whatToSearch=="id"){
            //We get the entity from the entityId
            $entity=$em->getRepository('EtoxMicromeEntityBundle:'.$entityType)->searchEntityGivenAnId($entityName);
        }elseif($whatToSearch=="structure"){
            //We get the entity from the structure
            $entity=$em->getRepository('EtoxMicromeEntityBundle:'.$entityType)->searchEntityGivenAnStructureText($entityName);
        }elseif($whatToSearch=="canonical"){
            //We get the entity from the canonical
            $entity=$em->getRepository('EtoxMicromeEntityBundle:'.$entityType)->searchEntityGivenACanonical($entityName);
        }elseif(($whatToSearch=="smile") or ($whatToSearch == "inChi")){
            //We get the entity from the smile
            $entity=$em->getRepository('EtoxMicromeEntityBundle:'.$entityType)->searchEntityGivenAnStructureText($entityName);
        }elseif($whatToSearch=="any" or $whatToSearch=="withCompounds" or $whatToSearch=="withCytochromes" or $whatToSearch=="withMarkers"){
            ////////////////////////////////////////////////////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////
            ///  If we are searching for Cytochromes or Markers, with the any or WithCompounds//////
            ///  We prepare a elasticsearch and use the search/keyword interface////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////
            $elasticaQueryString  = new \Elastica\Query\QueryString();
            //'And' or 'Or' default : 'Or'
            $elasticaQueryString->setDefaultOperator('AND');
            $elasticaQueryString->setQuery($entityName);
            // Create the actual search object with some data.
            $elasticaQuery  = new \Elastica\Query();
            $elasticaQuery->setSort(array('hepval' => array('order' => 'desc')));
            $elasticaQuery->setQuery($elasticaQueryString);
            if($source!="all" and $source!="abstract"){
                $elasticaFilterBool = new \Elastica\Filter\Bool();
                $filter1 = new \Elastica\Filter\Term();
                $filter1->setTerm('kind', $source);
                $elasticaFilterBool->addMust($filter1);
                $elasticaQuery->setFilter($elasticaFilterBool);
            }
            if($orderBy=="hepval"){
                $elasticaQuery->setSort(array('hepval' => array('order' => 'desc')));
            }elseif($orderBy=="pattern"){
                $elasticaQuery->setSort(array('patternCount' => array('order' => 'desc')));
                $elasticaFilterBool = new \Elastica\Filter\Bool();
                $filter2 = new \Elastica\Filter\Missing();
                $filter2->setParam('field', "patternCount");
                $filter2->setParam('existence', true);
                $filter2->setParam('null_value', true);
                $elasticaFilterBool->addMustNot($filter2);
                $elasticaQuery->setFilter($elasticaFilterBool);
            }elseif($orderBy=="rule"){
                $elasticaQuery->setSort(array('ruleScore' => array('order' => 'desc')));
                $elasticaFilterBool = new \Elastica\Filter\Bool();
                $filter2 = new \Elastica\Filter\Missing();
                $filter2->setParam('field', "ruleScore");
                $filter2->setParam('existence', true);
                $filter2->setParam('null_value', true);
                $elasticaFilterBool->addMustNot($filter2);
                $elasticaQuery->setFilter($elasticaFilterBool);
            }elseif($orderBy=="term"){
                $elasticaQuery->setSort(array('hepTermVarScore' => array('order' => 'desc')));
                $elasticaFilterBool = new \Elastica\Filter\Bool();
                $filter2 = new \Elastica\Filter\Missing();
                $filter2->setParam('field', "hepTermVarScore");
                $filter2->setParam('existence', true);
                $filter2->setParam('null_value', true);
                $elasticaFilterBool->addMustNot($filter2);
                $elasticaQuery->setFilter($elasticaFilterBool);
            }elseif($orderBy=="svmConfidence"){
                $elasticaQuery->setSort(array('svmConfidence' => array('order' => 'desc')));
                $elasticaFilterBool = new \Elastica\Filter\Bool();
                $filter2 = new \Elastica\Filter\Missing();
                $filter2->setParam('field', "svmConfidence");
                $filter2->setParam('existence', true);
                $filter2->setParam('null_value', true);
                $elasticaFilterBool->addMustNot($filter2);
                $elasticaQuery->setFilter($elasticaFilterBool);
            }

            //Search on the index.
            $elasticaQuery->setSize($this->container->getParameter('etoxMicrome.total_documents_elasticsearch_retrieval'));
            if($whatToSearch=="any"){
                if($entityType=="CompoundDict"){
                     if ($source=="abstract"){
                        $abstractsInfo = $this->container->get('fos_elastica.index.etoxindex2.abstractswithcompounds');/** To get resultSet to get values for summary**/
                        $resultSetAbstracts = $abstractsInfo->search($elasticaQuery);
                        $arrayAbstracts=$resultSetAbstracts->getResults();
                        $finderDoc=false;
                        $resultSetDocuments = array();
                        $arrayResultsAbs = $paginator
                            ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), 'abstracts')
                            ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), 'abstracts')
                            ->paginate($arrayAbstracts,'abstracts')
                            ->getResult()
                        ;
                        $arrayResultsDoc= array();
                        $hitsShowed=count($arrayAbstracts);
                        $meanScore=$this->getMmmrScore($resultSetAbstracts, $orderBy, 'mean');
                        $medianScore=$this->getMmmrScore($resultSetAbstracts, $orderBy, 'median');
                        $rangeScore=$this->getMmmrScore($resultSetAbstracts, $orderBy, 'range');
                     }else{
                        $documentsInfo = $this->container->get('fos_elastica.index.etoxindex2.documentswithcompounds');/** To get resultSet to get values for summary**/
                        $resultSetDocuments = $documentsInfo->search($elasticaQuery);
                        $arrayDocuments=$resultSetDocuments->getResults();//$results has an array of results objects, data can be obtained by the getSource metho
                        //$finderDoc = $this->container->get('fos_elastica.finder.etoxindex2.documentswithmarkers');
                        //$arrayDocuments=$finderDoc->find($elasticaQuery);
                        $arrayResultsDoc = $paginator
                            ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), 'documents')
                            ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), 'documents')
                            ->paginate($arrayDocuments,'documents')
                            ->getResult()
                        ;
                        $finder = false;
                        $resultSetAbstracts = array();//There is no abstractsWithCytochromes nor abstractsWithMarkers information in the database
                        $arrayResultsAbs=array();
                        $hitsShowed=count($arrayDocuments);
                        $meanScore=$this->getMmmrScore($resultSetDocuments, $orderBy, 'mean');
                        $medianScore=$this->getMmmrScore($resultSetDocuments, $orderBy, 'median');
                        $rangeScore=$this->getMmmrScore($resultSetDocuments, $orderBy, 'range');
                     }
                }
                if($entityType=="Cytochrome"){
                    $finder = false;
                    $resultSetAbstracts = array();//There is no abstractsWithCytochromes nor abstractsWithMarkers information in the database
                    $arrayResultsAbs=array();
                    $documentsInfo = $this->container->get('fos_elastica.index.etoxindex2.documentswithcytochromes');/** To get resultSet to get values for summary**/
                    $resultSetDocuments = $documentsInfo->search($elasticaQuery);
                    $arrayDocuments=$resultSetDocuments->getResults();//$results has an array of results objects, data can be obtained by the getSource method
                    $arrayResultsDoc = $paginator
                        ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), 'documents')
                        ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), 'documents')
                        ->paginate($arrayDocuments,'documents')
                        ->getResult()
                    ;
                    $hitsShowed=count($arrayDocuments);
                    $meanScore=$this->getMmmrScore($resultSetDocuments, $orderBy, 'mean');
                    $medianScore=$this->getMmmrScore($resultSetDocuments, $orderBy, 'median');
                    $rangeScore=$this->getMmmrScore($resultSetDocuments, $orderBy, 'range');
                }
                if($entityType=="Marker"){
                    //We have to make a free search against elastica documentswithmarkers indexes
                    $finder = false;
                    $resultSetAbstracts = array();//There is no abstractsWithCytochromes nor abstractsWithMarkers information in the database
                    $arrayResultsAbs=array();
                    $documentsInfo = $this->container->get('fos_elastica.index.etoxindex2.documentswithmarkers');/** To get resultSet to get values for summary**/
                    $resultSetDocuments = $documentsInfo->search($elasticaQuery);
                    $arrayDocuments=$resultSetDocuments->getResults();//$results has an array of results objects, data can be obtained by the getSource method
                    $arrayResultsDoc = $paginator
                        ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), 'documents')
                        ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), 'documents')
                        ->paginate($arrayDocuments,'documents')
                        ->getResult()
                    ;
                    $hitsShowed=count($arrayDocuments);
                    $meanScore=$this->getMmmrScore($resultSetDocuments, $orderBy, 'mean');
                    $medianScore=$this->getMmmrScore($resultSetDocuments, $orderBy, 'median');
                    $rangeScore=$this->getMmmrScore($resultSetDocuments, $orderBy, 'range');
                }
            }elseif($whatToSearch=="withCompounds"){
                if($entityType=="Cytochrome"){
                    //We have to make a free search against the intersection of documentswithcompounds with documentswithcytochromes
                    //In order to perform the intersection we change the size of the results
                    $elasticaQuery->setSize(1500);
                    $finder = false;

                    $documentsInfo = $this->container->get('fos_elastica.index.etoxindex2.documentswithcompounds');/** To get resultSet to get values for summary**/
                    $resultSetDocuments = $documentsInfo->search($elasticaQuery);
                    $arrayDocumentsWithCompounds=$resultSetDocuments->getResults();//$results has an array of results objects, data can be obtained by the getSource metho

                    $finderDocWithCytochromes = $this->container->get('fos_elastica.index.etoxindex2.documentswithcytochromes');
                    $resultSetDocWithCytochromes = $finderDocWithCytochromes->search($elasticaQuery);
                    $arrayDocumentsWithCytochromes=$resultSetDocWithCytochromes->getResults();//$results has an array of results objects, data can be obtained by the getSource method
                    $arrayDocumentsIntersection=$this->performIntersectionArrayDocuments($arrayDocumentsWithCompounds, $arrayDocumentsWithCytochromes);
                    $arrayResultsDoc = $paginator
                        ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), 'documents')
                        ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), 'documents')
                        ->paginate($arrayDocumentsIntersection,'documents')
                        ->getResult()
                    ;
                    $hitsShowed=count($arrayDocumentsIntersection);
                    $meanScore=$this->getMmmrScoreFromIntersection($arrayDocumentsIntersection, $orderBy, 'mean');
                    $medianScore=$this->getMmmrScoreFromIntersection($arrayDocumentsIntersection, $orderBy, 'median');
                    //We restore size to its default value
                    $elasticaQuery->setSize($this->container->getParameter('etoxMicrome.total_documents_elasticsearch_retrieval'));
                    //When dealing with withIntersection arrays, we only have this array to get the needed values that we retreive in interface using resultSetArrays... Which are: totalHits, Max. Score, Min. Score
                    //So we implement a function to get all this info inside an arrayTotalMaxMin. Being arrayTotalMaxMin[0]=totalHits, arrayTotalMaxMin[1]=Max.score, arrayTotalMaxMin[2]=Min.score
                    $arrayTotalMaxMin=$this->getTotalMaxMinArray($arrayDocumentsIntersection, $orderBy, $field);
                    return $this->render('FrontendBundle:Search_keyword:indexWithIntersection.html.twig', array(
                        'field' => $field,
                        'entityType' => $entityType,
                        'keyword' => $entityName,
                        'arrayResultsDoc' => $arrayResultsDoc,
                        'resultSetDocuments' => $arrayTotalMaxMin,
                        'whatToSearch' => $whatToSearch,
                        'source' => $source,
                        'entityName' => $entityName,
                        'orderBy' => $orderBy,
                        'hitsShowed' => $hitsShowed,
                        'meanScore' => $meanScore,
                        'medianScore' => $medianScore,
                    ));
                }
                if($entityType=="Marker"){
                    //We have to make a free search against the intersection of documentswithcompounds with documentswithmarkers
                    //In order to perform the intersection we change the size of the results
                    $elasticaQuery->setSize(1500);
                    $finder = false;
                    $finderDocWithCompounds = $this->container->get('fos_elastica.index.etoxindex2.documentswithcompounds');
                    $finderDocWithMarkers = $this->container->get('fos_elastica.index.etoxindex2.documentswithmarkers');
                    $arrayDocumentsWithCompounds = $finderDocWithCompounds->search($elasticaQuery);
                    $resultSetDocuments=$arrayDocumentsWithCompounds;////// WARNING!! DELETE THIS LINE
                    $arrayDocumentsWithMarkers=$finderDocWithMarkers->search($elasticaQuery);
                    $arrayDocumentsIntersection=$this->performIntersectionArrayDocuments($arrayDocumentsWithCompounds, $arrayDocumentsWithMarkers);
                    $arrayResultsDoc = $paginator
                        ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), 'documents')
                        ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), 'documents')
                        ->paginate($arrayDocumentsIntersection,'documents')
                        ->getResult()
                    ;
                    $hitsShowed=count($arrayDocumentsIntersection);
                    $meanScore=$this->getMmmrScoreFromIntersection($arrayDocumentsIntersection, $orderBy, 'mean');
                    $medianScore=$this->getMmmrScoreFromIntersection($arrayDocumentsIntersection, $orderBy, 'median');
                    //We restore size to its default value
                    $elasticaQuery->setSize($this->container->getParameter('etoxMicrome.total_documents_elasticsearch_retrieval'));
                    //When dealing with withIntersection arrays, we only have this array to get the needed values that we retreive in interface using resultSetArrays... Which are: totalHits, Max. Score, Min. Score
                    //So we implement a function to get all this info inside an arrayTotalMaxMin. Being arrayTotalMaxMin[0]=totalHits, arrayTotalMaxMin[1]=Max.score, arrayTotalMaxMin[2]=Min.score
                    $arrayTotalMaxMin=$this->getTotalMaxMinArray($arrayDocumentsIntersection, $orderBy, $field);
                    return $this->render('FrontendBundle:Search_keyword:indexWithIntersection.html.twig', array(
                        'field' => $field,
                        'entityType' => $entityType,
                        'keyword' => $entityName,
                        'arrayResultsDoc' => $arrayResultsDoc,
                        'resultSetDocuments' => $arrayTotalMaxMin,
                        'whatToSearch' => $whatToSearch,
                        'source' => $source,
                        'entityName' => $entityName,
                        'orderBy' => $orderBy,
                        'hitsShowed' => $hitsShowed,
                        'meanScore' => $meanScore,
                        'medianScore' => $medianScore,
                    ));
                }
            }elseif($whatToSearch=="withCytochromes"){
                if($entityType=="CompoundDict"){
                    //We have to make a free search against the intersection of documentswithcompounds with documentswithcytochromes
                    //In order to perform the intersection we change the size of the results
                    $elasticaQuery->setSize(1500);
                    $finder = false;
                    $documentsInfo = $this->container->get('fos_elastica.index.etoxindex2.documentswithcompounds');
                    $resultSetDocuments = $documentsInfo->search($elasticaQuery);
                    $arrayDocumentsWithCompounds=$resultSetDocuments->getResults();//$results has an array of results objects, data can be obtained by the getSource method

                    $finderDocWithCytochromes = $this->container->get('fos_elastica.index.etoxindex2.documentswithcytochromes');
                    $resultSetCytochromes = $finderDocWithCytochromes->search($elasticaQuery);
                    $arrayDocumentsWithCytochromes=$resultSetCytochromes->getResults();//$results has an array of results objects, data can be obtained by the getSource method

                    $arrayDocumentsIntersection=$this->performIntersectionArrayDocuments($arrayDocumentsWithCompounds, $arrayDocumentsWithCytochromes);
                    $arrayResultsDoc = $paginator
                        ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), 'documents')
                        ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), 'documents')
                        ->paginate($arrayDocumentsIntersection,'documents')
                        ->getResult()
                    ;
                    $hitsShowed=count($arrayDocumentsIntersection);
                    $meanScore=$this->getMmmrScoreFromIntersection($arrayDocumentsIntersection, $orderBy, 'mean');
                    $medianScore=$this->getMmmrScoreFromIntersection($arrayDocumentsIntersection, $orderBy, 'median');
                    //We restore size to its default value
                    $elasticaQuery->setSize($this->container->getParameter('etoxMicrome.total_documents_elasticsearch_retrieval'));
                    //When dealing with withIntersection arrays, we only have this array to get the needed values that we retreive in interface using resultSetArrays... Which are: totalHits, Max. Score, Min. Score
                    //So we implement a function to get all this info inside an arrayTotalMaxMin. Being arrayTotalMaxMin[0]=totalHits, arrayTotalMaxMin[1]=Max.score, arrayTotalMaxMin[2]=Min.score
                    $arrayTotalMaxMin=$this->getTotalMaxMinArray($arrayDocumentsIntersection, $orderBy, $field);
                    return $this->render('FrontendBundle:Search_keyword:indexWithIntersection.html.twig', array(
                        'field' => $field,
                        'entityType' => $entityType,
                        'keyword' => $entityName,
                        'arrayResultsDoc' => $arrayResultsDoc,
                        'resultSetDocuments' => $arrayTotalMaxMin,
                        'whatToSearch' => $whatToSearch,
                        'source' => $source,
                        'entityName' => $entityName,
                        'orderBy' => $orderBy,
                        'hitsShowed' => $hitsShowed,
                        'meanScore' => $meanScore,
                        'medianScore' => $medianScore,
                    ));
                }
            }elseif($whatToSearch=="withMarkers"){
                if($entityType=="CompoundDict"){
                    //We have to make a free search against the intersection of documentswithcompounds with documentswithcytochromes
                    //In order to perform the intersection we change the size of the results
                    $elasticaQuery->setSize(1500);
                    $finder = false;
                    $resultSetAbstracts = false;
                    $arrayResultsAbs =array();
                    $documentsInfo = $this->container->get('fos_elastica.index.etoxindex2.documentswithcompounds');
                    $resultSetDocuments = $documentsInfo->search($elasticaQuery);
                    $arrayDocumentsWithCompounds=$resultSetDocuments->getResults();//$results has an array of results objects, data can be obtained by the getSource method

                    $finderDocWithCytochromes = $this->container->get('fos_elastica.index.etoxindex2.documentswithmarkers');
                    $resultSetCytochromes = $finderDocWithCytochromes->search($elasticaQuery);
                    $arrayDocumentsWithCytochromes=$resultSetCytochromes->getResults();//$results has an array of results objects, data can be obtained by the getSource method

                    $arrayDocumentsIntersection=$this->performIntersectionArrayDocuments($arrayDocumentsWithCompounds, $arrayDocumentsWithCytochromes);
                    $arrayResultsDoc = $paginator
                        ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), 'documents')
                        ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), 'documents')
                        ->paginate($arrayDocumentsIntersection,'documents')
                        ->getResult()
                    ;
                    $hitsShowed=count($arrayDocumentsIntersection);
                    $meanScore=$this->getMmmrScoreFromIntersection($arrayDocumentsIntersection, $orderBy, 'mean');
                    $medianScore=$this->getMmmrScoreFromIntersection($arrayDocumentsIntersection, $orderBy, 'median');
                    //We restore size to its default value
                    $elasticaQuery->setSize($this->container->getParameter('etoxMicrome.total_documents_elasticsearch_retrieval'));
                    //When dealing with withIntersection arrays, we only have this array to get the needed values that we retreive in interface using resultSetArrays... Which are: totalHits, Max. Score, Min. Score
                    //So we implement a function to get all this info inside an arrayTotalMaxMin. Being arrayTotalMaxMin[0]=totalHits, arrayTotalMaxMin[1]=Max.score, arrayTotalMaxMin[2]=Min.score
                    $arrayTotalMaxMin=$this->getTotalMaxMinArray($arrayDocumentsIntersection, $orderBy, $field);
                    return $this->render('FrontendBundle:Search_keyword:indexWithIntersection.html.twig', array(
                        'field' => $field,
                        'entityType' => $entityType,
                        'keyword' => $entityName,
                        'arrayResultsDoc' => $arrayResultsDoc,
                        'resultSetDocuments' => $arrayTotalMaxMin,
                        'whatToSearch' => $whatToSearch,
                        'source' => $source,
                        'entityName' => $entityName,
                        'orderBy' => $orderBy,
                        'hitsShowed' => $hitsShowed,
                        'meanScore' => $meanScore,
                        'medianScore' => $medianScore,
                    ));
                }
            }
            return $this->render('FrontendBundle:Search_keyword:index.html.twig', array(
                'field' => $field,
                'entityType' => $entityType,
                'keyword' => $entityName,
                'arrayResultsAbs' => $arrayResultsAbs,
                'arrayResultsDoc' => $arrayResultsDoc,
                'resultSetAbstracts' => $resultSetAbstracts,
                'resultSetDocuments' => $resultSetDocuments,
                'whatToSearch' => $whatToSearch,
                'source' => $source,
                'entityName' => $entityName,
                'orderBy' => $orderBy,
                'hitsShowed' => $hitsShowed,
                'meanScore' => $meanScore,
                'medianScore' => $medianScore,
                ));
        }elseif($whatToSearch=="compoundsTermsRelations"){
            $curated=$request->query->get('curated');
            if($entityType=="CompoundDict"){
                $entity=$em->getRepository('EtoxMicromeEntityBundle:'.$entityType)->getEntityFromName($entityName);
                if(count($entity)==0){//If there's no results searching with the name, we search with the term....
                    $entity=$em->getRepository('EtoxMicromeEntityBundle:HepatotoxKeyword')->getEntityFromName($entityName);
                    if(count($entity)!=0){
                        //We do query expansion with the term!!!
                        $arrayEntityId=$this->queryExpansion($entity, "HepatotoxKeyword", $whatToSearch);
                        foreach($arrayEntityId as $entityId){
                            $entidad=$em->getRepository('EtoxMicromeEntityBundle:HepatotoxKeyword')->getEntityFromId($entityId);
                            if($entityType=="CompoundDict"){
                                $arrayEntityName[]=($entidad->getName());
                            }elseif($entityType=="Marker"){
                                $arrayEntityName[]=($entidad->getName());
                            }
                        }
                        $arrayEntityName=array_unique($arrayEntityName);
                        $compound2Term2Documents=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getTerm2CompoundRelationsDQL($field, $entityType, $arrayEntityName, $source, $orderBy, $curated)->getResult();
                        //When dealing with withRelations arrays, we only have this array to get the needed values that we retreive in interface using resultSetArrays... Which are: totalHits, Max. Score, Min. Score
                        //So we implement a function to get all this info inside an arrayTotalMaxMin. Being arrayTotalMaxMin[0]=totalHits, arrayTotalMaxMin[1]=Max.score, arrayTotalMaxMin[2]=Min.score
                        $arrayTotalMaxMin=$this->getTotalMaxMinArrayForRelations($compound2Term2Documents, $orderBy, $field);
                        $meanScore=$this->getMmmrScoreFromRelation($compound2Term2Documents, $orderBy, 'mean');
                        $medianScore=$this->getMmmrScoreFromRelation($compound2Term2Documents, $orderBy, 'median');

                        $arrayEntity2Document = $paginator
                                ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), "documents")
                                ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), "documents")
                                ->paginate($em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getTerm2CompoundRelationsDQL($field, $entityType, $arrayEntityName, $source, $orderBy, $curated), 'documents')
                                ->getResult()
                        ;
                        $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummaryFromName($entityName,"Term");
                        $allias=array();
                        return $this->render('FrontendBundle:Search_document:indexRelations.html.twig', array(
                            'field' => $field,
                            'whatToSearch' => $whatToSearch,
                            'entityType' => $entityType,
                            'source' => $source,
                            'entity' => $entity,
                            'entityBackup' => $entityBackup,
                            'arrayEntity2Document' => $arrayEntity2Document,
                            'entityName' => $entityName,
                            'arrayTotalMaxMin' => $arrayTotalMaxMin,
                            'orderBy' => $orderBy,
                            'meanScore' => $meanScore,
                            'medianScore' => $medianScore,
                            'firstRelation' => 'HepatotoxKeyword',
                            'mouseoverSummary' => $mouseoverSummary,
                            'allias' => $allias,
                        ));
                    }
                }
                else{//normal search with compound
                    $arrayEntityId=$this->queryExpansion($entity, $entityType, $whatToSearch);
                    foreach($arrayEntityId as $entityId){
                        $entidad=$em->getRepository('EtoxMicromeEntityBundle:'.$entityType)->getEntityFromId($entityId);
                        if($entityType=="CompoundDict"){
                            $arrayEntityName[]=($entidad->getName());
                        }elseif($entityType=="Marker"){
                            $arrayEntityName[]=($entidad->getName());
                        }

                    }
                    $arrayEntityName=array_unique($arrayEntityName);//We get rid of the duplicates
                }
                //At this point if count(entity)==0 then there is no results:
                if(count($entity)==0){
                    //We don't have entities. We render the template with No results
                    return $this->render('FrontendBundle:Default:no_results.html.twig', array(
                        'field' => $field,
                        'whatToSearch' => $whatToSearch,
                        'entityType' => $entityType,
                        'entity' => $entityBackup,
                        'entityName' => $entityName,
                    ));
                }
                //$arrayEntityName=array();
                //array_push($arrayEntityName, $entityName);
                if($source=="abstract"){
                    $arrayEntity2Abstract = $paginator
                        ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), "abstracts")
                        ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), "abstracts")
                        ->paginate($em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getCompound2Term2DocumentRelationsDQL($field, $entityType, $arrayEntityName), 'abstracts')
                        ->getResult()
                    ;
                    $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummaryFromName($entityName,"CompoundDict");
                    $allias=array();
                    return $this->render('FrontendBundle:Search_document:indexRelations.html.twig', array(
                        'field' => $field,
                        'whatToSearch' => $whatToSearch,
                        'entityType' => $entityType,
                        'source' => $source,
                        'entity' => $entity,
                        'entityBackup' => $entityBackup,
                        'arrayEntity2Document' => $arrayEntity2Abstract,
                        'entityName' => $entityName,
                        'orderBy' => $orderBy,
                        'curated' => $curated,
                    ));
                }
                else{
                    $compound2Term2Documents=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getCompound2TermRelationsDQL($field, $entityType, $arrayEntityName, $source, $orderBy, $curated)->getResult();
                    //When dealing with withRelations arrays, we only have this array to get the needed values that we retreive in interface using resultSetArrays... Which are: totalHits, Max. Score, Min. Score
                    //So we implement a function to get all this info inside an arrayTotalMaxMin. Being arrayTotalMaxMin[0]=totalHits, arrayTotalMaxMin[1]=Max.score, arrayTotalMaxMin[2]=Min.score
                    $arrayTotalMaxMin=$this->getTotalMaxMinArrayForRelations($compound2Term2Documents, $orderBy, $field);
                    $meanScore=$this->getMmmrScoreFromRelation($compound2Term2Documents, $orderBy, 'mean');
                    $medianScore=$this->getMmmrScoreFromRelation($compound2Term2Documents, $orderBy, 'median');
                    $arrayEntity2Document = $paginator
                        ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), "documents")
                        ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), "documents")
                        ->paginate($em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getCompound2TermRelationsDQL($field, $entityType, $arrayEntityName, $source, $orderBy, $curated), 'documents')
                        ->getResult()
                    ;
                    $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummaryFromName($entityName,"CompoundDict");
                    $allias=$em->getRepository('EtoxMicromeEntityBundle:Alias')->getAliasFromName($entityName);
                    return $this->render('FrontendBundle:Search_document:indexRelations.html.twig', array(
                    'field' => $field,
                    'whatToSearch' => $whatToSearch,
                    'entityType' => $entityType,
                    'source' => $source,
                    'entity' => $entity,
                    'entityBackup' => $entityBackup,
                    'arrayEntity2Document' => $arrayEntity2Document,
                    'entityName' => $entityName,
                    'arrayTotalMaxMin' => $arrayTotalMaxMin,
                    'orderBy' => $orderBy,
                    'meanScore' => $meanScore,
                    'medianScore' => $medianScore,
                    'mouseoverSummary' => $mouseoverSummary,
                    'allias' => $allias,
                    'curated' => $curated,
                ));
                }
            }
        }elseif($whatToSearch=="compoundsCytochromesRelations"){
            $curated=$request->query->get('curated');
            if($entityType=="Cytochrome"){
                $entity=$em->getRepository('EtoxMicromeEntityBundle:'.$entityType)->getEntityFromName($entityName);
                if(count($entity)==0){//If there's no results searching with the cytochrome, we search with the compoundName!!....
                    $entity=$em->getRepository('EtoxMicromeEntityBundle:CompoundDict')->getEntityFromName($entityName);
                    if(count($entity)!=0){
                        //We do query expansion with the term!!!
                        $arrayEntityId=$this->queryExpansion($entity, "CompoundDict", $whatToSearch);
                        foreach($arrayEntityId as $entityId){
                            $entidad=$em->getRepository('EtoxMicromeEntityBundle:CompoundDict')->getEntityFromId($entityId);
                            $arrayEntityName[]=($entidad->getName());
                        }
                        $arrayEntityName=array_unique($arrayEntityName);

                        $compound2Cytochrome2Documents=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getCytochrome2CompoundRelationsDQL($field, $entityType, $arrayEntityName, $source, $orderBy, $curated)->getResult();
                        //ld($compound2Cytochrome2Documents);
                            //When dealing with withRelations arrays, we only have this array to get the needed values that we retreive in interface using resultSetArrays... Which are: totalHits, Max. Score, Min. Score
                            //So we implement a function to get all this info inside an arrayTotalMaxMin. Being arrayTotalMaxMin[0]=totalHits, arrayTotalMaxMin[1]=Max.score, arrayTotalMaxMin[2]=Min.score
                        $arrayTotalMaxMin=$this->getTotalMaxMinArrayForRelations($compound2Cytochrome2Documents, $orderBy, $field);
                        $meanScore=$this->getMmmrScoreFromRelation($compound2Cytochrome2Documents, $orderBy, 'mean');
                        $medianScore=$this->getMmmrScoreFromRelation($compound2Cytochrome2Documents, $orderBy, 'median');

                        $arrayEntity2Document = $paginator
                                ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), "documents")
                                ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), "documents")
                                ->paginate($em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getCytochrome2CompoundRelationsDQL($field, $entityType, $arrayEntityName, $source, $orderBy, $curated), 'documents')
                                ->getResult()
                        ;
                        $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummaryFromName($entityName,"CompoundDict");
                        $allias=array();
                        return $this->render('FrontendBundle:Search_document:indexRelations.html.twig', array(
                            'field' => $field,
                            'whatToSearch' => $whatToSearch,
                            'entityType' => $entityType,
                            'source' => $source,
                            'entity' => $entity,
                            'entityBackup' => $entityBackup,
                            'arrayEntity2Document' => $arrayEntity2Document,
                            'entityName' => $entityName,
                            'arrayTotalMaxMin' => $arrayTotalMaxMin,
                            'orderBy' => $orderBy,
                            'meanScore' => $meanScore,
                            'medianScore' => $medianScore,
                            'firstRelation' => 'CompoundDict',
                            'mouseoverSummary' => $mouseoverSummary,
                            'allias' => $allias,
                            'curated' => $curated,
                        ));
                    }
                }
                else{//normal search with cytochrome
                    $arrayEntityId=$this->queryExpansion($entity, $entityType, $whatToSearch);
                    foreach($arrayEntityId as $entityId){
                        $entidad=$em->getRepository('EtoxMicromeEntityBundle:'.$entityType)->getEntityFromId($entityId);
                        $arrayEntityName[]=($entidad->getName());
                    }
                    $arrayEntityName=array_unique($arrayEntityName);//We get rid of the duplicates
                }
                //At this point if count(entity)==0 then there is no results:
                if(count($entity)==0){
                    //We don't have entities. We render the template with No results
                    return $this->render('FrontendBundle:Default:no_results.html.twig', array(
                        'field' => $field,
                        'whatToSearch' => $whatToSearch,
                        'entityType' => $entityType,
                        'entity' => $entityBackup,
                        'entityName' => $entityName,
                    ));
                }
                $compound2Cytochrome2Documents=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getCompound2Cytochrome2RelationsDQL($field, $entityType, $arrayEntityName, $source, $orderBy, $curated)->getResult();
                    //When dealing with withRelations arrays, we only have this array to get the needed values that we retreive in interface using resultSetArrays... Which are: totalHits, Max. Score, Min. Score
                    //So we implement a function to get all this info inside an arrayTotalMaxMin. Being arrayTotalMaxMin[0]=totalHits, arrayTotalMaxMin[1]=Max.score, arrayTotalMaxMin[2]=Min.score
                $arrayTotalMaxMin=$this->getTotalMaxMinArrayForRelations($compound2Cytochrome2Documents, $orderBy, $field);
                $meanScore=$this->getMmmrScoreFromRelation($compound2Cytochrome2Documents, $orderBy, 'mean');
                $medianScore=$this->getMmmrScoreFromRelation($compound2Cytochrome2Documents, $orderBy, 'median');
                $arrayEntity2Document = $paginator
                    ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), "documents")
                    ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), "documents")
                    ->paginate($em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getCompound2Cytochrome2RelationsDQL($field, $entityType, $arrayEntityName, $source, $orderBy, $curated), 'documents')
                    ->getResult()
                ;
                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummaryFromName($entityName,"Cytochrome");
                $allias=array();
                return $this->render('FrontendBundle:Search_document:indexRelations.html.twig', array(
                    'field' => $field,
                    'whatToSearch' => $whatToSearch,
                    'entityType' => $entityType,
                    'source' => $source,
                    'entity' => $entity,
                    'entityBackup' => $entityBackup,
                    'arrayEntity2Document' => $arrayEntity2Document,
                    'entityName' => $entityName,
                    'arrayTotalMaxMin' => $arrayTotalMaxMin,
                    'orderBy' => $orderBy,
                    'meanScore' => $meanScore,
                    'medianScore' => $medianScore,
                    'mouseoverSummary' => $mouseoverSummary,
                    'allias' => $allias,
                    'curated' => $curated,
                ));
            }
        }elseif($whatToSearch=="compoundsMarkersRelations"){
            $curated=$request->query->get('curated');
            if($entityType=="Marker"){
                $entity=$em->getRepository('EtoxMicromeEntityBundle:'.$entityType)->getEntityFromName($entityName);
                if(count($entity)==0){//If there's no results searching with the Marker, we search with the compoundName!!....
                    $entity=$em->getRepository('EtoxMicromeEntityBundle:CompoundDict')->getEntityFromName($entityName);
                    if(count($entity)!=0){
                        //We do query expansion with the term!!!
                        $arrayEntityId=$this->queryExpansion($entity, "CompoundDict", $whatToSearch);
                        foreach($arrayEntityId as $entityId){
                            $entidad=$em->getRepository('EtoxMicromeEntityBundle:CompoundDict')->getEntityFromId($entityId);
                            $arrayEntityName[]=($entidad->getName());
                        }
                        $arrayEntityName=array_unique($arrayEntityName);
                        $compound2Marker2Documents=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getMarker2CompoundRelationsDQL($field, $entityType, $arrayEntityName, $source, $orderBy, $curated)->getResult();
                        //When dealing with withRelations arrays, we only have this array to get the needed values that we retreive in interface using resultSetArrays... Which are: totalHits, Max. Score, Min. Score
                        //So we implement a function to get all this info inside an arrayTotalMaxMin. Being arrayTotalMaxMin[0]=totalHits, arrayTotalMaxMin[1]=Max.score, arrayTotalMaxMin[2]=Min.score
                        $arrayTotalMaxMin=$this->getTotalMaxMinArrayForRelations($compound2Marker2Documents, $orderBy, $field);
                        $meanScore=$this->getMmmrScoreFromRelation($compound2Marker2Documents, $orderBy, 'mean');
                        $medianScore=$this->getMmmrScoreFromRelation($compound2Marker2Documents, $orderBy, 'median');
                        $arrayEntity2Document = $paginator
                                ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), "documents")
                                ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), "documents")
                                ->paginate($em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getMarker2CompoundRelationsDQL($field, $entityType, $arrayEntityName, $source, $orderBy, $curated), 'documents')
                                ->getResult()
                        ;
                        $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummaryFromName($entityName,"CompoundDict");
                        $allias=array();
                        return $this->render('FrontendBundle:Search_document:indexRelations.html.twig', array(
                            'field' => $field,
                            'whatToSearch' => $whatToSearch,
                            'entityType' => $entityType,
                            'source' => $source,
                            'entity' => $entity,
                            'entityBackup' => $entityBackup,
                            'arrayEntity2Document' => $arrayEntity2Document,
                            'entityName' => $entityName,
                            'arrayTotalMaxMin' => $arrayTotalMaxMin,
                            'orderBy' => $orderBy,
                            'meanScore' => $meanScore,
                            'medianScore' => $medianScore,
                            'firstRelation' => 'CompoundDict',
                            'mouseoverSummary' => $mouseoverSummary,
                            'allias' => $allias,
                            'curated' => $curated,
                        ));
                    }
                }
                else{//normal search with cytochrome
                    $arrayEntityId=$this->queryExpansion($entity, $entityType, $whatToSearch);
                    foreach($arrayEntityId as $entityId){
                        $entidad=$em->getRepository('EtoxMicromeEntityBundle:'.$entityType)->getEntityFromId($entityId);
                        $arrayEntityName[]=($entidad->getName());
                    }
                    $arrayEntityName=array_unique($arrayEntityName);//We get rid of the duplicates
                }
                //At this point if count(entity)==0 then there is no results:
                if(count($entity)==0){
                    //We don't have entities. We render the template with No results
                    return $this->render('FrontendBundle:Default:no_results.html.twig', array(
                        'field' => $field,
                        'whatToSearch' => $whatToSearch,
                        'entityType' => $entityType,
                        'entity' => $entityBackup,
                        'entityName' => $entityName,
                    ));
                }
                $compound2Marker2Documents=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getCompound2MarkerRelationsDQL($field, $entityType, $arrayEntityName, $source, $orderBy, $curated)->getResult();
                //When dealing with withRelations arrays, we only have this array to get the needed values that we retreive in interface using resultSetArrays... Which are: totalHits, Max. Score, Min. Score
                //So we implement a function to get all this info inside an arrayTotalMaxMin. Being arrayTotalMaxMin[0]=totalHits, arrayTotalMaxMin[1]=Max.score, arrayTotalMaxMin[2]=Min.score
                $arrayTotalMaxMin=$this->getTotalMaxMinArrayForRelations($compound2Marker2Documents, $orderBy, $field);
                $meanScore=$this->getMmmrScoreFromRelation($compound2Marker2Documents, $orderBy, 'mean');
                $medianScore=$this->getMmmrScoreFromRelation($compound2Marker2Documents, $orderBy, 'median');
                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummaryFromName($entityName,"Marker");
                $allias=array();
                $arrayEntity2Document = $paginator
                    ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), "documents")
                    ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), "documents")
                    ->paginate($em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getCompound2MarkerRelationsDQL($field, $entityType, $arrayEntityName, $source, $orderBy, $curated), 'documents')
                    ->getResult()
                ;
                return $this->render('FrontendBundle:Search_document:indexRelations.html.twig', array(
                    'field' => $field,
                    'whatToSearch' => $whatToSearch,
                    'entityType' => $entityType,
                    'source' => $source,
                    'entity' => $entity,
                    'entityBackup' => $entityBackup,
                    'arrayEntity2Document' => $arrayEntity2Document,
                    'entityName' => $entityName,
                    'arrayTotalMaxMin' => $arrayTotalMaxMin,
                    'orderBy' => $orderBy,
                    'meanScore' => $meanScore,
                    'medianScore' => $medianScore,
                    'mouseoverSummary' => $mouseoverSummary,
                    'allias' => $allias,
                    'curated' => $curated,
                ));
            }
        }
        ////////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////
        //ld($entity);
        if(count($entity)!=0){
            #We have the entityId. We need to do a QUERY EXPANSION depending on the typeOfEntity we have
            $arrayEntityId=$this->queryExpansion($entity, $entityType, $whatToSearch);



            //WARNING!!!! DELETE THIS SLICE AFTER QUERY EXPANSION GETS PRACTICABLE
            $arrayEntityId=array_slice($arrayEntityId, 0, 10);




            //$arrayEntityId=array();
            //array_push($arrayEntityId, $entity);
            //WARNING!! If the query expansion with a CompoundDict doesn't return any entity, we do the expansion with CompoundMesh!!
            //ld($arrayEntityId);
            if (($entityType=="CompoundDict") and (count($arrayEntityId)==1)){
                //In the case of CompoundMesh queryExpansion should return an array of names to translate to an array of ids, trying to avoid mixing CompoundDict ids with CompoundMesh ids inside same arrayEntityId!!!!
                $arrayEntityName=$this->queryExpansion($entity, "CompoundMesh", $whatToSearch);
                //Now we translate arrayEntityName to arrayEntityId
                foreach($arrayEntityName as $entityName){
                    $entityId=$em->getRepository('EtoxMicromeEntityBundle:CompoundDict')->getEntityFromName($entityName)->getId();
                    $arrayEntityId[]=$entityId;
                }
            }
        }else{//We don't have entities. We render the template with No results
            return $this->render('FrontendBundle:Default:no_results.html.twig', array(
                'field' => $field,
                'whatToSearch' => $whatToSearch,
                'entityType' => $entityType,
                'entity' => $entityBackup,
                'entityName' => $entityName,
            ));
        }
        $arrayEntityId=array_unique($arrayEntityId);//We get rid of the duplicates
        if($entityType=="Cytochrome"){
            //We create an array of cytochromes from an array with their enityId
            $arrayEntities=array();
            $arrayNames=array();
            $arrayCanonicals=array();
            foreach ($arrayEntityId as $entityId){
                $cytochrome = $em->getRepository('EtoxMicromeEntityBundle:Cytochrome')->getEntityFromId($entityId);
                $arrayEntities[] = $cytochrome;
                $arrayNames[] = $cytochrome->getName();
                $arrayCanonicals[] = $cytochrome->getCanonical();
            }
            $arrayNames=array_unique($arrayNames);//We get rid of the duplicates
            $arrayCanonicals=array_unique($arrayCanonicals);//We get rid of the duplicates
            $cytochrome2Documents=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Cytochrome2Document')->getCytochrome2DocumentFromFieldDQL($field, $entityType, $arrayNames, $arrayCanonicals, $source, $orderBy)->getResult();
            //When dealing with withRelations arrays, we only have this array to get the needed values that we retreive in interface using resultSetArrays... Which are: totalHits, Max. Score, Min. Score
            //So we implement a function to get all this info inside an arrayTotalMaxMin. Being arrayTotalMaxMin[0]=totalHits, arrayTotalMaxMin[1]=Max.score, arrayTotalMaxMin[2]=Min.score
            $arrayTotalMaxMin=$this->getTotalMaxMinArrayForEntities($cytochrome2Documents, $orderBy, $field);
            $meanScore=$this->getMmmrScoreFromEntities($cytochrome2Documents, $orderBy, 'mean');
            $medianScore=$this->getMmmrScoreFromEntities($cytochrome2Documents, $orderBy, 'median');
            $arrayEntity2Document = $paginator
                ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), "documents")
                ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), "documents")
                ->paginate($em->getRepository('EtoxMicromeEntity2DocumentBundle:Cytochrome2Document')->getCytochrome2DocumentFromFieldDQL($field, $entityType, $arrayNames, $arrayCanonicals, $source, $orderBy), 'documents')
                ->getResult()
            ;
            $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummaryFromName($entityName,"Cytochrome");
            $allias=array();

        }else{
            //For Compounds and Markers
            //In order to relate entities with documents, we have to use the names of the entities instead of their entityId. Therefore we translate $arrayEntityId to $arrayEntityName
            $arrayEntityName=array();
            $em = $this->getDoctrine()->getManager();
            foreach($arrayEntityId as $entityId){
                $entidad=$em->getRepository('EtoxMicromeEntityBundle:'.$entityType)->getEntityFromId($entityId);
                if($entityType=="CompoundDict"){
                    $arrayEntityName[]=($entidad->getName());
                }elseif($entityType=="Marker"){
                    $arrayEntityName[]=($entidad->getName());
                }

            }
            $arrayEntityName=array_unique($arrayEntityName);//We get rid of the duplicates
            //ld($arrayEntityName);
            if($entityType=="CompoundDict" or $entityType=="CompoundMesh"){
                //We search into Abstracts only if we are looking for Compounds



                /*//Set query for elasticsearch solution
                $elasticaQueryString  = new \Elastica\Query\QueryString();
                $entityName=$arrayEntityName[0];
                ld($entityName);
                //'And' or 'Or' default : 'Or'
                $elasticaQueryString->setDefaultOperator('AND');
                $elasticaQueryString->setQuery($entityName);
                // Create the actual search object with some data.
                $elasticaQuery  = new \Elastica\Query();
                $elasticaQuery->setSort(array('hepval' => array('order' => 'desc')));
                $elasticaQuery->setQuery($elasticaQueryString);
                //Search on the index.
                $elasticaQuery->setSize($this->container->getParameter('etoxMicrome.total_documents_elasticsearch_retrieval'));
                ld($elasticaQuery);
                $finder = $this->container->get('fos_elastica.finder.etoxindex2.entity2document');
                $arrayResult = $finder->find($elasticaQuery);
                ldd(count($arrayResult));

                $arrayEntity2Document=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntity2DocumentElastica($field, $entityType, $arrayEntityName, $orderBy)->getResult();
                ldd($arrayEntity2Document);
                */
                if (in_array($source, $arraySourcesDocuments)){
                    $compound2Documents=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntity2DocumentFromFieldDQL($field, $entityType, $arrayEntityName, $source, $orderBy)->getResult();
                    //ld(count($compound2Documents));
                    /*$entity2documentTest=$compound2Documents[0];
                    ld($entity2documentTest);
                    $curation=$entity2documentTest->getCuration();
                    ld($curation);
                    $curation++;
                    ld($curation);
                    $entity2documentTest->setCuration($curation);
                    $em->persist($entity2documentTest);
                    $em->flush();
                    ldd($message);
                    */
                    ///Temporary function to get rid of the duplicated entries. Duplicates should be removed from the entity2document table itself
                    //$compound2Documents=$this->getRidOfDuplicatedEntries($compound2Documents);

                    //When dealing with withRelations arrays, we only have this array to get the needed values that we retreive in interface using resultSetArrays... Which are: totalHits, Max. Score, Min. Score
                    //So we implement a function to get all this info inside an arrayTotalMaxMin. Being arrayTotalMaxMin[0]=totalHits, arrayTotalMaxMin[1]=Max.score, arrayTotalMaxMin[2]=Min.score
                    $arrayTotalMaxMin=$this->getTotalMaxMinArrayForEntities($compound2Documents, $orderBy, $field);
                    $meanScore=$this->getMmmrScoreFromEntities($compound2Documents, $orderBy, 'mean');
                    $medianScore=$this->getMmmrScoreFromEntities($compound2Documents, $orderBy, 'median');
                    $arrayEntity2Document = $paginator
                        ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), "documents")
                        ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), "documents")
                        ->paginate($em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntity2DocumentFromFieldDQL($field, $entityType, $arrayEntityName, $source, $orderBy), 'documents')
                        ->getResult()
                    ;
                    //ld(count($arrayEntity2Document));
                    if($whatToSearch=="name"){
                        $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummaryFromName($entityName,"CompoundDict");
                        $allias=$em->getRepository('EtoxMicromeEntityBundle:Alias')->getAliasFromName($entityName);
                    }elseif($whatToSearch=="id"){
                        $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummaryFromName($entity->getName(),"CompoundDict");
                        $allias=$em->getRepository('EtoxMicromeEntityBundle:Alias')->getAliasFromName($entity->getName());
                    }
                    else{
                        $mouseoverSummary="";
                        $allias=array();
                    }

                    $arrayTanimotos=array();

                    if ($entityType=="CompoundDict"){
	                	$arrayTanimotos=$em->getRepository('EtoxMicromeEntityBundle:TanimotoValues')->getCompoundsWithTanimotos($entity->getId());
	                    //$arrayTanimotos=$em->getRepository('EtoxMicromeEntityBundle:TanimotoValues')->sortArrayByTanimoto($arrayTanimotos);
                    }
                    return $this->render('FrontendBundle:Search_document:index.html.twig', array(
                        'field' => $field,
                        'whatToSearch' => $whatToSearch,
                        'entityType' => $entityType,
                        'source' => $source,
                        'entity' => $entity,
                        'entityBackup' => $entityBackup,
                        'arrayEntity2Document' => $arrayEntity2Document,
                        'entityName' => $entityName,
                        'arrayTotalMaxMin' => $arrayTotalMaxMin,
                        'orderBy' => $orderBy,
                        'meanScore' => $meanScore,
                        'medianScore' => $medianScore,
                        'mouseoverSummary' => $mouseoverSummary,
                        'allias' => $allias,
                        'arrayTanimotos' => $arrayTanimotos,

                    ));
                }
                if (in_array($source, $arraySourcesAbstracts)){
                    $compound2Abstracts=$em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntity2AbstractFromFieldDQL($field, "CompoundMesh", $arrayEntityName, $orderBy)->getResult();
                    //When dealing with withRelations arrays, we only have this array to get the needed values that we retreive in interface using resultSetArrays... Which are: totalHits, Max. Score, Min. Score
                    //So we implement a function to get all this info inside an arrayTotalMaxMin. Being arrayTotalMaxMin[0]=totalHits, arrayTotalMaxMin[1]=Max.score, arrayTotalMaxMin[2]=Min.score
                    $arrayTotalMaxMin=$this->getTotalMaxMinArrayForEntities($compound2Abstracts, $orderBy, $field);
                    $meanScore=$this->getMmmrScoreFromEntities($compound2Abstracts, $orderBy, 'mean');
                    $medianScore=$this->getMmmrScoreFromEntities($compound2Abstracts, $orderBy, 'median');
                    $arrayEntity2Abstract = $paginator
                        ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), "abstracts")
                        ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), "abstracts")
                        ->paginate($em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntity2AbstractFromFieldDQL($field, "CompoundMesh", $arrayEntityName, $orderBy), 'abstracts')
                        ->getResult()
                    ;
                    return $this->render('FrontendBundle:Search_document:index.html.twig', array(
                        'field' => $field,
                        'whatToSearch' => $whatToSearch,
                        'entityType' => $entityType,
                        'source' => $source,
                        'entity' => $entity,
                        'entityBackup' => $entityBackup,
                        'arrayEntity2Abstract' => $arrayEntity2Abstract,
                        'entityName' => $entityName,
                        'arrayTotalMaxMin' => $arrayTotalMaxMin,
                        'orderBy' => $orderBy,
                        'meanScore' => $meanScore,
                        'medianScore' => $medianScore,
                    ));
                }


            }else{//Neither Compounds nor Cytochromes
                //We just search into Documents
                if($entityType=="Marker"){
                    $marker2Documents=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntity2DocumentFromFieldDQL($field, $entityType, $arrayEntityName, $source, $orderBy)->getResult();
                    //ld(count($marker2Documents));
                    //When dealing with withRelations arrays, we only have this array to get the needed values that we retreive in interface using resultSetArrays... Which are: totalHits, Max. Score, Min. Score
                    //So we implement a function to get all this info inside an arrayTotalMaxMin. Being arrayTotalMaxMin[0]=totalHits, arrayTotalMaxMin[1]=Max.score, arrayTotalMaxMin[2]=Min.score
                    $arrayTotalMaxMin=$this->getTotalMaxMinArrayForEntities($marker2Documents, $orderBy, $field);
                    $meanScore=$this->getMmmrScoreFromEntities($marker2Documents, $orderBy, 'mean');
                    $medianScore=$this->getMmmrScoreFromEntities($marker2Documents, $orderBy, 'median');
                    $arrayEntity2Document = $paginator
                    ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), "documents")
                    ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), "documents")
                    ->paginate($em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntity2DocumentFromFieldDQL($field, $entityType, $arrayEntityName, $source, $orderBy), 'documents')
                    ->getResult()
                ;
                }
                $mouseoverSummary=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntitySummaryFromName($entityName,"Marker");
                $allias=array();
                return $this->render('FrontendBundle:Search_document:index.html.twig', array(
                    'field' => $field,
                    'whatToSearch' => $whatToSearch,
                    'entityType' => $entityType,
                    'source' => $source,
                    'entity' => $entity,
                    'entityBackup' => $entityBackup,
                    'arrayEntity2Document' => $arrayEntity2Document,
                    'entityName' => $entityName,
                    'arrayTotalMaxMin' => $arrayTotalMaxMin,
                    'orderBy' => $orderBy,
                    'meanScore' => $meanScore,
                    'medianScore' => $medianScore,
                    'mouseoverSummary' => $mouseoverSummary,
                    'allias' => $allias,
                ));
            }
        }
        return $this->render('FrontendBundle:Search_document:index.html.twig', array(
        'field' => $field,
        'whatToSearch' => $whatToSearch,
        'entityType' => $entityType,
        'source' => $source,
        'entity' => $entity,
        'entityBackup' => $entityBackup,
        'arrayEntity2Document' => $arrayEntity2Document,
        'entityName' => $entityName,
        'arrayTotalMaxMin' => $arrayTotalMaxMin,
        'orderBy' => $orderBy,
        'meanScore' => $meanScore,
        'medianScore' => $medianScore,
        'mouseoverSummary' => $mouseoverSummary,
        'allias' => $allias,
        ));
    }

    public function searchKeywordAction($whatToSearch, $source, $keyword)
    {
        if($whatToSearch != "endpoints"){
            $orderBy = $this->container->getParameter('etoxMicrome.default_orderby'); //{"score","patternCount","ruleScore","termScore"}
        }else{
            $orderBy=$this->getValToSearch($source);
        }
        return($this->searchKeywordOrderByAction($whatToSearch, $source, $keyword, $orderBy));
    }

    public function searchKeywordOrderByAction($whatToSearch, $source, $keyword, $orderBy)
    {
        if (isset($_GET['page'])) {
            $page=$_GET['page'];
        }else {
            $page=null;
        }
        if (isset($_GET['page'])) {
            $page=$_GET['page'];
        }else {
            $page=null;
        }
        $paginator = $this->get('ideup.simple_paginator');
        if($whatToSearch != "endpoints"){
            $field = $this->container->getParameter('etoxMicrome.default_field');//{"hepatotoxicity","embryotoxicity", etc...}
        }else{
            $field = $source;
        }

        $valToSearch=$this->getValToSearch($field);//"i.e hepval, embval... etc"
        $orderBy=$this->getOrderBy($orderBy, $valToSearch);
        $entityType= "keyword";//{"specie","compound","enzyme","protein","cyp","mutation","goterm","keyword","marker"}
        //$whatToSearch can be "any", "withCompounds", "withCytochromes" or "withMarkers". We'll search inside differente Type depending on this parameter
        $elasticaQueryString  = new \Elastica\Query\QueryString();
        //'And' or 'Or' default : 'Or'
        $elasticaQueryString->setDefaultOperator('AND');
        $elasticaQueryString->setQuery($keyword);

        // Create the actual search object with some data.
        $elasticaQuery  = new \Elastica\Query();
        if($source!="all" and $source!="abstract" and $whatToSearch!="endpoints"){
            $elasticaFilterBool = new \Elastica\Filter\Bool();
            $filter1 = new \Elastica\Filter\Term();
            $filter1->setTerm('kind', $source);
            $elasticaFilterBool->addMust($filter1);
            $elasticaQuery->setFilter($elasticaFilterBool);
        }
        if($orderBy=="hepval"){
            $elasticaQuery->setSort(array('hepval' => array('order' => 'desc')));
        }elseif($orderBy=="patternCount"){
            $elasticaQuery->setSort(array('patternCount' => array('order' => 'desc')));
        }elseif($orderBy=="ruleScore"){
            $elasticaQuery->setSort(array('ruleScore' => array('order' => 'desc')));
        }elseif($orderBy=="nephroval"){
            $elasticaQuery->setSort(array('nephroval' => array('order' => 'desc')));
        }elseif($orderBy=="cardioval"){
            $elasticaQuery->setSort(array('cardioval' => array('order' => 'desc')));
        }elseif($orderBy=="thyroval"){
            $elasticaQuery->setSort(array('thyroval' => array('order' => 'desc')));
        }elseif($orderBy=="phosphoval"){
            $elasticaQuery->setSort(array('phosphoval' => array('order' => 'asc')));
        }elseif($orderBy=="hepTermNormScore"){
            $elasticaQuery->setSort(array('hepTermNormScore' => array('order' => 'desc')));
        }elseif($orderBy=="hepTermVarScore"){
            $elasticaQuery->setSort(array('hepTermVarScore' => array('order' => 'desc')));
        }elseif($orderBy=="svmConfidence"){
            $elasticaQuery->setSort(array('svmConfidence' => array('order' => 'desc')));
        }

        $elasticaQuery->setQuery($elasticaQueryString);
        //Search on the index.
        $elasticaQuery->setSize($this->container->getParameter('etoxMicrome.total_documents_elasticsearch_retrieval'));
        if($whatToSearch=="any"){
            //Depending on the source, we will search into documents or abstracts...
            $message="entra en any";
            if ($source=="abstract"){
                $abstractsInfo = $this->container->get('fos_elastica.index.etoxindex2.abstracts');/** To get resultSet to get values for summary**/
                $resultSetAbstracts = $abstractsInfo->search($elasticaQuery);
                $arrayAbstracts=$resultSetAbstracts->getResults();
                $arrayResultsAbs = $paginator
                    ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), 'abstracts')
                    ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), 'abstracts')
                    ->paginate($arrayAbstracts,'abstracts')
                    ->getResult()
                ;
                $hitsShowed=count($arrayAbstracts);
                $meanScore=$this->getMmmrScore($resultSetAbstracts, $orderBy, 'mean');
                $medianScore=$this->getMmmrScore($resultSetAbstracts, $orderBy, 'median');
                $rangeScore=$this->getMmmrScore($resultSetAbstracts, $orderBy, 'range');
                $finderDoc=false;
                $resultSetDocuments = array();
                $arrayResultsDoc = array();

            }else{ //For "pubmed", "fulltext", "nda", "epar" and "all"
                $documentsInfo = $this->container->get('fos_elastica.index.etoxindex2.documents');/** To get resultSet to get values for summary**/
                $resultSetDocuments = $documentsInfo->search($elasticaQuery);
                $arrayResults=$resultSetDocuments->getResults();
                /*
                $contador=1;
                foreach ($arrayResults as $result){
                    if ($contador<11){
                        ld($result);
                        $contador++;
                    }
                }
                */
                $meanScore=$this->getMmmrScore($resultSetDocuments, $orderBy, 'mean');
                $medianScore=$this->getMmmrScore($resultSetDocuments, $orderBy, 'median');
                $rangeScore=$this->getMmmrScore($resultSetDocuments, $orderBy, 'range');
                $arrayDocuments=$resultSetDocuments->getResults();//$results has an array of results objects, data can be obtained by the getSource method
                $hitsShowed=count($arrayDocuments);
                $arrayResultsDoc = $paginator
                    ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), 'documents')
                    ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), 'documents')
                    ->paginate($arrayDocuments,'documents')
                    ->getResult()
                ;
                //ld($arrayResultsDoc);
                $resultSetAbstracts = array();
                $arrayResultsAbs = array();
            }


        }elseif($whatToSearch=="withCompounds"){
            //Depending on the source, we will search into documents or abstracts...
            if ($source=="abstract"){
                $abstractsInfo = $this->container->get('fos_elastica.index.etoxindex2.abstractswithcompounds');/** To get resultSet to get values for summary**/
                $resultSetAbstracts = $abstractsInfo->search($elasticaQuery);
                $arrayAbstracts=$resultSetAbstracts->getResults();
                $arrayResultsAbs = $paginator
                    ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), 'abstracts')
                    ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), 'abstracts')
                    ->paginate($arrayAbstracts,'abstracts')
                    ->getResult()
                ;
                $finderDoc=false;
                $resultSetDocuments = array();
                $arrayResultsDoc = array();
                $hitsShowed=count($arrayAbstracts);
                $meanScore=$this->getMmmrScore($resultSetAbstracts, $orderBy, 'mean');
                $medianScore=$this->getMmmrScore($resultSetAbstracts, $orderBy, 'median');
                $rangeScore=$this->getMmmrScore($resultSetAbstracts, $orderBy, 'range');


            }else{ //For "pubmed", "fulltext", "nda", "epar" and "all"
                $documentsInfo = $this->container->get('fos_elastica.index.etoxindex2.documentswithcompounds');/** To get resultSet to get values for summary**/
                $resultSetDocuments = $documentsInfo->search($elasticaQuery);
                $arrayDocuments=$resultSetDocuments->getResults();//$results has an array of results objects, data can be obtained by the getSource method
                $arrayResultsDoc = $paginator
                    ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), 'documents')
                    ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), 'documents')
                    ->paginate($arrayDocuments,'documents')
                    ->getResult()
                ;
                /*$finderDoc = $this->container->get('fos_elastica.finder.etoxindex2.documentswithcompounds');
                $arrayDocuments=$finderDoc->find($elasticaQuery);
                ldd($arrayDocuments);
                $arrayResultsDoc = $paginator
                    ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), 'documents')
                    ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), 'documents')
                    ->paginate($arrayDocuments,'documents')
                    ->getResult()
                ;
                $documentsInfo = $this->container->get('fos_elastica.index.etoxindex2.documentswithcompounds');/** To get resultSet to get values for summary**/
                //$resultSetDocuments = $documentsInfo->search($elasticaQuery);
                $finder=false;
                $resultSetAbstracts = array();
                $arrayResultsAbs = array();
                $hitsShowed=count($arrayDocuments);
                $meanScore=$this->getMmmrScore($resultSetDocuments, $orderBy, 'mean');
                $medianScore=$this->getMmmrScore($resultSetDocuments, $orderBy, 'median');
                $rangeScore=$this->getMmmrScore($resultSetDocuments, $orderBy, 'range');
            }
        }elseif($whatToSearch=="withCytochromes"){
            //We only search inside documents
            $finder = false;
            $resultSetAbstracts = array();//There is no abstractsWithCytochromes nor abstractsWithMarkers information in the database
            $arrayResultsAbs=array();
            $documentsInfo = $this->container->get('fos_elastica.index.etoxindex2.documentswithcytochromes');/** To get resultSet to get values for summary**/
            $resultSetDocuments = $documentsInfo->search($elasticaQuery);
            $arrayDocuments=$resultSetDocuments->getResults();//$results has an array of results objects, data can be obtained by the getSource method
            $arrayResultsDoc = $paginator
                ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), 'documents')
                ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), 'documents')
                ->paginate($arrayDocuments,'documents')
                ->getResult()
            ;
            $hitsShowed=count($arrayDocuments);
            $meanScore=$this->getMmmrScore($resultSetDocuments, $orderBy, 'mean');
            $medianScore=$this->getMmmrScore($resultSetDocuments, $orderBy, 'median');
            $rangeScore=$this->getMmmrScore($resultSetDocuments, $orderBy, 'range');

        }elseif($whatToSearch=="withMarkers"){
            //We only search inside documents
            $finder = false;
            $resultSetAbstracts = array();//There is no abstractsWithCytochromes nor abstractsWithMarkers information in the database
            $arrayResultsAbs=array();
            $documentsInfo = $this->container->get('fos_elastica.index.etoxindex2.documentswithmarkers');/** To get resultSet to get values for summary**/
            $resultSetDocuments = $documentsInfo->search($elasticaQuery);
            $arrayDocuments=$resultSetDocuments->getResults();//$results has an array of results objects, data can be obtained by the getSource method
            $arrayResultsDoc = $paginator
                ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), 'documents')
                ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), 'documents')
                ->paginate($arrayDocuments,'documents')
                ->getResult()
            ;
            $hitsShowed=count($arrayDocuments);
            $meanScore=$this->getMmmrScore($resultSetDocuments, $orderBy, 'mean');
            $medianScore=$this->getMmmrScore($resultSetDocuments, $orderBy, 'median');
            $rangeScore=$this->getMmmrScore($resultSetDocuments, $orderBy, 'range');

        }if($whatToSearch=="endpoints"){
            //We only search inside documents
            $finder = false;
            $resultSetAbstracts = array();//There is no abstractsWithCytochromes nor abstractsWithMarkers information in the database
            $arrayResultsAbs=array();
            $documentsInfo = $this->container->get('fos_elastica.index.etoxindex2.documents');/** To get resultSet to get values for summary**/
            $resultSetDocuments = $documentsInfo->search($elasticaQuery);
            $arrayResults=$resultSetDocuments->getResults();
            /*
            $contador=1;
            foreach ($arrayResults as $result){
                if ($contador<11){
                    ld($result);
                    $contador++;
                }
            }
            */
            $meanScore=$this->getMmmrScore($resultSetDocuments, $orderBy, 'mean');
            $medianScore=$this->getMmmrScore($resultSetDocuments, $orderBy, 'median');
            $rangeScore=$this->getMmmrScore($resultSetDocuments, $orderBy, 'range');
            $arrayDocuments=$resultSetDocuments->getResults();//$results has an array of results objects, data can be obtained by the getSource method
            $hitsShowed=count($arrayDocuments);
            $arrayResultsDoc = $paginator
                ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), 'documents')
                ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), 'documents')
                ->paginate($arrayDocuments,'documents')
                ->getResult()
            ;

            $entityName=$keyword;
            return $this->render('FrontendBundle:Search_keyword:index_endpoints.html.twig', array(
                'field' => $field,
                'entityType' => $entityType,
                'source' => $source,
                'keyword' => $keyword,
                'arrayResultsAbs' => $arrayResultsAbs,
                'arrayResultsDoc' => $arrayResultsDoc,
                'resultSetAbstracts' => $resultSetAbstracts,
                'resultSetDocuments' => $resultSetDocuments,
                'whatToSearch' => $whatToSearch,
                'entityName' => $entityName,
                'orderBy' => $orderBy,
                'hitsShowed' => $hitsShowed,
                'meanScore' => $meanScore,
                'medianScore' => $medianScore,
                'rangeScore' => $rangeScore,
                ));


        }

        //$paginator->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'));
        //$paginator->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'));
        $entityName=$keyword;
        return $this->render('FrontendBundle:Search_keyword:index.html.twig', array(
            'field' => $field,
            'entityType' => $entityType,
            'source' => $source,
            'keyword' => $keyword,
            'arrayResultsAbs' => $arrayResultsAbs,
            'arrayResultsDoc' => $arrayResultsDoc,
            'resultSetAbstracts' => $resultSetAbstracts,
            'resultSetDocuments' => $resultSetDocuments,
            'whatToSearch' => $whatToSearch,
            'entityName' => $entityName,
            'orderBy' => $orderBy,
            'hitsShowed' => $hitsShowed,
            'meanScore' => $meanScore,
            'medianScore' => $medianScore,
            'rangeScore' => $rangeScore,
            ));
    }
    public function embryotoxicityAction()
    {
        return $this->render('FrontendBundle:Search:hepatotoxicity.html.twig', array(
            'searchby' => "embryotoxicity"
            ));
    }

    public function download_curated_termrelationsAction()
    {
        $filename=$this->exportCuratedTermRelations();

    }
}
