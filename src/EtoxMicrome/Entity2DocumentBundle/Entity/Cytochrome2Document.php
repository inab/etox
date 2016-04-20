<?php

namespace EtoxMicrome\Entity2DocumentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cytochrome2Document
 *
 * @ORM\Table(indexes={@ORM\Index(name="cytochrome2Document_tagMethod_index_new", columns={"""tagMethod"""}), @ORM\Index(name="cytochrome2Document_cypsMention_index_new", columns={"""cypsMention"""}), @ORM\Index(name="cytochrome2Document_hepval_new", columns={"hepval"}), @ORM\Index(name="cytochrome2Document_patterncount_new", columns={"""patternCount"""}), @ORM\Index(name="cytochrome2Document_rulescore_new", columns={"""ruleScore"""}), @ORM\Index(name="cytochrome2Document_heptermnormscore_new", columns={"""hepTermNormScore"""}), @ORM\Index(name="cytochrome2Document_heptermvarscore_new", columns={"""hepTermVarScore"""}), @ORM\Index(name="cytochrome2Document_svmconfidence_new", columns={"""svmConfidence"""}) } ,name="cytochrome2document_new" )
 * @ORM\Entity(repositoryClass="EtoxMicrome\Entity2DocumentBundle\Entity\Cytochrome2DocumentRepository")
 */
class Cytochrome2Document
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
     * @ORM\ManyToOne(targetEntity="EtoxMicrome\DocumentBundle\Entity\Document", inversedBy="cytochrome2document")
     * @ORM\JoinColumn(name="document_id", referencedColumnName="id")
     */

    protected $document;

    /**
     * @var string
     *
     * @ORM\Column(name="""tagMethod""", type="string", length=255)
     */
    private $tagMethod;

    /**
     * @var string
     *
     * @ORM\Column(name="""baseName""", type="string", length=255)
     */
    private $baseName;

    /**
     * @var string
     *
     * @ORM\Column(name="""rootName""", type="string", length=255)
     */
    private $rootName;

    /**
     * @var string
     *
     * @ORM\Column(name="""cypsMention""", type="string", length=255)
     */
    private $cypsMention;

    /**
     * @var string
     *
     * @ORM\Column(name="sentence", type="text")
     */
    private $sentence;

    /**
     * @var string
     *
     * @ORM\Column(name="""cypsCanonical""", type="string", length=255)
     */
    private $cypsCanonical;

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
     * Set tagMethod
     *
     * @param string $tagMethod
     * @return Cytochrome2Document
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
     * Set baseName
     *
     * @param string $baseName
     * @return Cytochrome2Document
     */
    public function setBaseName($baseName)
    {
        $this->baseName = $baseName;

        return $this;
    }

    /**
     * Get baseName
     *
     * @return string
     */
    public function getBaseName()
    {
        return $this->baseName;
    }

    /**
     * Set rootName
     *
     * @param string $rootName
     * @return Cytochrome2Document
     */
    public function setRootName($rootName)
    {
        $this->rootName = $rootName;

        return $this;
    }

    /**
     * Get rootName
     *
     * @return string
     */
    public function getRootName()
    {
        return $this->rootName;
    }

    /**
     * Set cypsMention
     *
     * @param string $cypsMention
     * @return Cytochrome2Document
     */
    public function setCypsMention($cypsMention)
    {
        $this->cypsMention = $cypsMention;

        return $this;
    }

    /**
     * Get cypsMention
     *
     * @return string
     */
    public function getCypsMention()
    {
        return $this->cypsMention;
    }

    /**
     * Set sentence
     *
     * @param string $sentence
     * @return Cytochrome2Document
     */
    public function setSentence($sentence)
    {
        $this->sentence = $sentence;

        return $this;
    }

    /**
     * Get sentence
     *
     * @return string
     */
    public function getSentence()
    {
        return $this->sentence;
    }

    /**
     * Set cypsCanonical
     *
     * @param string $cypsCanonical
     * @return Cytochrome2Document
     */
    public function setCypsCanonical($cypsCanonical)
    {
        $this->cypsCanonical = $cypsCanonical;

        return $this;
    }

    /**
     * Get cypsCanonical
     *
     * @return string
     */
    public function getCypsCanonical()
    {
        return $this->cypsCanonical;
    }

    /**
     * Set curation
     *
     * @param integer $curation
     * @return Cytochrome2Document
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
     * @return Cytochrome2Document
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
     * @return Cytochrome2Document
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
     * @return Cytochrome2Document
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
     * @return Cytochrome2Document
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
     * @return Cytochrome2Document
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
     * @return Cytochrome2Document
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
     * @return Cytochrome2Document
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
     * @return Cytochrome2Document
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
        $className="Cytochrome2Document";
        return $className;
    }

    public function __toString()
    {
        return $this->cypsMention;
    }

}
