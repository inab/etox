<?php

namespace EtoxMicrome\Entity2DocumentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Compound2Term2Document
 *
 * @ORM\Table(indexes={ @ORM\Index(name="compound2term2document_sentenceId_index", columns={"""sentenceId"""}), @ORM\Index(name="compound2term2document_compound_index", columns={"""compoundName"""}), @ORM\Index(name="compound2term2document_term_index", columns={"term"}), @ORM\Index(name="compound2term2document_document_id", columns={"document_id"}), @ORM\Index(name="compound2term2document_relation_score", columns={"""relationScore"""}) } )
 * @ORM\Entity(repositoryClass="EtoxMicrome\Entity2DocumentBundle\Entity\Compound2Term2DocumentRepository")
 */
class Compound2Term2Document
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
     * @ORM\Column(name="""sentenceId""", type="string", length=200)
     */

    private $sentenceId;

    /**
     * @ORM\ManyToOne(targetEntity="EtoxMicrome\DocumentBundle\Entity\Document", inversedBy="compound2term2document")
     * @ORM\JoinColumn(name="document_id", referencedColumnName="id")
     */

    private $document;

    /**
     * @var string
     *
     * @ORM\Column(name="""compoundName""", type="string", length=800)
     */
    private $compoundName;

    /**
     * @var string
     *
     * @ORM\Column(name="term", type="string", length=500)
     */
    private $term;

    /**
     * @var float
     *
     * @ORM\Column(name="""relationScore""", type="float")
     */
    private $relationScore;

    /**
     * @var string
     *
     * @ORM\Column(name="""relationQualifier""", type="string", length=2)
     */
    private $relationQualifier;

    /**
     * @var string
     *
     * @ORM\Column(name="""relationType""", type="string", length=500)
     */
    private $relationType;

    /**
     * @var string
     *
     * @ORM\Column(name="""relationEvidence""", type="text")
     */
    private $relationEvidence;

    /**
     * @var string
     *
     * @ORM\Column(name="sentence", type="text")
     */
    private $sentence;

    /**
     * @var integer
     *
     * @ORM\Column(name="""compoundQualifier""", type="integer")
     */
    private $compoundQualifier;

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
     * @var float
     *
     * @ORM\Column(name="""compound2TermConfidence""", type="float", nullable=true)
     */
    private $compound2TermConfidence;

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
     * Set sentenceId
     *
     * @param string $sentenceId
     * @return Compound2Term2Document
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
     * Set compoundName
     *
     * @param string $compoundName
     * @return Compound2Term2Document
     */
    public function setCompoundName($compoundName)
    {
        $this->compoundName = $compoundName;

        return $this;
    }

    /**
     * Get compoundName
     *
     * @return string
     */
    public function getCompoundName()
    {
        return $this->compoundName;
    }

    /**
     * Set term
     *
     * @param string $term
     * @return Compound2Term2Document
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
     * Set relationScore
     *
     * @param float $relationScore
     * @return Compound2Term2Document
     */
    public function setRelationScore($relationScore)
    {
        $this->relationScore = $relationScore;

        return $this;
    }

    /**
     * Get relationScore
     *
     * @return float
     */
    public function getRelationScore()
    {
        return $this->relationScore;
    }

    /**
     * Set relationQualifier
     *
     * @param string $relationQualifier
     * @return Compound2Term2Document
     */
    public function setRelationQualifier($relationQualifier)
    {
        $this->relationQualifier = $relationQualifier;

        return $this;
    }

    /**
     * Get relationQualifier
     *
     * @return string
     */
    public function getRelationQualifier()
    {
        return $this->relationQualifier;
    }

    /**
     * Set relationType
     *
     * @param string $relationType
     * @return Compound2Term2Document
     */
    public function setRelationType($relationType)
    {
        $this->relationType = $relationType;

        return $this;
    }

    /**
     * Get relationType
     *
     * @return string
     */
    public function getRelationType()
    {
        return $this->relationType;
    }

    /**
     * Set relationEvidence
     *
     * @param string $relationEvidence
     * @return Compound2Term2Document
     */
    public function setRelationEvidence($relationEvidence)
    {
        $this->relationEvidence = $relationEvidence;

        return $this;
    }

    /**
     * Get relationEvidence
     *
     * @return string
     */
    public function getRelationEvidence()
    {
        return $this->relationEvidence;
    }

    /**
     * Set sentence
     *
     * @param string $sentence
     * @return Compound2Term2Document
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
     * Set compoundQualifier
     *
     * @param integer $compoundQualifier
     * @return Compound2Term2Document
     */
    public function setCompoundQualifier($compoundQualifier)
    {
        $this->compoundQualifier = $compoundQualifier;

        return $this;
    }

    /**
     * Get compoundQualifier
     *
     * @return integer
     */
    public function getCompoundQualifier()
    {
        return $this->compoundQualifier;
    }

    /**
     * Set hepval
     *
     * @param float $hepval
     * @return Compound2Term2Document
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
     * @return Compound2Term2Document
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
     * @return Compound2Term2Document
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
     * @return Compound2Term2Document
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
     * @return Compound2Term2Document
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
     * @return Compound2Term2Document
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
     * @return Compound2Term2Document
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
     * @return Compound2Term2Document
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
     * @return Compound2Term2Document
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
     * Set compound2TermConfidence
     *
     * @param float $compound2TermConfidence
     * @return Compound2Term2Document
     */
    public function setCompound2TermConfidence($compound2TermConfidence)
    {
        $this->compound2TermConfidence = $compound2TermConfidence;

        return $this;
    }

    /**
     * Get compound2TermConfidence
     *
     * @return float
     */
    public function getCompound2TermConfidence()
    {
        return $this->compound2TermConfidence;
    }


    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Compound2Term2Document
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
     * @return Compound2Term2Document
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
