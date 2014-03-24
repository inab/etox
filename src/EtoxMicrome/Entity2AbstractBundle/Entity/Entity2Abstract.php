<?php

namespace EtoxMicrome\Entity2AbstractBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity2Abstract
 *
 * @ORM\Table (indexes={@ORM\Index(name="entity2Abstract_name", columns={"name"}), @ORM\Index(name="entity2Abstract_qualifier", columns={"qualifier"}), @ORM\Index(name="entity2Abstract_hepval", columns={"hepval"}), @ORM\Index(name="entity2Abstract_svmconfidence", columns={"""svmConfidence"""}), @ORM\Index(name="entity2Abstract_rulescore", columns={"""ruleScore"""}), @ORM\Index(name="entity2Abstract_patterncount", columns={"""patternCount"""}), @ORM\Index(name="entity2Abstract_heptermnormscore", columns={"""hepTermNormScore"""}), @ORM\Index(name="entity2Abstract_heptermvarscore", columns={"""hepTermVarScore"""}), @ORM\Index(name="entity2Abstract_qualifier_name", columns={"qualifier", "name"}), @ORM\Index(name="entity2Abstract_qualifier_name_hepval", columns={"qualifier", "name", "hepval"}) } )
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
     * @ORM\Column(name="""tagMethod""", type="string", nullable=true)
     */
    private $tagMethod;

    /**
     * @var integer
     *
     * @ORM\Column(name="curation", type="integer", nullable=true)
     */
    private $curation;

    /**
     * @var float
     *
     * @ORM\Column(name="hepval", type="float", nullable=true)
     */
    private $hepval;

    /**
     * @var float
     *
     * @ORM\Column(name="""patternCount""", type="float", nullable=true)
     */
    private $patternCount;

    /**
     * @var float
     *
     * @ORM\Column(name="""ruleScore""", type="float", nullable=true)
     */
    private $ruleScore;

    /**
     * @var float
     *
     * @ORM\Column(name="""hepTermNormScore""", type="float", nullable=true)
     */
    private $hepTermNormScore;

    /**
     * @var float
     *
     * @ORM\Column(name="""hepTermVarScore""", type="float", nullable=true)
     */
    private $hepTermVarScore;

    /**
     * @var float
     *
     * @ORM\Column(name="""svmConfidence""", type="float", nullable=true)
     */
    private $svmConfidence;


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
     * Set curation
     *
     * @param integer $curation
     * @return Entity2Do
     */
    public function setCuration($curation)
    {
        $this->curation = $curation;

        return $this;
    }

    /**
     * Get curation
     *
     * @return integer
     */
    public function getCuration()
    {
        return $this->curation;
    }

    /**
     * Set hepval
     *
     * @param float $hepval
     * @return Entity2Abstract
     */
    public function setHepval($hepval)
    {
        $this->hepval = $hepval;

        return $this;
    }

    /**
     * Get hepval
     *
     * @return float
     */
    public function getHepval()
    {
        return $this->hepval;
    }

    /**
     * Set patternCount
     *
     * @param float $patternCount
     * @return Entity2Abstract
     */
    public function setPatternCount($patternCount)
    {
        $this->patternCount = $patternCount;

        return $this;
    }

    /**
     * Get patternCount
     *
     * @return float
     */
    public function getPatternCount()
    {
        return $this->patternCount;
    }

    /**
     * Set ruleScore
     *
     * @param float $ruleScore
     * @return Entity2Abstract
     */
    public function setRuleScore($ruleScore)
    {
        $this->ruleScore = $ruleScore;

        return $this;
    }

    /**
     * Get ruleScore
     *
     * @return float
     */
    public function getRuleScore()
    {
        return $this->ruleScore;
    }

    /**
     * Set hepTermNormScore
     *
     * @param float $hepTermNormScore
     * @return Entity2Abstract
     */
    public function setHepTermNormScore($hepTermNormScore)
    {
        $this->hepTermNormScore = $hepTermNormScore;

        return $this;
    }

    /**
     * Get hepTermNormScore
     *
     * @return float
     */
    public function getHepTermNormScore()
    {
        return $this->hepTermNormScore;
    }

    /**
     * Set hepTermVarScore
     *
     * @param float $hepTermVarScore
     * @return Entity2Abstract
     */
    public function setHepTermVarScore($hepTermVarScore)
    {
        $this->hepTermVarScore = $hepTermVarScore;

        return $this;
    }

    /**
     * Get hepTermVarScore
     *
     * @return float
     */
    public function getHepTermVarScore()
    {
        return $this->hepTermVarScore;
    }

    /**
     * Set svmConfidence
     *
     * @param float $svmConfidence
     * @return Entity2Abstract
     */
    public function setSvmConfidence($svmConfidence)
    {
        $this->svmConfidence = $svmConfidence;

        return $this;
    }

    /**
     * Get svmConfidence
     *
     * @return float
     */
    public function getSvmConfidence()
    {
        return $this->svmConfidence;
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