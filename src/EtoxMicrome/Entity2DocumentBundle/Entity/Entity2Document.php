<?php

namespace EtoxMicrome\Entity2DocumentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity2Document
 *
 * @ORM\Table(indexes={
        @ORM\Index(name="entity2Document_nephro_cardio_document_id_new", columns={"document_id"}),
        @ORM\Index(name="entity2Document_nephro_cardio_name_index_new", columns={"name"}),
        @ORM\Index(name="entity2Document_nephro_cardio_curation_new", columns={"curation"}),
        @ORM\Index(name="entity2document_nephro_cardio_hepval_new", columns={"hepval"}),
        @ORM\Index(name="entity2document_nephro_cardio_cardval_new", columns={"cardval"}),
        @ORM\Index(name="entity2document_nephro_cardio_nephval_new", columns={"nephval"}),
        @ORM\Index(name="entity2document_nephro_cardio_phosval_new", columns={"phosval"}),
        @ORM\Index(name="entity2document_nephro_cardio_nephroval_index", columns={"nephroval"}),
        @ORM\Index(name="entity2document_nephro_cardio_cardioval_index", columns={"cardioval"}),
        @ORM\Index(name="entity2document_nephro_cardio_thyroval_index", columns={"thyroval"}),
        @ORM\Index(name="entity2document_nephro_cardio_phosphoval_index", columns={"phosphoval"}),
        @ORM\Index(name="entity2document_nephro_cardio_patterncount_new", columns={"""patternCount"""}),
        @ORM\Index(name="entity2document_nephro_cardio_rulescore_new", columns={"""ruleScore"""}),
        @ORM\Index(name="entity2document_nephro_cardio_qualifier_new", columns={"qualifier"}),
        @ORM\Index(name="entity2document_nephro_cardio_svm_confidence_index_new", columns={"""svmConfidence"""}),
        @ORM\Index(name="entity2document_nephro_cardio_heptermnormscore_new", columns={"""hepTermNormScore"""}),
        @ORM\Index(name="entity2document_nephro_cardio_heptermvarscore_new", columns={"""hepTermVarScore"""}),
        @ORM\Index(name="entity2document_nephro_cardio_kind_new", columns={"kind"})
    }, name="entity2document_nephro_cardio")
 * @ORM\Entity(repositoryClass="EtoxMicrome\Entity2DocumentBundle\Entity\Entity2DocumentRepository")
 */
class Entity2Document
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
     * @ORM\ManyToOne(targetEntity="EtoxMicrome\DocumentBundle\Entity\Document", inversedBy="entity2document")
     * @ORM\JoinColumn(name="document_id", referencedColumnName="id")
     */

    protected $document;

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
     * @ORM\Column(name="cardval", type="float", nullable=true)
     */
    private $cardval;

    /**
     * @var float
     *
     * @ORM\Column(name="nephval", type="float", nullable=true)
     */
    private $nephval;

    /**
     * @var float
     *
     * @ORM\Column(name="phosval", type="float", nullable=true)
     */
    private $phosval;

    /**
     * @var float
     *
     * @ORM\Column(name="nephroval", type="float", nullable=true)
     */
    private $nephroval;

    /**
     * @var float
     *
     * @ORM\Column(name="cardioval", type="float", nullable=true)
     */
    private $cardioval;

    /**
     * @var float
     *
     * @ORM\Column(name="thyroval", type="float", nullable=true)
     */
    private $thyroval;

    /**
     * @var float
     *
     * @ORM\Column(name="phosphoval", type="float", nullable=true)
     */
    private $phosphoval;

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
     * @var integer
     *
     * @ORM\Column(name="kind", type="string", length=255)
     */
    private $kind;

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
     * Set document
     */
    public function setDocument(\EtoxMicrome\DocumentBundle\Entity\Document $document)
    {
        $this->document = $document;
        return $this;
    }

    /**
     * Get document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Entity2Document
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
     * @return Entity2Document
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
     * @return Entity2Document
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
     * @return Entity2Document
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
     * @return Entity2Document
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
     * Set cardval
     *
     * @param float $cardval
     * @return Entity2Document
     */
    public function setCardval($cardval)
    {
        $this->cardval = $cardval;

        return $this;
    }

    /**
     * Get cardval
     *
     * @return float
     */
    public function getCardval()
    {
        return $this->cardval;
    }

    /**
     * Set nephval
     *
     * @param float $nephval
     * @return Entity2Document
     */
    public function setNephval($nephval)
    {
        $this->nephval = $nephval;

        return $this;
    }

    /**
     * Get nephval
     *
     * @return float
     */
    public function getNephval()
    {
        return $this->nephval;
    }

    /**
     * Set phosval
     *
     * @param float $phosval
     * @return Entity2Document
     */
    public function setPhosval($phosval)
    {
        $this->phosval = $phosval;

        return $this;
    }

    /**
     * Get phosval
     *
     * @return float
     */
    public function getPhosval()
    {
        return $this->phosval;
    }

    /**
     * Get nephroval
     *
     * @return float
     */
    public function getNephroval()
    {
        return $this->nephroval;
    }

    /**
     * Set nephroval
     *
     * @param float $nephroval
     * @return Entity2Document
     */
    public function setNephroval($nephroval)
    {
        $this->nephroval = $nephroval;

        return $this;
    }

    /**
     * Get carioval
     *
     * @return float
     */
    public function getCardioval()
    {
        return $this->cardioval;
    }

    /**
     * Set cardioval
     *
     * @param float $cardioval
     * @return Entity2Document
     */
    public function setCardioval($cardioval)
    {
        $this->cardioval = $cardioval;

        return $this;
    }

    /**
     * Get thyroval
     *
     * @return float
     */
    public function getThyroval()
    {
        return $this->thyroval;
    }

    /**
     * Set thyroval
     *
     * @param float $thyroval
     * @return Entity2Document
     */
    public function setThyroval($thyroval)
    {
        $this->thyroval = $thyroval;

        return $this;
    }

    /**
     * Set patternCount
     *
     * @param float $patternCount
     * @return Entity2Document
     */
    public function getPhosphoval($phosphoval)
    {
        $this->phosphoval = $phosphoval;

        return $this;
    }

    /**
     * Set phosphoval
     *
     * @param float $phosphoval
     * @return Entity2Document
     */
    public function setPhosphoval($phosphoval)
    {
        $this->phosphoval = $phosphoval;

        return $this;
    }

    /**
     * Set patternCount
     *
     * @param float $patternCount
     * @return Entity2Document
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
     * @return Entity2Document
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
     * @return Entity2Document
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
     * @return Entity2Document
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
     * @return Entity2Document
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
     * Set kind
     *
     * @param string $kind
     * @return Entity2Document
     */
    public function setKind($kind)
    {
        $this->kind = $kind;

        return $this;
    }

    /**
     * Get kind
     *
     * @return string
     */
    public function getKind()
    {
        return $this->kind;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Entity2Document
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
     * @return Entity2Document
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
        return ("Entity2Document");
    }
}
