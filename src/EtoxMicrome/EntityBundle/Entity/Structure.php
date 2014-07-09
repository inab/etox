<?php

namespace EtoxMicrome\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Structure
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EtoxMicrome\EntityBundle\Entity\StructureRepository")
 */
class Structure
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
     *
     * @ORM\OneToOne(targetEntity="EtoxMicrome\EntityBundle\Entity\Compounddict", inversedBy="structure")
     * @ORM\JoinColumn(name="compound_id", referencedColumnName="id")
     */
    private $compound;

    /**
     * @var string
     *
     * @ORM\Column(name="sdf", type="text", nullable=true)
     */
    private $sdf;

    /**
     * @var string
     *
     * @ORM\Column(name="mol", type="text", nullable=true)
     */
    private $mol;

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
     * Set compound
     *
     * @param integer $compound
     * @return Structure
     */
    public function setCompound($compound)
    {
        $this->compound = $compound;

        return $this;
    }

    /**
     * Get compound
     *
     * @return integer
     */
    public function getCompound()
    {
        return $this->compound;
    }

    /**
     * Set sdf
     *
     * @param string $sdf
     * @return Structure
     */
    public function setSdf($sdf)
    {
        $this->sdf = $sdf;

        return $this;
    }

    /**
     * Get sdf
     *
     * @return string
     */
    public function getSdf()
    {
        return $this->sdf;
    }

    /**
     * Set mol
     *
     * @param string $mol
     * @return Structure
     */
    public function setMol($mol)
    {
        $this->mol = $mol;

        return $this;
    }

    /**
     * Get mol
     *
     * @return string
     */
    public function getMol()
    {
        return $this->mol;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Structure
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
     * @return Structure
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
