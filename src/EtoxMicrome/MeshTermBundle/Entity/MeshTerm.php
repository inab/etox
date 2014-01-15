<?php

namespace EtoxMicrome\MeshTermBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MeshTerm
 *
 * @ORM\Table(indexes={@ORM\Index(name="meshId_index", columns={"meshId"}),@ORM\Index(name="term_index", columns={"term"}) })
 * @ORM\Entity(repositoryClass="EtoxMicrome\MeshTermBundle\Entity\MeshTermRepository")
 */
class MeshTerm
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
     * @ORM\Column(name="meshId", type="string", length=255)
     */
    private $meshId;

    /**
     * @var string
     *
     * @ORM\Column(name="term", type="string", length=255)
     */
    private $term;

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
     * @ORM\OneToMany(targetEntity="EtoxMicrome\MeshTermBundle\Entity\MeshTerm2Abstract", mappedBy="meshTerm")
     **/
    private $meshTerm2abstract;

    /**
    * Constructor de la clase
    **/
    public function __construct() {
        $this->meshTerm2abstract = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set meshId
     *
     * @param string $meshId
     * @return MeshTerm
     */
    public function setMeshId($meshId)
    {
        $this->meshId = $meshId;

        return $this;
    }

    /**
     * Get meshId
     *
     * @return string
     */
    public function getMeshId()
    {
        return $this->meshId;
    }

    /**
     * Set term
     *
     * @param string $term
     * @return MeshTerm
     */
    public function setTerm($term)
    {
        $this->term = $term;

        return $this;
    }

    /**
     * Get term
     *
     * @return string
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return MeshTerm
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
     * @return MeshTerm
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
     * Set meshTerm2abstract
     *
     */
    public function setMeshTerm2Abstract($meshTerm2abstract)
    {
        $this->meshTerm2abstract =$meshTerm2abstract;
        return $this;
    }

    /**
     * Get meshTerm2abstract
     *
     * @return integer
     */
    public function getMeshTerm2Abstract()
    {
        return $this->meshTerm2abstract;
    }

}
