<?php

namespace EtoxMicrome\DocumentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocumentWithCompound
 *
 * @ORM\Table(indexes={ @ORM\Index(name="documentWithCompound_uid", columns={"uid"}), @ORM\Index(name="documentWithCompound_kind", columns={"kind"}), @ORM\Index(name="documentWithCompound_sentenceId", columns={"""sentenceId"""}), @ORM\Index(name="documentWithCompound_hepval", columns={"hepval"}), @ORM\Index(name="documentWithCompound_cardval", columns={"cardval"}), @ORM\Index(name="documentWithCompound_nephval", columns={"nephval"}), @ORM\Index(name="documentWithCompound_phosval", columns={"phosval"}), @ORM\Index(name="documentWithCompound_patterncount", columns={"""patternCount"""}), @ORM\Index(name="documentWithCompound_rulescore", columns={"""ruleScore"""}), @ORM\Index(name="documentWithCompound_heptermnormscore", columns={"""hepTermNormScore"""}), @ORM\Index(name="documentWithCompound_heptermvarscore", columns={"""hepTermVarScore"""}), @ORM\Index(name="documentWithCompound_svmconfidence", columns={"""svmConfidence"""}) } )
 * @ORM\Entity(repositoryClass="EtoxMicrome\DocumentBundle\Entity\DocumentWithCompoundRepository")
 */
class DocumentWithCompound
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
     * @ORM\Column(name="kind", type="string",columnDefinition="ENUM('pubmed', 'epar', 'nda', 'fulltext')")
     */
    private $kind;

    /**
     * @var string
     *
     * @ORM\Column(name="uid", type="string", length=255)
     */
    private $uid;

    /**
     * @var integer
     *
     * @ORM\Column(name="""sentenceId""", type="string", length=255)
     */
    private $sentenceId;

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
     * Set kind
     *
     * @param string $kind
     * @return DocumentWithCompound
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
     * Set uid
     *
     * @param string $uid
     * @return DocumentWithCompound
     */
    public function setUid($uid)
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     * Get uid
     *
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Set sentenceId
     *
     * @param string $sentenceId
     * @return DocumentWithCompound
     */
    public function setSentenceId($sentenceId)
    {
        $this->sentenceId = $sentenceId;

        return $this;
    }

    /**
     * Get sentenceId
     *
     * @return string
     */
    public function getSentenceId()
    {
        return $this->sentenceId;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return DocumentWithCompound
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
     * @return DocumentWithCompound
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
     * @return DocumentWithCompound
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
     * @return DocumentWithCompound
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
     * @return DocumentWithCompound
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
     * Set patternCount
     *
     * @param float $patternCount
     * @return DocumentWithCompound
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
     * @return DocumentWithCompound
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
     * @return DocumentWithCompound
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
     * @return DocumentWithCompound
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
     * @return DocumentWithCompound
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
     * @return DocumentWithCompound
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
     * @return DocumentWithCompound
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
        $className="DocumentWithCompound";
        return $className;
    }

    public function __toString()
    {
        return $this->text;
    }
}