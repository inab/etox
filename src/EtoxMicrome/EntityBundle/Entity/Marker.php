<?php

namespace EtoxMicrome\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Marker
 *
 * @ORM\Table(indexes={@ORM\Index(name="entity_index", columns={"entityId"}), @ORM\Index(name="name_index", columns={"name"}), @ORM\Index(name="markerType_index", columns={"markerType"}) })
 * @ORM\Entity(repositoryClass="EtoxMicrome\EntityBundle\Entity\MarkerRepository")
 */
class Marker
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
     * @ORM\Column(name="markerType", type="string", length=255)
     */
    private $markerType;

    /**
     * @var string
     *
     * @ORM\Column(name="tax", type="string", length=255)
     */
    private $tax;

    /**
     * @var string
     *
     * @ORM\Column(name="term1", type="string", length=255)
     */
    private $term1;

    /**
     * @var string
     *
     * @ORM\Column(name="term2", type="string", length=255, nullable=true)
     */
    private $term2;

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
     * @return Marker
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
     * @return Marker
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
     * Set markerType
     *
     * @param string $markerType
     * @return Marker
     */
    public function setMarkerType($markerTpe)
    {
        $this->markerType = $markerType;

        return $this;
    }

    /**
     * Get markerType
     *
     * @return string
     */
    public function getMarkerType()
    {
        return $this->markerType;
    }

    /**
     * Set tax
     *
     * @param string $tax
     * @return Marker
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
     * Set term1
     *
     * @param string $term1
     * @return Marker
     */
    public function setTerm1($term1)
    {
        $this->term1 = $term1;

        return $this;
    }

    /**
     * Get term1
     *
     * @return string
     */
    public function getTerm1()
    {
        return $this->term1;
    }

    /**
     * Set term2
     *
     * @param string $term2
     * @return Marker
     */
    public function setTerm2($term2)
    {
        $this->term2 = $term2;

        return $this;
    }

    /**
     * Get term2
     *
     * @return string
     */
    public function getTerm2()
    {
        return $this->term2;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Marker
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
     * @return Marker
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
