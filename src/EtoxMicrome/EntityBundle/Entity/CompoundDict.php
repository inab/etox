<?php

namespace EtoxMicrome\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CompoundDict
 *
 * @ORM\Table(indexes={@ORM\Index(name="compoundDict_new_name_index", columns={"name"}), @ORM\Index(name="compoundDict_new_chemIdPlus_index", columns={"""chemIdPlus"""}), @ORM\Index(name="compoundDict_new_chebi_index", columns={"chebi"}), @ORM\Index(name="compoundDict_new_inchi_index", columns={"""inChi"""}), @ORM\Index(name="compoundDict_new_casRegistryNumber_index", columns={"""casRegistryNumber"""}), @ORM\Index(name="compoundDict_new_pubChemCompound_index", columns={"""pubChemCompound"""}), @ORM\Index(name="compoundDict_new_pubChemSubstance_index", columns={"""pubChemSubstance"""}), @ORM\Index(name="compoundDict_new_drugBank_index", columns={"""drugBank"""}), @ORM\Index(name="compoundDict_new_humanMetabolome_index", columns={"""humanMetabolome"""}), @ORM\Index(name="compoundDict_new_keggCompound_index", columns={"""keggCompound"""}), @ORM\Index(name="compoundDict_new_keggDrug_index", columns={"""keggDrug"""}), @ORM\Index(name="compoundDict_new_mesh_index", columns={"mesh"}) } )
 * @ORM\Entity(repositoryClass="EtoxMicrome\EntityBundle\Entity\CompoundDictRepository")
 */
