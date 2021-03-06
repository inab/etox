<?php

namespace EtoxMicrome\EntityBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CompoundMeshRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CompoundMeshRepository extends EntityRepository
{
    public function getEntityFromId($entityId)
    {
        $message="Inside getEntityIdFromId at CompoundMeshRepository";
        $query = $this->_em->createQuery("
            SELECT c
            FROM EtoxMicromeEntityBundle:CompoundMesh c
            WHERE c.id= :entityId
        ");
        $query->setParameter('entityId', $entityId);
        $compound=$query->getResult();
        if(count($compound)!=1){
            $errorMessage="There are more than one entityName for '$entityName'";
            ld($errorMessage);
        }
        //We return all the Compounds with the entityName given. By now we supose its only one entity!!!
        $entity=$compound[0];
        return $entity;
    }

    public function getEntityFromName($entityName)
    {
        $message="Inside getEntityFromName at CompoundMeshRepository";
        $query = $this->_em->createQuery("
            SELECT c
            FROM EtoxMicromeEntityBundle:CompoundMesh c
            WHERE LOWER(c.name)= :entityName
        ");
        $query->setParameter('entityName', strtolower($entityName));
        $compound=$query->getResult();
        if(count($compound)==0){
            $errorMessage="There is no entity with that name ($entityName)";
            return "";
        }
        if(count($compound)!=1){
            $errorMessage="There are more than one entityName for '$entityName'";
            ld($errorMessage);
        }
        //We return all the CompoundMesh with the entityName given. By now we supose its only one entity!!!
        $entity=$compound[0];
        return $entity;
    }
    public function getNameFromGenericField($key, $value, $arrayEntityId)
    {
        $message="Inside getEntityIdFromName at CompoundMeshRepository";
        $query = $this->_em->createQuery("
            SELECT c
            FROM EtoxMicromeEntityBundle:CompoundMesh c
            WHERE  LOWER(c.$key)= :value
        ");
        $query->setParameter('value', strtolower($value));
        $compounds=$query->getResult();
        if(count($compounds)==0){
            return $arrayEntityId;
        }
        else{
            $errorMessage="There are at least one CompoundMesh for $key = $value";
            //ld($errorMessage);
            foreach($compounds as $compound){
                $arrayEntityId[]=$compound->getName();
            }
        }
        //We return all the Compounds with the entityName given. By now we supose its only one entity!!!
        return $arrayEntityId;
    }

    public function getNamesFromGenericField($key, $value){
        $query = $this->_em->createQuery("
            SELECT c
            FROM EtoxMicromeEntityBundle:CompoundMesh c
            WHERE LOWER(c.$key) = :value
        ");

        $query->setParameter('value', strtolower($value));
        //$query->setMaxResults(1);
        $compounds=$query->getResult();
        $arrayNames=array();
        foreach($compounds as $compound){
            array_push($arrayNames, $compound->getName());
        }
        return $arrayNames;
    }
}
