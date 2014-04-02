<?php

namespace EtoxMicrome\Entity2DocumentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Compound2Marker2Document
 *
 * @ORM\Table(indexes={ @ORM\Index(name="compound2Marker2Document_sentenceId_index", columns={"""sentenceId"""}), @ORM\Index(name="compound2Marker2Document_compound_index", columns={"""compoundName"""}), @ORM\Index(name="compound2Marker2Document_liverMarkerName_index", columns={"""liverMarkerName"""}), @ORM\Index(name="compound2marker2document_document_id", columns={"document_id"}), @ORM\Index(name="compound2marker2document_relation_score", columns={"""relationScore"""}), @ORM\Index(name="compound2marker2document_relation_type", columns={"""relationType"""}) } )
 * @ORM\Entity(repositoryClass="EtoxMicrome\Entity2DocumentBundle\Entity\Compound2Marker2DocumentRepository")
 */
class Compound2Marker2Document
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
     * @ORM\ManyToOne(targetEntity="EtoxMicrome\DocumentBundle\Entity\Document", inversedBy="compound2marker2document")
     * @ORM\JoinColumn(name="document_id", referencedColumnName="id")
     */

    private $document;

    /**
     * @var string
     *
     * @ORM\Column(name="""compoundName""", type="string", length=800)
     */
    private $compound;

    /**
     * @var string
     *
     * @ORM\Column(name="""liverMarkerName""", type="string", length=500)
     */
    private $liverMarkerName;

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
     * @return Compound2Marker2Document
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
     * Set compound
     *
     * @param integer $compound
     * @return Compound2Marker2Document
     */
    public function setCompound($compound)
    {
        $this->compound = $compound;

        return $this;
    }

    /**
     * Get compound
     *
     * @return integer
     */
    public function getCompound()
    {
        return $this->compound;
    }

    /**
     * Set liverMarkerName
     *
     * @param string $liverMarkerName
     * @return Compound2Marker2Document
     */
    public function setLiverMarkerName($liverMarkerName)
    {
        $this->liverMarkerName = $liverMarkerName;

        return $this;
    }

    /**
     * Get liverMarkerName
     *
     * @return string
     */
    public function getLiverMarkerName()
    {
        return $this->liverMarkerName;
    }

    /**
     * Set relationScore
     *
     * @param float $relationScore
     * @return Compound2Marker2Document
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
     * @return Compound2Marker2Document
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
     * @return Compound2Marker2Document
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
     * @return Compound2Marker2Document
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
     * @return Compound2Marker2Document
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
     * @return Compound2Marker2Document
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
     * Set created
     *
     * @param \DateTime $created
     * @return Compound2Marker2Document
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
     * @return Compound2Marker2Document
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
