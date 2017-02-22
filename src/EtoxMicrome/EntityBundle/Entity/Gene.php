<?php

namespace EtoxMicrome\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Gene
 *
 * @ORM\Table(indexes={@ORM\Index(name="gene_entity_index", columns={"entityId"}),@ORM\Index(name="gene_name_index", columns={"name"}) } )
 * @ORM\Entity(repositoryClass="EtoxMicrome\EntityBundle\Entity\GeneRepository")
 */
class Gene
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
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="ncbi_tax", type="string", length=255)
     */
    private $ncbiTax;

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
     * @return Gene
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
     * @return Gene
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
     * @return Gene
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
     * Set ncbiTax
     *
     * @param string $ncbiTax
     * @return Gene
     */
    public function setNcbiTax($ncbiTax)
    {
        $this->ncbiTax = $ncbiTax;

        return $this;
    }

    /**
     * Get ncbiTax
     *
     * @return string
     */
    public function getNcbiTax()
    {
        return $this->ncbiTax;
    }

    /**
     * Set extId1
     *
     * @param string $extId1
     * @return Gene
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
     * @return Gene
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
     * Set created
     *
     * @param \DateTime $created
     * @return Gene
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
     * @return Gene
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
