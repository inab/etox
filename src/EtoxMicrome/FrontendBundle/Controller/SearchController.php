<?php

namespace EtoxMicrome\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;


class SearchController extends Controller
{
    public function getValToSearch($field)
    {
        switch ($field) {
            case "hepatotoxicity":
                $valToSearch="hepval";
                break;
            case "cardiotoxicity":
                $valToSearch="cardval";
                break;
            case "nephrotoxicity":
                $valToSearch="nephval";
                break;
            case "phospholipidosis":
                $valToSearch="phosval";
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
                    $score=$entity2Abstract->getAbstracts()->getHepval();
                }elseif($className=="Entity2Document"){
                    $score=$entity2Document->getDocument()->getHepval();
                }
                break;
            case "cardval":
                if($className=="Entity2Abstract"){
                    $score=$entity2Abstract->getAbstracts()->getCardval();
                }elseif($className=="Entity2Document"){
                    $score=$entity2Document->getDocument()->getCardval();
                }
                break;
            case "nephval":
                if($className=="Entity2Abstract"){
                    $score=$entity2Abstract->getAbstracts()->getNephval();
                }elseif($className=="Entity2Document"){
                    $score=$entity2Document->getDocument()->getNephval();
                }
                break;
            case "phosval":
                if($className=="Entity2Abstract"){
                    $score=$entity2Abstract->getAbstracts()->getPhosval();
                }elseif($className=="Entity2Document"){
                    $score=$entity2Document->getDocument()->getPhosval();
                }
                break;
        }
        return $score;
    }

    public function performIntersectionArrayDocuments($arrayDocuments_1, $arrayDocuments_2)
    {
        //This function receives two arrays of objects with different types, documentsWithCompounds and documentsWithCytochromes
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
            array_push($arrayIds, $document->getSentenceId());
        }
        //Now we iterate over the first array and if an id exists inside $arrayIds it will take part of the intersection array
        foreach($arrayDocuments_1 as $document){
            $documentId=$document->getSentenceId();
            if(in_array($documentId, $arrayIds)){
                array_push($intersectionArray, $document);
            }
        }
        return $intersectionArray;
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
            //we have to search for names with this same entityId
            $dictionaryIds['name']=$entity->getName();

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
Evidences found in Sentences:(Output fields:\t\"#registry\"\t\"Sentence text\"\t\"Score\")\n
***********************************************************************************************\n";
        fwrite($fp, $line);
        foreach($arrayEntity2Document as $entity2Document){
            $line="$count\t".$entity2Document->getDocument()->getText()."\t";
            $valToSearch=$this->getValToSearch($field);
            $score=$this->getPropertyScore($entity2Document, $valToSearch);
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
Evidences found in Sentences:(Output fields:\t\"#registry\"\t\"Sentence text\"\t\"Score\")\n
***********************************************************************************************\n";
        fwrite($fp, $line);
        foreach($arrayEntity2Document as $entity2Document){
            $line="$count\t".$entity2Document->getDocument()->getText()."\t";
            $valToSearch=$this->getValToSearch($field);
            $score=$this->getPropertyScore($entity2Document, $valToSearch);
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

    public function exportFunction($field, $whatToSearch, $entityType, $entityName){
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
            ldd($messageCytochrome);
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

            $arrayEntity2Document = $em->getRepository('EtoxMicromeEntity2DocumentBundle:Cytochrome2Document')->getCytochrome2DocumentFromField($field, $entityType, $arrayNames, $arrayCanonicals);
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
                $arrayEntity2Abstract = $em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getEntity2AbstractFromField($field, "CompoundMesh", $arrayEntityName);
                $arrayEntity2Document = $em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntity2DocumentFromField($field, $entityType, $arrayEntityName);


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
        if ($download==true){
            $filename=$this->exportFunction($field, $whatToSearch, $entityType, $entityName);
            return $this->render('FrontendBundle:Default:download_file.html.twig', array(
            'field' => $field,
            'whatToSearch' => $whatToSearch,
            'entityType' => $entityType,
            'entity' => $entityName,
            'filename' => $filename,
            'orderBy' => $orderBy,
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
            //Search on the index.
            $elasticaQuery->setSize($this->container->getParameter('etoxMicrome.total_documents_elasticsearch_retrieval'));
            if($whatToSearch=="any"){
                if($entityType=="CompoundDict"){
                    //We have to make a free search against elastica documentsWithCompounds and abstractsWithCompounds index
                    $finder = $this->container->get('fos_elastica.finder.etoxindex.abstractsWithCompounds');
                    $finderDoc = $this->container->get('fos_elastica.finder.etoxindex.documentsWithCompounds');
                    /** We get resultSet to get values for summary**/
                    $abstractsInfo = $this->container->get('fos_elastica.index.etoxindex.abstractsWithCompounds');
                    $resultSetAbstracts = $abstractsInfo->search($elasticaQuery);
                    $arrayAbstracts=$finder->find($elasticaQuery);
                    $arrayResultsAbs = $paginator
                        ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), 'abstracts')
                        ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), 'abstracts')
                        ->paginate($arrayAbstracts,'abstracts')
                        ->getResult()
                    ;
                    $documentsInfo = $this->container->get('fos_elastica.index.etoxindex.documentsWithCompounds');
                    $resultSetDocuments = $documentsInfo->search($elasticaQuery);
                    $arrayDocuments=$finderDoc->find($elasticaQuery);
                    $arrayResultsDoc = $paginator
                        ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), 'documents')
                        ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), 'documents')
                        ->paginate($arrayDocuments,'documents')
                        ->getResult()
                    ;
                }
                if($entityType=="Cytochrome"){
                    //We have to make a free search against elastica documentsWithCytochromes indexes
                    $finder = false;
                    $finderDoc = $this->container->get('fos_elastica.finder.etoxindex.documentsWithCytochromes');
                    $resultSetAbstracts = false;
                    $arrayResultsAbs =array();
                    $documentsInfo = $this->container->get('fos_elastica.index.etoxindex.documentsWithCytochromes');
                    $resultSetDocuments = $documentsInfo->search($elasticaQuery);
                    $arrayDocuments=$finderDoc->find($elasticaQuery);
                    $arrayResultsDoc = $paginator
                        ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), 'documents')
                        ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), 'documents')
                        ->paginate($arrayDocuments,'documents')
                        ->getResult()
                    ;
                }
                if($entityType=="Marker"){
                    //We have to make a free search against elastica documentsWithMarkers indexes
                    $finder = false;
                    $finderDoc = $this->container->get('fos_elastica.finder.etoxindex.documentsWithMarkers');
                    $resultSetAbstracts = false;
                    $arrayResultsAbs =array();
                    $documentsInfo = $this->container->get('fos_elastica.index.etoxindex.documentsWithMarkers');
                    $resultSetDocuments = $documentsInfo->search($elasticaQuery);
                    $arrayDocuments=$finderDoc->find($elasticaQuery);
                    $arrayResultsDoc = $paginator
                        ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), 'documents')
                        ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), 'documents')
                        ->paginate($arrayDocuments,'documents')
                        ->getResult()
                    ;
                }
            }elseif($whatToSearch=="withCompounds"){
                if($entityType=="Cytochrome"){
                    //We have to make a free search against the intersection of documentsWithCompounds with documentsWithCytochromes
                    //In order to perform the intersection we change the size of the results
                    $elasticaQuery->setSize(1500);
                    $finder = false;
                    $finderDocWithCompounds = $this->container->get('fos_elastica.finder.etoxindex.documentsWithCompounds');
                    $finderDocWithCytochromes = $this->container->get('fos_elastica.finder.etoxindex.documentsWithCytochromes');
                    $resultSetAbstracts = false;
                    $arrayResultsAbs =array();
                    $documentsInfo = $this->container->get('fos_elastica.index.etoxindex.documentsWithCompounds');
                    $resultSetDocuments = $documentsInfo->search($elasticaQuery);
                    $arrayDocumentsWithCompounds=$finderDocWithCompounds->find($elasticaQuery);
                    $arrayDocumentsWithCytochromes=$finderDocWithCytochromes->find($elasticaQuery);
                    $arrayDocumentsIntersection=$this->performIntersectionArrayDocuments($arrayDocumentsWithCompounds, $arrayDocumentsWithCytochromes);
                    $arrayResultsDoc = $paginator
                        ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), 'documents')
                        ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), 'documents')
                        ->paginate($arrayDocumentsIntersection,'documents')
                        ->getResult()
                    ;
                    //We restore size to its default value
                    $elasticaQuery->setSize($this->container->getParameter('etoxMicrome.total_documents_elasticsearch_retrieval'));
                }
                if($entityType=="Marker"){
                    //We have to make a free search against the intersection of documentsWithCompounds with documentsWithMarkers
                    //In order to perform the intersection we change the size of the results
                    $elasticaQuery->setSize(1500);
                    $finder = false;
                    $finderDocWithCompounds = $this->container->get('fos_elastica.finder.etoxindex.documentsWithCompounds');
                    $finderDocWithMarkers = $this->container->get('fos_elastica.finder.etoxindex.documentsWithMarkers');
                    $resultSetAbstracts = false;
                    $arrayResultsAbs =array();
                    $documentsInfo = $this->container->get('fos_elastica.index.etoxindex.documentsWithMarkers');
                    $resultSetDocuments = $documentsInfo->search($elasticaQuery);
                    $arrayDocumentsWithCompounds=$finderDocWithCompounds->find($elasticaQuery);
                    $arrayDocumentsWithMarkers=$finderDocWithMarkers->find($elasticaQuery);
                    $arrayDocumentsIntersection=$this->performIntersectionArrayDocuments($arrayDocumentsWithCompounds, $arrayDocumentsWithMarkers);
                    $arrayResultsDoc = $paginator
                        ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), 'documents')
                        ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), 'documents')
                        ->paginate($arrayDocumentsIntersection,'documents')
                        ->getResult()
                    ;
                    //We restore size to its default value
                    $elasticaQuery->setSize($this->container->getParameter('etoxMicrome.total_documents_elasticsearch_retrieval'));
                }
            }elseif($whatToSearch=="withCytochromes"){
                if($entityType=="CompoundDict"){
                    //We have to make a free search against the intersection of documentsWithCompounds with documentsWithCytochromes
                    //In order to perform the intersection we change the size of the results
                    $elasticaQuery->setSize(1500);
                    $finder = false;
                    $finderDocWithCompounds = $this->container->get('fos_elastica.finder.etoxindex.documentsWithCompounds');
                    $finderDocWithCytochromes = $this->container->get('fos_elastica.finder.etoxindex.documentsWithCytochromes');
                    $resultSetAbstracts = false;
                    $arrayResultsAbs =array();
                    $documentsInfo = $this->container->get('fos_elastica.index.etoxindex.documentsWithCompounds');
                    $resultSetDocuments = $documentsInfo->search($elasticaQuery);
                    $arrayDocumentsWithCompounds=$finderDocWithCompounds->find($elasticaQuery);
                    $arrayDocumentsWithCytochromes=$finderDocWithCytochromes->find($elasticaQuery);
                    $arrayDocumentsIntersection=$this->performIntersectionArrayDocuments($arrayDocumentsWithCompounds, $arrayDocumentsWithCytochromes);
                    $arrayResultsDoc = $paginator
                        ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), 'documents')
                        ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), 'documents')
                        ->paginate($arrayDocumentsIntersection,'documents')
                        ->getResult()
                    ;
                    //We restore size to its default value
                    $elasticaQuery->setSize($this->container->getParameter('etoxMicrome.total_documents_elasticsearch_retrieval'));
                }
            }elseif($whatToSearch=="withMarkers"){
                if($entityType=="CompoundDict"){
                    //We have to make a free search against the intersection of documentsWithCompounds with documentsWithCytochromes
                    //In order to perform the intersection we change the size of the results
                    $elasticaQuery->setSize(1500);
                    $finder = false;
                    $finderDocWithCompounds = $this->container->get('fos_elastica.finder.etoxindex.documentsWithCompounds');
                    $finderDocWithMarkers = $this->container->get('fos_elastica.finder.etoxindex.documentsWithMarkers');
                    $resultSetAbstracts = false;
                    $arrayResultsAbs =array();
                    $documentsInfo = $this->container->get('fos_elastica.index.etoxindex.documentsWithCompounds');
                    $resultSetDocuments = $documentsInfo->search($elasticaQuery);
                    $arrayDocumentsWithCompounds=$finderDocWithCompounds->find($elasticaQuery);
                    $arrayDocumentsWithMarkers=$finderDocWithMarkers->find($elasticaQuery);
                    $arrayDocumentsIntersection=$this->performIntersectionArrayDocuments($arrayDocumentsWithCompounds, $arrayDocumentsWithMarkers);
                    $arrayResultsDoc = $paginator
                        ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), 'documents')
                        ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), 'documents')
                        ->paginate($arrayDocumentsIntersection,'documents')
                        ->getResult()
                    ;
                    //We restore size to its default value
                    $elasticaQuery->setSize($this->container->getParameter('etoxMicrome.total_documents_elasticsearch_retrieval'));
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
                ));
        }elseif($whatToSearch=="compoundsTermsRelations"){
            if($entityType=="CompoundDict"){
                $entity=$em->getRepository('EtoxMicromeEntityBundle:'.$entityType)->getEntityFromName($entityName);
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
                $arrayEntityName=array();
                array_push($arrayEntityName, $entityName);
                $arrayEntity2Document = $paginator
                    ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), "documents")
                    ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), "documents")
                    ->paginate($em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getCompound2Term2DocumentFromFieldDQL($field, $entityType, $arrayEntityName), 'documents')
                    ->getResult()
                ;
                $arrayEntity2Abstract = $paginator
                    ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), "abstracts")
                    ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), "abstracts")
                    ->paginate($em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getCompound2Term2DocumentFromFieldDQL($field, "CompoundMesh", $arrayEntityName), 'abstracts')
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
                    'arrayEntity2Abstract' => $arrayEntity2Abstract,
                    'entityName' => $entityName,
                ));
            }
        }elseif($whatToSearch=="compoundsCytochromesRelations"){
            if($entityType=="Cytochrome"){
                $entity=$em->getRepository('EtoxMicromeEntityBundle:'.$entityType)->getEntityFromName($entityName);
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
                $arrayEntityName=array();
                array_push($arrayEntityName, $entityName);
                $arrayEntity2Document = $paginator
                    ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), "documents")
                    ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), "documents")
                    ->paginate($em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getCompound2Cytochrome2DocumentFromFieldDQL($field, $entityType, $arrayEntityName), 'documents')
                    ->getResult()
                ;
                $arrayEntity2Abstract = $paginator
                    ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), "abstracts")
                    ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), "abstracts")
                    ->paginate($em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getCompound2Cytochrome2DocumentFromFieldDQL($field, "CompoundMesh", $arrayEntityName), 'abstracts')
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
                    'arrayEntity2Abstract' => $arrayEntity2Abstract,
                    'entityName' => $entityName,
                ));
            }
        }elseif($whatToSearch=="compoundsMarkersRelations"){
            if($entityType=="Marker"){

                $entity=$em->getRepository('EtoxMicromeEntityBundle:'.$entityType)->getEntityFromName($entityName);
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
                $arrayEntityName=array();
                array_push($arrayEntityName, $entityName);
                $arrayEntity2Document = $paginator
                    ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), "documents")
                    ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), "documents")
                    ->paginate($em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getCompound2Marker2DocumentFromFieldDQL($field, $entityType, $arrayEntityName), 'documents')
                    ->getResult()
                ;
                $arrayEntity2Abstract = $paginator
                    ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), "abstracts")
                    ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), "abstracts")
                    ->paginate($em->getRepository('EtoxMicromeEntity2AbstractBundle:Entity2Abstract')->getCompound2Marker2DocumentFromFieldDQL($field, "CompoundMesh", $arrayEntityName), 'abstracts')
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
                    'arrayEntity2Abstract' => $arrayEntity2Abstract,
                    'entityName' => $entityName,
                ));
            }
        }
        ////////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////
        if(count($entity)!=0){
            #We have the entityId. We need to do a QUERY EXPANSION depending on the typeOfEntity we have

            $arrayEntityId=$this->queryExpansion($entity, $entityType, $whatToSearch);
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

            $arrayEntity2Document = $paginator->paginate($em->getRepository('EtoxMicromeEntity2DocumentBundle:Cytochrome2Document')->getCytochrome2DocumentFromFieldDQL($field, $entityType, $arrayNames, $arrayCanonicals, $source, $orderBy))->getResult();

        }else
        { //For Compounds and Markers
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
                $finder = $this->container->get('fos_elastica.finder.etoxindex.entity2document');
                $arrayResult = $finder->find($elasticaQuery);
                ldd(count($arrayResult));

                $arrayEntity2Document=$em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntity2DocumentElastica($field, $entityType, $arrayEntityName, $orderBy)->getResult();
                ldd($arrayEntity2Document);
                */
                if (in_array($source, $arraySourcesDocuments)){
                    $arrayEntity2Document = $paginator
                        ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), "documents")
                        ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), "documents")
                        ->paginate($em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntity2DocumentFromFieldDQL($field, $entityType, $arrayEntityName, $source, $orderBy), 'documents')
                        ->getResult()
                    ;
                    return $this->render('FrontendBundle:Search_document:index.html.twig', array(
                        'field' => $field,
                        'whatToSearch' => $whatToSearch,
                        'entityType' => $entityType,
                        'source' => $source,
                        'entity' => $entity,
                        'entityBackup' => $entityBackup,
                        'arrayEntity2Document' => $arrayEntity2Document,
                        'entityName' => $entityName,
                        'orderBy' => $orderBy,
                    ));
                }
                if (in_array($source, $arraySourcesAbstracts)){
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
                        'orderBy' => $orderBy,
                    ));
                }


            }else{//Neither Compounds nor Cytochromes
                //We just search into Documents
                if($entityType=="Marker"){
                    $arrayEntity2Document = $paginator
                    ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), "documents")
                    ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), "documents")
                    ->paginate($em->getRepository('EtoxMicromeEntity2DocumentBundle:Entity2Document')->getEntity2DocumentFromFieldDQL($field, $entityType, $arrayEntityName, $source, $orderBy), 'documents')
                    ->getResult()
                ;
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
                    'orderBy' => $orderBy,
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
        'orderBy' => $orderBy,
        ));
    }

    public function searchKeywordAction($whatToSearch, $source, $keyword)
    {
        $orderBy = $this->container->getParameter('etoxMicrome.default_orderby'); //{"score","patternCount","ruleScore","termScore"}
        return($this->searchKeywordOrderByAction($whatToSearch, $source, $keyword, $orderBy));
    }

    public function searchKeywordOrderByAction($whatToSearch, $source, $keyword, $orderBy)
    {
        $message="llega aqui";
        if (isset($_GET['page'])) {
            $page=$_GET['page'];
        }else {
            $page=null;
        }
        $message="llega aqui";
        if (isset($_GET['page'])) {
            $page=$_GET['page'];
        }else {
            $page=null;
        }

        $field = $this->container->getParameter('etoxMicrome.default_field');//{"hepatotoxicity","embryotoxicity", etc...}
        $searchInto=$this->container->getParameter('etoxMicrome.default_searchInto');//{"abstract","document"}
        $entityType= "keyword";//{"specie","compound","enzyme","protein","cyp","mutation","goterm","keyword","marker"}
        //$whatToSearch can be "any", "withCompounds", "withCytochromes" or "withMarkers". We'll search inside differente Type depending on this parameter
        if($whatToSearch=="any"){
            $finder = $this->container->get('fos_elastica.finder.etoxindex.abstracts');
            $finderDoc = $this->container->get('fos_elastica.finder.etoxindex.documents');
            $abstractsInfo = $this->container->get('fos_elastica.index.etoxindex.abstracts');/** To get resultSet to get values for summary**/
            $documentsInfo = $this->container->get('fos_elastica.index.etoxindex.documents');/** To get resultSet to get values for summary**/
        }elseif($whatToSearch=="withCompounds"){
            $finder = $this->container->get('fos_elastica.finder.etoxindex.abstractsWithCompounds');
            $finderDoc = $this->container->get('fos_elastica.finder.etoxindex.documentsWithCompounds');
            $abstractsInfo = $this->container->get('fos_elastica.index.etoxindex.abstractsWithCompounds');/** To get resultSet to get values for summary**/
            $documentsInfo = $this->container->get('fos_elastica.index.etoxindex.documentsWithCompounds');/** To get resultSet to get values for summary**/
        }elseif($whatToSearch=="withCytochromes"){
            $finder = false;
            $finderDoc = $this->container->get('fos_elastica.finder.etoxindex.documentsWithCytochromes');
            $documentsInfo = $this->container->get('fos_elastica.index.etoxindex.documentsWithCytochromes');/** To get resultSet to get values for summary**/
        }elseif($whatToSearch=="withMarkers"){
            $finder = false;
            $finderDoc = $this->container->get('fos_elastica.finder.etoxindex.documentsWithMarkers');
            $documentsInfo = $this->container->get('fos_elastica.index.etoxindex.documentsWithMarkers');/** To get resultSet to get values for summary**/
        }

        $paginator = $this->get('ideup.simple_paginator');
        //$paginator->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'));
        //$paginator->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'));

        $elasticaQueryString  = new \Elastica\Query\QueryString();
        //'And' or 'Or' default : 'Or'
        $elasticaQueryString->setDefaultOperator('AND');
        $elasticaQueryString->setQuery($keyword);

        // Create the actual search object with some data.
        $elasticaQuery  = new \Elastica\Query();
        $elasticaQuery->setSort(array('hepval' => array('order' => 'desc')));
        $elasticaQuery->setQuery($elasticaQueryString);
        //Search on the index.
        $elasticaQuery->setSize($this->container->getParameter('etoxMicrome.total_documents_elasticsearch_retrieval'));

        /** var Elastica\ResultSet */
        if($whatToSearch=="withCytochromes" or $whatToSearch=="withMarkers"){
            $resultSetAbstracts = array();//There is no abstractsWithCytochromes nor abstractsWithMarkers information in the database
        }else{
            $resultSetAbstracts = $abstractsInfo->search($elasticaQuery);
        }

        $resultSetDocuments = $documentsInfo->search($elasticaQuery);
        if($whatToSearch=="withCytochromes" or $whatToSearch=="withMarkers"){
            $arrayResultsAbs=array();//There is no abstractsWithCytochromes nor abstractsWithMarkers information in the database
        }else{
            $arrayAbstracts=$finder->find($elasticaQuery);
            $arrayResultsAbs = $paginator
                ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), 'abstracts')
                ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), 'abstracts')
                ->paginate($arrayAbstracts,'abstracts')
                ->getResult()
            ;

        }

        $arrayDocuments=$finderDoc->find($elasticaQuery);
        $arrayResultsDoc = $paginator
            ->setMaxPagerItems($this->container->getParameter('etoxMicrome.number_of_pages'), 'documents')
            ->setItemsPerPage($this->container->getParameter('etoxMicrome.evidences_per_page'), 'documents')
            ->paginate($arrayDocuments,'documents')
            ->getResult()
        ;
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
            ));
    }
    public function embryotoxicityAction()
    {
        return $this->render('FrontendBundle:Search:hepatotoxicity.html.twig', array(
            'searchby' => "embryotoxicity"
            ));
    }

}
