<?php

namespace EtoxMicrome\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Specie
 *
 * @ORM\Table(indexes={@ORM\Index(name="specie_entity_index", columns={"""entityId"""}),@ORM\Index(name="specie_name_index", columns={"name"}) } )
 * @ORM\Entity(repositoryClass="EtoxMicrome\EntityBundle\Entity\SpecieRepository")
 */
class Specie
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
     * @ORM\Column(name="""ncbiTaxId""", type="string", length=255)
     */
    private $ncbiTaxId;

    /**
     * @var string
     *
     * @ORM\Column(name="""entityId""", type="string", length=255)
     */
    private $entityId;

    /**
     * @var string
     *
     * @ORM\Column(name="""specieCategory""", type="string", length=255)
     */
    private $specieCategory;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="""nameClass""", type="string", length=255)
     */
    private $nameClass;

    /**
     * @var string
     *
     * @ORM\Column(name="""specieTox""", type="string", length=255)
     */
    private $specieTox;

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
     * @ORM\OneToMany(targetEntity="EtoxMicrome\Entity2DocumentBundle\Entity\Specie2Document", mappedBy="specie")
     **/
    private $specie2document;

    /**
    * Constructor de la clase
    **/
    public function __construct()
    {
        $this->specie2document = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set ncbiTaxId
     *
     * @param string $ncbiTaxId
     * @return Specie
     */
    public function setNcbiTaxId($ncbiTaxId)
    {
        $this->ncbiTaxId = $ncbiTaxId;

        return $this;
    }

    /**
     * Get ncbiTaxId
     *
     * @return string
     */
    public function getNcbiTaxId()
    {
        return $this->ncbiTaxId;
    }

    /**
     * Set entityId
     *
     * @param string $entityId
     * @return string
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
     * Set specieCategory
     *
     * @param string $specieCategory
     * @return string
     */
    public function setSpecieCategory($specieCategory)
    {
        $this->specieCategory = $specieCategory;

        return $this;
    }

    /**
     * Get specieCategory
     *
     * @return string
     */
    public function getSpecieCategory()
    {
        return $this->specieCategory;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return string
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
    public function getname()
    {
        return $this->name;
    }

    /**
     * Set nameClass
     *
     * @param string $nameClass
     * @return string
     */
    public function setNameClass($nameClass)
    {
        $this->nameClass = $nameClass;

        return $this;
    }

    /**
     * Get nameClass
     *
     * @return string
     */
    public function getNameClass()
    {
        return $this->nameClass;
    }

    /**
     * Set specieTox
     *
     * @param string $specieTox
     * @return string
     */
    public function setSpecieTox($specieTox)
    {
        $this->specieTox = $specieTox;

        return $this;
    }

    /**
     * Get specieTox
     *
     * @return string
     */
    public function getSpecieTox()
    {
        return $this->specieTox;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Specie
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
     * @return Specie
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
     * Set specie2document
     *
     * @return integer
     */
    public function setSpecie2Document($specie2document)
    {
        $this->specie2document =$specie2document;
        return $this;
    }

    /**
     * Get specie2Document
     *
     * @return integer
     */
    public function getSpecie2Document()
    {
        return $this->specie2document;
    }
}
