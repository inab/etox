<?php

namespace EtoxMicrome\EntityBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * CompoundDictRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CompoundDictRepository extends EntityRepository
{
    public function getEntityFromId($entityId)
    {
        $message="Inside getEntityIdFromName at CompoundDictRepository";
        $query = $this->_em->createQuery("
            SELECT c
            FROM EtoxMicromeEntityBundle:CompoundDict c
            WHERE c.id= :entityId
        ");
        $query->setParameter('entityId', $entityId);
        $compound=$query->getResult();
        if(count($compound)==0){
            $errorMessage="There is no entity with that name ($entityName)";
            //ld($errorMessage);
            $entity=array();
            return $entity;
        }
        if(count($compound)!=1){
            $errorMessage="There are more than one entityName for '$entityName'";
            //ldd($errorMessage);
        }
        //We return all the Compounds with the entityName given. By now we supose its only one entity!!!
        $entity=$compound[0];
        return $entity;
    }

    public function getEntityFromName($entityName)
    {
        $message="Inside getEntityIdFromName at CompoundDictRepository";

        $query = $this->_em->createQuery("
            SELECT c
            FROM EtoxMicromeEntityBundle:CompoundDict c
            WHERE c.name= :entityName
        ");

        $query->setParameter('entityName', $entityName);
        $compound=$query->getResult();
        if(count($compound)==0){
            $errorMessage="There is no entity with that name ($entityName)";
            //ld($errorMessage);
            $entity=array();
            return $entity;
        }
        if(count($compound)!=1){
            $errorMessage="There are more than one entityName for '$entityName'";
            //ld($errorMessage);
        }
        //We return all the CompoundDict with the entityName given. By now we supose its only one entity!!!
        $entity=$compound[0];
        return $entity;
    }

    public function getEntityFromInchi($inchi)
    {
        $message="Inside getEntityFromInchi at CompoundDictRepository";
        $inchi="InChI=".$inchi;//We recover the full InChI name to search inside the compounddict table
        $query = $this->_em->createQuery("
            SELECT c
            FROM EtoxMicromeEntityBundle:CompoundDict c
            WHERE c.inChi= :inchi
        ");
        $query->setParameter('inchi', $inchi);
        $arrayCompounds=$query->getResult();
        //We return all the Compounds with the InChI given.
        return $arrayCompounds;
    }

    public function getEntityFromDrugbankId($drugBank)
    {
        $message="Inside getEntityFromDrugbankId at CompoundDictRepository";
        $query = $this->_em->createQuery("
            SELECT c
            FROM EtoxMicromeEntityBundle:CompoundDict c
            WHERE c.drugBank= :drugBank
        ");
        $query->setParameter('drugBank', $drugBank);
        $arrayCompounds=$query->getResult();
        //We return all the Compounds with the InChI given.
        return $arrayCompounds;
    }

    public function getIdFromGenericField($key, $value, $arrayEntityId)
    {
        $message="Inside getEntityIdFromName at CompoundDictRepository";
        $query = $this->_em->createQuery("
            SELECT c
            FROM EtoxMicromeEntityBundle:CompoundDict c
            WHERE c.$key= :value
        ");
        $query->setParameter('value', $value);
        $compounds=$query->getResult();
        if(count($compounds)==0){
            return $arrayEntityId;
        }
        else{
            $errorMessage="There are at least one Compound for $key = $value";
            //ld($errorMessage);
            foreach($compounds as $compound){
                $arrayEntityId[]=$compound->getId();
            }
        }
        //We return all the Compounds with the entityName given. By now we supose its only one entity!!!
        return $arrayEntityId;
    }

    public function searchEntityGivenAnId($entityId)
    {
        $message="Inside searchEntityGivenAnId at CompoundDictRepository";
        $query = $this->_em->createQuery("
            SELECT c
            FROM EtoxMicromeEntityBundle:CompoundDict c
            WHERE c.chemIdPlus = :entityId
            OR c.chebi = :entityId
            OR c.casRegistryNumber = :entityId
            OR c.pubChemCompound = :entityId
            OR c.pubChemSubstance = :entityId
            OR c.drugBank = :entityId
            OR c.humanMetabolome = :entityId
            OR c.keggCompound = :entityId
            OR c.keggDrug = :entityId
            OR c.mesh = :entityId

        ");
        $query->setParameter('entityId', $entityId);
        $compound=$query->getResult();
        if(count($compound)==0){
            $errorMessage="There is no entity with that entityId ($entityId)";
            //ld($errorMessage);
            $entity=array();
            return $entity;
        }
        elseif(count($compound)!=1){
            $errorMessage="There are more than one entityId for '$entityId'";
            $entity=$compound[0];
            //ld($errorMessage);
        }
        //We return only one entity. Later on we will make the query expansion so we will collect all of them
        return $compound[0];
    }

    public function searchEntityGivenAnStructureText($structureText)
    {
        $message="Inside searchEntityGivenAnStructureText at CompoundDictRepository";
        //ldd($message);
        $query = $this->_em->createQuery("
            SELECT c
            FROM EtoxMicromeEntityBundle:CompoundDict c
            WHERE c.inChi = :structureText
            OR c.smile = :structureText
        ");
        $query->setParameter('structureText', $structureText);
        $compound=$query->getResult();
        if(count($compound)==0){
            $errorMessage="There is no entity with that structure ($structureText)";
            $entity=array();
        }
        elseif(count($compound)!=1){
            $errorMessage="There are more than one entities for '$structureText'";
            $entity=$compound[0];
            //ld($errorMessage);
        }
        //We return only one entity. Later on we will make the query expansion so we will collect all of them

        return $entity;
    }

    public function getCompoundsSummary($id, $initial)
    {
        if($initial=="0"){
            $query = $this->_em->createQuery("
                SELECT c
                FROM EtoxMicromeEntityBundle:CompoundDict c
                WHERE (c.$id !='' AND c.name like '1%')
                OR (c.$id !='' AND c.name like '2%')
                OR (c.$id !='' AND c.name like '3%')
                OR (c.$id !='' AND c.name like '4%')
                OR (c.$id !='' AND c.name like '5%')
                OR (c.$id !='' AND c.name like '6%')
                OR (c.$id !='' AND c.name like '7%')
                OR (c.$id !='' AND c.name like '8%')
                OR (c.$id !='' AND c.name like '9%')
                ORDER BY c.name
            ");
        }elseif($initial=="-"){
            $query = $this->_em->createQuery("
                SELECT c
                FROM EtoxMicromeEntityBundle:CompoundDict c
                WHERE (c.$id !='' AND c.name like '+%')
                OR (c.$id !='' AND c.name like '-%')
                OR (c.$id !='' AND c.name like '\(%')
                OR (c.$id !='' AND c.name like '\)%')
                ORDER BY c.name asc
            ");
        }else{
            $initialUpper=strtoupper($initial);
            $query = $this->_em->createQuery("
                SELECT c
                FROM EtoxMicromeEntityBundle:CompoundDict c
                WHERE (c.$id !='' AND c.name like  :initial)
                OR (c.$id !='' AND c.name like  :initialUpper)
            ");
            $query->setParameter("initial", $initial."%");
            $query->setParameter("initialUpper", $initialUpper."%");
        }

        $arrayCompounds=$query->getResult();
        return $arrayCompounds;
    }
}
