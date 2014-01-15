<?php

namespace EtoxMicrome\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CompoundMesh
 *
 * @ORM\Table(indexes={@ORM\Index(name="name_index", columns={"name"}), @ORM\Index(name="meshUi_index", columns={"meshUi"})  })
 * @ORM\Entity(repositoryClass="EtoxMicrome\EntityBundle\Entity\CompoundMeshRepository")
 */
class CompoundMesh
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="identifier", type="string", length=255)
     */
    private $identifier;

    /**
     * @var string
     *
     * @ORM\Column(name="meshUi", type="string", length=255)
     */
    private $meshUi;

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
     * Set name
     *
     * @param string $name
     * @return CompoundMesh
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
     * Set identifier
     *
     * @param string $identifier
     * @return CompoundMesh
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }


    /**
     * Set meshUi
     *
     * @param string $meshUi
     * @return CompoundMesh
     */
    public function setMeshUi($meshUi)
    {
        $this->meshUi = $meshUi;

        return $this;
    }

    /**
     * Get meshUi
     *
     * @return string
     */
    public function getmeshUi()
    {
        return $this->meshUi;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return CompoundMesh
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
     * @return CompoundMesh
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