class CompoundDict
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
     * @ORM\Column(name="""chemIdPlus""", type="string", length=500)
     */
    private $chemIdPlus;

    /**
     * @var string
     *
     * @ORM\Column(name="chebi", type="string", length=500)
     */
    private $chebi;

    /**
     * @var string
     *
     * @ORM\Column(name="""casRegistryNumber""", type="string", length=500)
     */
    private $casRegistryNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="""pubChemCompound""", type="string", length=500)
     */
    private $pubChemCompound;

    /**
     * @var string
     *
     * @ORM\Column(name="""pubChemSubstance""", type="string", length=500, nullable=true)
     */
    private $pubChemSubstance;

    /**
     * @var string
     *
     * @ORM\Column(name="""inChi""", type="text", nullable=true)
     */
    private $inChi;

    /**
     * @var string
     *
     * @ORM\Column(name="""drugBank""", type="string", length=500, nullable=true)
     */
    private $drugBank;

    /**
     * @var string
     *
     * @ORM\Column(name="""humanMetabolome""", type="string", length=500, nullable=true)
     */
    private $humanMetabolome;

    /**
     * @var string
     *
     * @ORM\Column(name="""keggCompound""", type="string", length=500, nullable=true)
     */
    private $keggCompound;

    /**
     * @var string
     *
     * @ORM\Column(name="""keggDrug""", type="string", length=500, nullable=true)
     */
    private $keggDrug;

    /**
     * @var string
     *
     * @ORM\Column(name="mesh", type="string", length=500, nullable=true)
     */
    private $mesh;

    /**
     * @var integer
     *
     * @ORM\Column(name="""nrDbIds""", type="integer", nullable=true)
     */
    private $nrDbIds;

    /**
     * @var string
     *
     * @ORM\Column(name="smile", type="text")
     */
    private $smile;

    /**
     * @var integer
     *
     * @ORM\Column(name="name2struct", type="integer", nullable=true)
     */
    private $name2struct;

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
     * @ORM\OneToOne(targetEntity="EtoxMicrome\DocumentBundle\Entity\Image")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     */
    private $image;

    /**
     * @ORM\OneToOne(targetEntity="EtoxMicrome\EntityBundle\Entity\Structure")
     * @ORM\JoinColumn(name="structure_id", referencedColumnName="id")
     */
    private $structure;

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
     * @return CompoundDict
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
     * Set chemIdPlus
     *
     * @param string $chemIdPlus
     * @return CompoundDict
     */
    public function setChemIdPlus($chemIdPlus)
    {
        $this->chemIdPlus = $chemIdPlus;

        return $this;
    }

    /**
     * Get $chemIdPlus
     *
     * @return string
     */
    public function getChemIdPlus()
    {
        return $this->chemIdPlus;
    }

    /**
     * Set chebi
     *
     * @param string $chebi
     * @return CompoundDict
     */
    public function setChebi($chebi)
    {
        $this->chebi = $chebi;

        return $this;
    }

    /**
     * Get chebi
     *
     * @return string
     */
    public function getChebi()
    {
        return $this->chebi;
    }

    /**
     * Set casRegistryNumber
     *
     * @param string $casRegistryNumber
     * @return CompoundDict
     */
    public function setCasRegistryNumber($casRegistryNumber)
    {
        $this->casRegistryNumber = $casRegistryNumber;

        return $this;
    }

    /**
     * Get casRegistryNumber
     *
     * @return string
     */
    public function getCasRegistryNumber()
    {
        return $this->casRegistryNumber;
    }

    /**
     * Set pubChemCompound
     *
     * @param string $pubChemCompound
     * @return CompoundDict
     */
    public function setPubChemCompound($pubChemCompound)
    {
        $this->pubChemCompound = $pubChemCompound;

        return $this;
    }

    /**
     * Get pubChemCompound
     *
     * @return string
     */
    public function getPubChemCompound()
    {
        return $this->pubChemCompound;
    }

    /**
     * Set pubChemSubstance
     *
     * @param string $pubChemSubstance
     * @return CompoundDict
     */
    public function setPubChemSubstance($pubChemSubstance)
    {
        $this->pubChemSubstance = $pubChemSubstance;

        return $this;
    }

    /**
     * Get pubChemSubstance
     *
     * @return string
     */
    public function getPubChemSubstance()
    {
        return $this->pubChemSubstance;
    }

    /**
     * Set inChi
     *
     * @param string $inChi
     * @return CompoundDict
     */
    public function setInChi($inChi)
    {
        $this->inChi = $inChi;

        return $this;
    }

    /**
     * Get inChi
     *
     * @return string
     */
    public function getInChi()
    {
        return $this->inChi;
    }

    /**
     * Set drugBank
     *
     * @param string $drugBank
     * @return CompoundDict
     */
    public function setDrugBank($drugBank)
    {
        $this->drugBank = $drugBank;

        return $this;
    }

    /**
     * Get drugBank
     *
     * @return string
     */
    public function getDrugBank()
    {
        return $this->drugBank;
    }

    /**
     * Set humanMetabolome
     *
     * @param string $humanMetabolome
     * @return CompoundDict
     */
    public function setHumanMetabolome($humanMetabolome)
    {
        $this->humanMetabolome = $humanMetabolome;

        return $this;
    }

    /**
     * Get humanMetabolome
     *
     * @return string
     */
    public function getHumanMetabolome()
    {
        return $this->humanMetabolome;
    }

    /**
     * Set keggCompound
     *
     * @param string $keggCompound
     * @return CompoundDict
     */
    public function setKeggCompound($keggCompound)
    {
        $this->keggCompound = $keggCompound;

        return $this;
    }

    /**
     * Get keggCompound
     *
     * @return string
     */
    public function getKeggCompound()
    {
        return $this->keggCompound;
    }

    /**
     * Set keggDrug
     *
     * @param string $keggDrug
     * @return CompoundDict
     */
    public function setKeggDrug($keggDrug)
    {
        $this->keggDrug = $keggDrug;

        return $this;
    }

    /**
     * Get keggDrug
     *
     * @return string
     */
    public function getKeggDrug()
    {
        return $this->keggDrug;
    }

    /**
     * Set mesh
     *
     * @param string $mesh
     * @return CompoundDict
     */
    public function setMesh($mesh)
    {
        $this->mesh = $mesh;

        return $this;
    }

    /**
     * Get mesh
     *
     * @return string
     */
    public function getMesh()
    {
        return $this->mesh;
    }

    /**
     * Set nrDbIds
     *
     * @return integer
     */
    public function setNrDbIds($nrDbIds)
    {
        $this->nrDbIds=$nrDbIds;
        return $this;
    }

    /**
     * Get nrDbIds
     *
     * @return integer
     */
    public function getNrDbIds()
    {
        return $this->nrDbIds;
    }

    /**
     * Set smile
     *
     * @param string $smile
     * @return CompoundDict
     */
    public function setSmile($smile)
    {
        $this->smile = $smile;

        return $this;
    }

    /**
     * Get smile
     *
     * @return string
     */
    public function getSmile()
    {
        return $this->smile;
    }

    /**
     * Set name2struct
     *
     * @return integer
     */
    public function setName2struct($name2struct)
    {
        $this->name2struct=$name2struct;
        return $this;
    }

    /**
     * Get name2struct
     *
     * @return integer
     */
    public function getName2struct()
    {
        return $this->name2struct;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return CompoundDict
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
     * @return CompoundDict
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
     * Set image
     *
     */
    public function setImage(\EtoxMicrome\DocumentBundle\Entity\Image $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set structure
     *
     */
    public function setStructure(\EtoxMicrome\EntityBundle\Entity\Structure $structure)
    {
        $this->structure = $structure;

        return $this;
    }

    /**
     * Get structure
     *
     */
    public function getStructure()
    {
        return $this->structure;
    }
}
