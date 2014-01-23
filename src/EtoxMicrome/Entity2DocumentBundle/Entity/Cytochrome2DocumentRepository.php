<?php

namespace EtoxMicrome\Entity2DocumentBundle\Entity;

use EtoxMicrome\Entity2AbstractBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Cytochrome2DocumentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Cytochrome2DocumentRepository extends EntityRepository
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

    public function getCytochrome2DocumentFromField($field, $typeOfEntity, $arrayNames, $arrayCanonicals)
    {
        return $this->getCytochrome2DocumentFromFieldDQL($field, $typeOfEntity, $arrayNames, $arrayCanonicals)->getResult();
    }

    public function getCytochrome2DocumentFromFieldDQL($field, $entityType, $arrayNames, $arrayCanonicals)
    {
        $valToSearch=$this->getValToSearch($field);//"i.e hepval, embval... etc"
        //We have to create a query that searchs all over the entityIds inside the $arrayEntityId
        $sql="SELECT e2d,d
            FROM EtoxMicromeEntity2DocumentBundle:Cytochrome2Document e2d
            JOIN e2d.document d
            WHERE e2d.cypsMention IN (:arrayNames)
            OR e2d.cypsCanonical IN (:arrayCanonicals)
            AND d.$valToSearch is not NULL
            ORDER BY d.$valToSearch desc
            ";
        //ld($sql);
        $query = $this->_em->createQuery($sql);
        $query->setParameter("arrayNames", $arrayNames);
        $query->setParameter("arrayCanonicals", $arrayCanonicals);
        return $query;

    }

    public function findCytochrome2DocumentFromDocument($document)
    {
        //Function to search all the entities involved in a particular sentence in order to highlight them
        $documentId=$document->getId();

        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT c2d
            FROM EtoxMicromeEntity2DocumentBundle:Cytochrome2Document c2d
            WHERE c2d.document = :documentId
        ');
        $consulta->setParameter('documentId', $documentId);
        return $consulta->execute();
    }
}