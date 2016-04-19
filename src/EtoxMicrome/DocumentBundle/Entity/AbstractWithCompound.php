<?php

namespace EtoxMicrome\DocumentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AbstractWithCompound
 *
 * @ORM\Table(indexes={@ORM\Index(name="abstractWithCompound_pmid_index", columns={"pmid"}), @ORM\Index(name="abstractWithCompound_hepval_index", columns={"hepval"}), @ORM\Index(name="abstractWithCompound_patterncount", columns={"""patternCount"""}), @ORM\Index(name="abstractWithCompound_rulescore", columns={"""ruleScore"""}), @ORM\Index(name="abstractWithCompound_heptermnormscore", columns={"""hepTermNormScore"""}), @ORM\Index(name="abstractWithCompound_heptermvarscore", columns={"""hepTermVarScore"""}), @ORM\Index(name="abstractWithCompound_svmconfidence", columns={"""svmConfidence"""})  })
 * @ORM\Entity(repositoryClass="EtoxMicrome\DocumentBundle\Entity\AbstractWithCompoundRepository")
 */
class AbstractWithCompound
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
     * @ORM\Column(name="pmid", type="string", length=255)
     */
    private $pmid;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="text")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;

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
     * @var integer
     *
     * @ORM\Column(name="""toxicology""", type="integer", nullable=true)
     */
    private $toxicology;

    /**
     * @var integer
     *
     * @ORM\Column(name="""biomarker""", type="integer", nullable=true)
     */
    private $biomarker;

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
     * Set pmid
     *
     * @param string $pmid
     * @return Abstracts
     */
    public function setPmid($pmid)
    {
        $this->pmid = $pmid;

        return $this;
    }

    /**
     * Get pmid
     *
     * @return string
     */
    public function getPmid()
    {
        return $this->pmid;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Abstract
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Abstract
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set hepval
     *
     * @param float $hepval
     * @return Abstracts
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
     * @return AbstractWithCompound
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
     * @return AbstractWithCompound
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
     * @return AbstractWithCompound
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
     * @return AbstractWithCompound
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
     * @return AbstractWithCompound
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
     * Set toxicology
     *
     * @param integer $toxicology
     * @return AbstractWithCompound
     */
    public function setToxicology($toxicology)
    {
        $this->toxicology = $toxicology;

        return $this;
    }

    /**
     * Get toxicology
     *
     * @return integer
     */
    public function getToxicology()
    {
        return $this->toxicology;
    }

    /**
     * Set biomarker
     *
     * @param integer $biomarker
     * @return AbstractWithCompound
     */
    public function setBiomarker($biomarker)
    {
        $this->biomarker = $biomarker;

        return $this;
    }

    /**
     * Get biomarker
     *
     * @return integer
     */
    public function getBiomarker()
    {
        return $this->biomarker;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Abstracts
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
     * @return Abstracts
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

    public function getClassName()
    {
        $className="AbstractWithCompound";
        return $className;
    }

    public function __toString()
    {
        return $this->text;
    }
}