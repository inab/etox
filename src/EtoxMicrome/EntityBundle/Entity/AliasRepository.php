<?php

namespace EtoxMicrome\EntityBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * AliasRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AliasRepository extends EntityRepository
{
    public function getAliasFromName($name)
    {
        $message="Inside getAliasFromName";
        $query = $this->_em->createQuery("
            SELECT a
            FROM EtoxMicromeEntityBundle:Alias a
            WHERE lower(a.name) = :name
        ");
        $query->setParameter('name', strtolower($name));
        //$alias=$query->getSingleResult();
        $alias=$query->getResult();
-       $aliases=$alias[0]->getAlias();
        //$aliases=$alias->getAlias();
        //We return all the Compounds with the InChI given.
        return $aliases;
    }
}
