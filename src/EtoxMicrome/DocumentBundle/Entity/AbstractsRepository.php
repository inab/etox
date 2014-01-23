<?php

namespace EtoxMicrome\DocumentBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * AbstractsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AbstractsRepository extends EntityRepository
{
    public function getAbstractFromAbstractWith($abstract)
    {
        //Function to search all the entities involved in a particular sentence in order to highlight them
        $pmid=$abstract->getPmid();
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT a
            FROM EtoxMicromeDocumentBundle:Abstracts a
            WHERE a.pmid = :pmid
        ');
        $consulta->setParameter('pmid', $pmid);
        $consulta->setMaxResults(1);
        return $consulta->execute();
    }
}
