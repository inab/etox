<?php

namespace EtoxMicrome\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntityRanking
 *
 * @ORM\Table(indexes={ @ORM\Index(name="entityRanking_entity_index", columns={"entityId"}) })
 * @ORM\Entity(repositoryClass="EtoxMicrome\EntityBundle\Entity\EntityRankingRepository")
 */
class EntityRanking
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="entityId", type="string", length=255)
     */
    private $entityId;

    /**
     * @var float
     *
     * @ORM\Column(name="meanHepval", type="float")
     */
    private $meanHepval;

    /**
     * @var float
     *
     * @ORM\Column(name="sumHepval", type="float")
     */
    private $sumHepval;

    /**
     * @var integer
     *
     * @ORM\Column(name="numDocuments", type="integer")
     */
    private $numDocuments;

    /**
     * @var integer
     *
     * @ORM\Column(name="numRelArticles", type="integer")
     */
    private $numRelArticles;

    /**
     * @var float
     *
     * @ORM\Column(name="meanRelHepval", type="float")
     */
    private $meanRelHepval;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set entityId
     *
     * @param string $entityId
     * @return EntityRanking
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;

        return $this;
    }

    /**
     * Get entityId
     *
     * @return string
     */
    public function getEntityId()
    {
        return $this->entityId;
    }

    /**
     * Set meanHepval
     *
     * @param float $meanHepval
     * @return EntityRanking
     */
    public function setMeanHepval($meanHepval)
    {
        $this->meanHepval = $meanHepval;

        return $this;
    }

    /**
     * Get meanHepval
     *
     * @return float
     */
    public function getMeanHepval()
    {
        return $this->meanHepval;
    }

    /**
     * Set sumHepval
     *
     * @param float $sumHepval
     * @return EntityRanking
     */
    public function setSumHepval($sumHepval)
    {
        $this->sumHepval = $sumHepval;

        return $this;
    }

    /**
     * Get sumHepval
     *
     * @return float
     */
    public function getSumHepval()
    {
        return $this->sumHepval;
    }

    /**
     * Set numDocuments
     *
     * @param integer $numDocuments
     * @return EntityRanking
     */
    public function setNumDocuments($numDocuments)
    {
        $this->numDocuments = $numDocuments;

        return $this;
    }

    /**
     * Get numDocuments
     *
     * @return integer
     */
    public function getNumDocuments()
    {
        return $this->numDocuments;
    }

    /**
     * Set numRelArticles
     *
     * @param integer $numRelArticles
     * @return EntityRanking
     */
    public function setNumRelArticles($numRelArticles)
    {
        $this->numRelArticles = $numRelArticles;

        return $this;
    }

    /**
     * Get numRelArticles
     *
     * @return integer
     */
    public function getNumRelArticles()
    {
        return $this->numRelArticles;
    }

    /**
     * Set meanRelHepval
     *
     * @param float $meanRelHepval
     * @return EntityRanking
     */
    public function setMeanRelHepval($meanRelHepval)
    {
        $this->meanRelHepval = $meanRelHepval;

        return $this;
    }

    /**
     * Get meanRelHepval
     *
     * @return float
     */
    public function getMeanRelHepval()
    {
        return $this->meanRelHepval;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return EntityRanking
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return EntityRanking
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }
}
