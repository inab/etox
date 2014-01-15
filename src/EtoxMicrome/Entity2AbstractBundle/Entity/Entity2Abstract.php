<?php

namespace EtoxMicrome\Entity2AbstractBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity2Abstract
 *
 * @ORM\Table (indexes={@ORM\Index(name="name_index", columns={"name"}), @ORM\Index(name="qualifier_index", columns={"qualifier"}) })
 * @ORM\Entity(repositoryClass="EtoxMicrome\Entity2AbstractBundle\Entity\Entity2AbstractRepository")
 */
class Entity2Abstract
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
     * @ORM\ManyToOne(targetEntity="EtoxMicrome\DocumentBundle\Entity\Abstracts", inversedBy="entity2abstract")
     * @ORM\JoinColumn(name="abstracts_id", referencedColumnName="id")
     */

    private $abstracts;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     *
     * @ORM\Column(name="qualifier", type="string",columnDefinition="ENUM('AdverseEffect', 'CellType', 'CompoundDict', 'CompoundMesh', 'Cytochrome', 'Enzyme', 'Gene', 'GoTerm', 'HepatotoxTrigger', 'Keyword', 'Marker', 'MolecularMechanism', 'OrganTissue', 'Specie', 'TimePattern')")
     */
    private $qualifier;

    /**
     * @var \String
     *
     * @ORM\Column(name="tagMethod", type="string", nullable=true)
     */
    private $tagMethod;

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
     * Set abstracts
     */
    public function setAbstracts(\EtoxMicrome\DocumentBundle\Entity\Abstracts $abstracts)
    {
        $this->abstracts = $abstracts;
        return $this;
    }

    /**
     * Get abstracts
     */
    public function getAbstracts()
    {
        return $this->abstracts;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Entity2Abstract
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
     * Set qualifier
     *
     * @param string $qualifier
     * @return Entity2Abstract
     */
    public function setQualifier($qualifier)
    {
        $this->qualifier = $qualifier;

        return $this;
    }

    /**
     * Get qualifier
     *
     * @return string
     */
    public function getQualifier()
    {
        return $this->qualifier;
    }

    /**
     * Set tagMethod
     *
     * @param string $tagMethod
     * @return Entity2Abstract
     */
    public function setTagMethod($tagMethod)
    {
        $this->tagMethod = $tagMethod;

        return $this;
    }

    /**
     * Get tagMethod
     *
     * @return string
     */
    public function getTagMethod()
    {
        return $this->tagMethod;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Entity2Abstract
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
     * @return Entity2Abstract
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

    /**
     * Get className
     *
     * @return string
     */
    public function getClassName()
    {
        return ("Entity2Abstract");
    }
}