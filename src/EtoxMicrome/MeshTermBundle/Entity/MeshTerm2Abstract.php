<?php

namespace EtoxMicrome\MeshTermBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MeshTerm2Abstract
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EtoxMicrome\MeshTermBundle\Entity\MeshTerm2AbstractRepository")
 */
class MeshTerm2Abstract
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
     * @ORM\ManyToOne(targetEntity="EtoxMicrome\DocumentBundle\Entity\Abstracts", inversedBy="meshTerm2abstract")
     * @ORM\JoinColumn(name="abstract_id", referencedColumnName="id")
     */
    private $abstract;

    /**
     * @ORM\ManyToOne(targetEntity="EtoxMicrome\MeshTermBundle\Entity\MeshTerm", inversedBy="meshTerm2abstract")
     * @ORM\JoinColumn(name="meshTerm_id", referencedColumnName="id")
     */
    private $meshTerm;

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
     * Set abstract
     */
    public function setAbstract(\EtoxMicrome\DocumentBundle\Entity\Abstracts $abstract)
    {
        $this->abstract = $abstract;
        return $this;
    }

    /**
     * Get abstract
     */
    public function getAbstract()
    {
        return $this->abstract;
    }

    /**
     * Set meshTerm
     */
    public function setMeshTerm(\EtoxMicrome\MeshTermBundle\Entity\MeshTerm $meshTerm)
    {
        $this->meshTerm = $meshTerm;
        return $this;
    }

    /**
     * Get meshTerm
     */
    public function getMeshTerm()
    {
        return $this->meshTerm;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return MeshTerm2Abstract
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
     * @return MeshTerm2Abstract
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
