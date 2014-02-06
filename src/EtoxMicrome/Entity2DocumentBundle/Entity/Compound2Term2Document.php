<?php

namespace EtoxMicrome\Entity2DocumentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Compound2Term2Document
 *
 * @ORM\Table(indexes={ @ORM\Index(name="sentenceId_index", columns={"sentenceId"}), @ORM\Index(name="compound_index", columns={"compound"}), @ORM\Index(name="term_index", columns={"term"}) })
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
     * @ORM\Column(name="sentenceId", type="string", length=200)
     */

    private $sentenceId;

    /**
     * @var string
     *
     * @ORM\Column(name="compound", type="string", length=800)
     */
    private $compound;

    /**
     * @var string
     *
     * @ORM\Column(name="term", type="string", length=500)
     */
    private $term;

    /**
     * @var float
     *
     * @ORM\Column(name="relationScore", type="float")
     */
    private $relationScore;

    /**
     * @var string
     *
     * @ORM\Column(name="relationQualifier", type="string", length=2)
     */
    private $relationQualifier;

    /**
     * @var string
     *
     * @ORM\Column(name="relationType", type="string", length=500)
     */
    private $relationType;

    /**
     * @var string
     *
     * @ORM\Column(name="relationEvidence", type="text")
     */
    private $relationEvidence;

    /**
     * @var string
     *
     * @ORM\Column(name="sentence", type="text")
     */
    private $sentence;


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
     * Set compound
     *
     * @param string $compound
     * @return Compound2Term2Document
     */
    public function setCompound($compound)
    {
        $this->compound = $compound;

        return $this;
    }

    /**
     * Get compound
     *
     * @return string
     */
    public function getCompound()
    {
        return $this->compound;
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
}
