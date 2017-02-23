<?php

namespace EtoxMicrome\EntityBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * DrugbankRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DrugbankRepository extends EntityRepository
{
    public function getNameFromDrugbankId($drugbankId, $nameCompound)
    {
        $message="Inside getEntityFromDrugbankId";
        $query = $this->_em->createQuery("
            SELECT d
            FROM EtoxMicromeEntityBundle:Drugbank d
            WHERE d.drugbankid= :drugbankId
        ");

        $query->setParameter('drugbankId', $drugbankId);
        $arrayCompounds=$query->getResult();
        if(count($arrayCompounds)==0){
            $errorMessage="There is no drugbank entity with that DrugBank ID ($drugbankId)";
            return $nameCompound;
        }
        if(count($arrayCompounds)!=1){
            $errorMessage="There are more than one DrugBank entity that DrugBank ID ($drugbankId)";
            ldd($errorMessage);
        }
        //We return all the CompoundDict with the entityName given. By now we supose its only one entity!!!
        $entity=$arrayCompounds[0];
        return $entity->getDrugbankname();
    }
    public function getDrugbanks($initial)
    {
        $message="Inside getDrugbanks";
        $query = $this->_em->createQuery("
            SELECT d
            FROM EtoxMicromeEntityBundle:Drugbank d
            WHERE d.drugbankname like :initial
            OR d.drugbankname like  :initialUpper
            order by d.drugbankname
        ");

        $query->setParameter('initial', $initial."%");
        $initialUpper=strtoupper($initial);
        $query->setParameter('initialUpper', $initialUpper."%");
        $arrayDrugbanks=$query->getResult();
        /*if(count($arrayDrugbanks)==0){
            $errorMessage="There is no drugbank entity with that initial ($initial)";
            $arrayDrugbanks=array();
            return $arrayDrugbanks;
        }*/
        //We return all the CompoundDict with the entityName given. By now we supose its only one entity!!!
        return $arrayDrugbanks;
    }

}
