<?php

namespace EtoxMicrome\EntityBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * MolecularMechanismRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MolecularMechanismRepository extends EntityRepository
{
    public function getEntityFromId($entityId)
    {
        $message="Inside getEntityFromId at MolecularMechanismRepository";
        $query = $this->_em->createQuery("
            SELECT a
            FROM EtoxMicromeEntityBundle:MolecularMechanism a
            WHERE a.id= :entityId
        ");
        $query->setParameter('entityId', $entityId);
        $molecularMechanism=$query->getResult();
        if(count($molecularMechanism)==0){
            $errorMessage="There is no entity with that name ('$entityName')";
            ldd($errorMessage);
        }
        if(count($molecularMechanism)!=1){
            $errorMessage="There are more than one entityName for '$entityName'";
            ldd($errorMessage);
        }
        //We return all the Compounds with the entityName given. By now we supose its only one entity!!!
        $entity=$molecularMechanism[0];
        return $entity;
    }

    public function getEntityFromName($entityName)
    {
        $message="Inside getEntityFromName at MolecularMechanismRepository";
        $query = $this->_em->createQuery("
            SELECT a
            FROM EtoxMicromeEntityBundle:MolecularMechanism a
            WHERE a.name= :entityName
        ");
        $query->setParameter('entityName', $entityName);
        $molecularMechanism=$query->getResult();
        if(count($molecularMechanism)==0){
            $errorMessage="There is no entity with that name ($entityName)";
            ldd($errorMessage);
        }
        if(count($molecularMechanism)!=1){
            $errorMessage="There are more than one entityName for '$entityName'";
            ldd($errorMessage);
        }
        //We return all the CompoundDict with the entityName given. By now we supose its only one entity!!!
        $entity=$molecularMechanism[0];
        return $entity;
    }
}
