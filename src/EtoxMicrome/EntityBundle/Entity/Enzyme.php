<?php

namespace EtoxMicrome\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Enzyme
 *
 * @ORM\Table(indexes={@ORM\Index(name="entity_index", columns={"entityId"}),@ORM\Index(name="name_index", columns={"name"}) })
 * @ORM\Entity(repositoryClass="EtoxMicrome\EntityBundle\Entity\EnzymeRepository")
 */
class Enzyme
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
     * @ORM\Column(name="extId1", type="string", length=255)
     */
    private $extId1;

    /**
     * @var string
     *
     * @ORM\Column(name="extId2", type="string", length=255)
     */
    private $extId2;

    /**
     * @var string
     *
     * @ORM\Column(name="extId3", type="string", length=255)
     */
    private $extId3;

    /**
     * @var string
     *
     * @ORM\Column(name="extId4", type="string", length=255)
     */
    private $extId4;

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
     * @return Enzyme
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
     * @return Enzyme
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
     * Set extId1
     *
     * @param string $extId1
     * @return Enzyme
     */
    public function setExtId1($extId1)
    {
        $this->extId1 = $extId1;

        return $this;
    }

    /**
     * Get extId1
     *
     * @return string
     */
    public function getExtId1()
    {
        return $this->extId1;
    }

    /**
     * Set extId2
     *
     * @param string $extId2
     * @return Enzyme
     */
    public function setExtId2($extId2)
    {
        $this->extId2 = $extId2;

        return $this;
    }

    /**
     * Get extId2
     *
     * @return string
     */
    public function getExtId2()
    {
        return $this->extId2;
    }

    /**
     * Set extId3
     *
     * @param string $extId3
     * @return Enzyme
     */
    public function setExtId3($extId3)
    {
        $this->extId3 = $extId3;

        return $this;
    }

    /**
     * Get extId3
     *
     * @return string
     */
    public function getExtId3()
    {
        return $this->extId3;
    }

    /**
     * Set extId4
     *
     * @param string $extId4
     * @return Enzyme
     */
    public function setExtId4($extId4)
    {
        $this->extId4 = $extId4;

        return $this;
    }

    /**
     * Get extId4
     *
     * @return string
     */
    public function getExtId4()
    {
        return $this->extId4;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Enzyme
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
     * @return Enzyme
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
