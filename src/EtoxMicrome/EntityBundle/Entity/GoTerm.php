<?php

namespace EtoxMicrome\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GoTerm
 *
 * @ORM\Table(indexes={@ORM\Index(name="entity_index", columns={"entityId"}),@ORM\Index(name="name_index", columns={"name"}) })
 * @ORM\Entity(repositoryClass="EtoxMicrome\EntityBundle\Entity\GoTermRepository")
 */
class GoTerm
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="go_class", type="string", length=255)
     */
    private $goClass;

    /**
     * @var string
     *
     * @ORM\Column(name="nametype", type="string", length=255)
     */
    private $nametype;

    /**
     * @var string
     *
     * @ORM\Column(name="manual_validation", type="string", length=255)
     */
    private $manualValidation;

    /**
     * @var integer
     *
     * @ORM\Column(name="depth", type="integer")
     */
    private $depth;

    /**
     * @var float
     *
     * @ORM\Column(name="score_sum", type="float")
     */
    private $scoreSum;

    /**
     * @var float
     *
     * @ORM\Column(name="score_mean", type="float")
     */
    private $scoreMean;

    /**
     * @var float
     *
     * @ORM\Column(name="score_fract", type="float")
     */
    private $scoreFract;

    /**
     * @var float
     *
     * @ORM\Column(name="score_annot", type="float")
     */
    private $scoreAnnot;

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
     * @return GoTerm
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
     * Set name
     *
     * @param string $name
     * @return GoTerm
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set goClass
     *
     * @param string $goClass
     * @return GoTerm
     */
    public function setGoClass($goClass)
    {
        $this->goClass = $goClass;

        return $this;
    }

    /**
     * Get goClass
     *
     * @return string
     */
    public function getGoClass()
    {
        return $this->goClass;
    }

    /**
     * Set nametype
     *
     * @param string $nametype
     * @return GoTerm
     */
    public function setNametype($nametype)
    {
        $this->nametype = $nametype;

        return $this;
    }

    /**
     * Get nametype
     *
     * @return string
     */
    public function getNametype()
    {
        return $this->nametype;
    }

    /**
     * Set manualValidation
     *
     * @param string $manualValidation
     * @return GoTerm
     */
    public function setManualValidation($manualValidation)
    {
        $this->manualValidation = $manualValidation;

        return $this;
    }

    /**
     * Get manualValidation
     *
     * @return string
     */
    public function getManualValidation()
    {
        return $this->manualValidation;
    }

    /**
     * Set depth
     *
     * @param integer $depth
     * @return GoTerm
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;

        return $this;
    }

    /**
     * Get depth
     *
     * @return integer
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * Set scoreSum
     *
     * @param float $scoreSum
     * @return GoTerm
     */
    public function setScoreSum($scoreSum)
    {
        $this->scoreSum = $scoreSum;

        return $this;
    }

    /**
     * Get scoreSum
     *
     * @return float
     */
    public function getScoreSum()
    {
        return $this->scoreSum;
    }

    /**
     * Set scoreMean
     *
     * @param float $scoreMean
     * @return GoTerm
     */
    public function setScoreMean($scoreMean)
    {
        $this->scoreMean = $scoreMean;

        return $this;
    }

    /**
     * Get scoreMean
     *
     * @return float
     */
    public function getScoreMean()
    {
        return $this->scoreMean;
    }

    /**
     * Set scoreFract
     *
     * @param float $scoreFract
     * @return GoTerm
     */
    public function setScoreFract($scoreFract)
    {
        $this->scoreFract = $scoreFract;

        return $this;
    }

    /**
     * Get scoreFract
     *
     * @return float
     */
    public function getScoreFract()
    {
        return $this->scoreFract;
    }

    /**
     * Set scoreAnnot
     *
     * @param float $scoreAnnot
     * @return GoTerm
     */
    public function setScoreAnnot($scoreAnnot)
    {
        $this->scoreAnnot = $scoreAnnot;

        return $this;
    }

    /**
     * Get scoreAnnot
     *
     * @return float
     */
    public function getScoreAnnot()
    {
        return $this->scoreAnnot;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return GoTerm
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
     * @return GoTerm
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
