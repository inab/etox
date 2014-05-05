<?php

namespace EtoxMicrome\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cytochrome
 *
 * @ORM\Table(indexes={@ORM\Index(name="cytochrome_entity_index", columns={"""entityId"""}),@ORM\Index(name="cytochrome_name_index", columns={"name"}), @ORM\Index(name="cytochrome_tax_index", columns={"tax"}) } )
 * @ORM\Entity(repositoryClass="EtoxMicrome\EntityBundle\Entity\CytochromeRepository")
 */
class Cytochrome
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
     * @ORM\Column(name="""entityId""", type="string", length=255)
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
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="tax", type="string", length=255)
     */
    private $tax;

    /**
     * @var float
     *
     * @ORM\Column(name="score", type="float")
     */
    private $score;

    /**
     * @var string
     *
     * @ORM\Column(name="canonical", type="string", length=255)
     */
    private $canonical;

    /**
     * @var float
     *
     * @ORM\Column(name="""cypUniprotRanking""", type="float", nullable=true)
     */
    private $cypUniprotRanking;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var string
     *
     * @ORM\Column(name="updated",  type="datetime", nullable=true)
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
     * @return Cytochrome
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
     * @return Cytochrome
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
     * Set type
     *
     * @param string $type
     * @return Cytochrome
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set tax
     *
     * @param string $tax
     * @return Cytochrome
     */
    public function setTax($tax)
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * Get tax
     *
     * @return string
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Set score
     *
     * @param float $score
     * @return Cytochrome
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return float
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set canonical
     *
     * @param string $canonical
     * @return Cytochrome
     */
    public function setCanonical($canonical)
    {
        $this->canonical = $canonical;

        return $this;
    }

    /**
     * Get canonical
     *
     * @return string
     */
    public function getCanonical()
    {
        return $this->canonical;
    }

    /**
     * Set cypUniprotRanking
     *
     * @param float $cypUniprotRanking
     * @return Cytochrome
     */
    public function setCypUniprotRanking($cypUniprotRanking)
    {
        $this->cypUniprotRanking = $cypUniprotRanking;

        return $this;
    }

    /**
     * Get cypUniprotRanking
     *
     * @return float
     */
    public function getCypUniprotRanking()
    {
        return $this->cypUniprotRanking;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Cytochrome
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
     * @return Cytochrome
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
