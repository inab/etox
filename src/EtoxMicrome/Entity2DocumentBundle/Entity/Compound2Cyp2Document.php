<?php

namespace EtoxMicrome\Entity2DocumentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Compound2Cyp2Document
 *
 * @ORM\Table(indexes={ @ORM\Index(name="compound2cyp2document_sentenceId_index_new", columns={"""sentenceId"""}), @ORM\Index(name="compound2Cyp2Document_compound_name_index_new", columns={"""compoundName"""}), @ORM\Index(name="compound2Cyp2Document_cyp_index_new", columns={"""cypsMention"""}), @ORM\Index(name="compound2cyp2document_document_id_new", columns={"document_id"}), @ORM\Index(name="compound2cyp2document_inhibition_new", columns={"""inhibitionScore"""}), @ORM\Index(name="compound2cyp2document_induction_new", columns={"""inductionScore"""}), @ORM\Index(name="compound2cyp2document_metabolism_new", columns={"""metabolismScore"""}), @ORM\Index(name="compound2cyp2document_svm_inhibition_new", columns={"""svmInhibition"""}), @ORM\Index(name="compound2cyp2document_svm_induction_new", columns={"""svmInduction"""}), @ORM\Index(name="compound2cyp2document_svm_metabolism_new", columns={"""svmMetabolism"""}), @ORM\Index(name="compound2cyp2document_curation_new", columns={"curation"}) },name="compound2cyp2document_new" )
 * @ORM\Entity(repositoryClass="EtoxMicrome\Entity2DocumentBundle\Entity\Compound2Cyp2DocumentRepository")
 */
class Compound2Cyp2Document
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
     * @ORM\ManyToOne(targetEntity="EtoxMicrome\DocumentBundle\Entity\Document", inversedBy="compound2cyp2document")
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
     * @ORM\Column(name="""cypsMention""", type="string", length=200)
     */
    private $cypsMention;

    /**
     * @var string
     *
     * @ORM\Column(name="""patternRelation""", type="string", length=15)
     */
    private $patternRelation;

    /**
     * @var string
     *
     * @ORM\Column(name="""patternEvidence""", type="text")
     */
    private $patternEvidence;

    /**
     * @var string
     *
     * @ORM\Column(name="""cypsCanonical""", type="string", length=50)
     */
    private $cypsCanonical;

    /**
     * @var string
     *
     * @ORM\Column(name="sentence", type="text")
     */
    private $sentence;

    /**
     * @var string
     *
     * @ORM\Column(name="""svmInduction""", type="string", length=15)
     */
    private $svmInduction;

    /**
     * @var string
     *
     * @ORM\Column(name="""svmInhibition""", type="string", length=15)
     */
    private $svmInhibition;

    /**
     * @var string
     *
     * @ORM\Column(name="""svmMetabolism""", type="string", length=15)
     */
    private $svmMetabolism;

    /**
     * @var integer
     *
     * @ORM\Column(name="""inductionScore""", type="integer")
     */
    private $inductionScore;

    /**
     * @var integer
     *
     * @ORM\Column(name="""inhibitionScore""", type="integer")
     */
    private $inhibitionScore;

    /**
     * @var integer
     *
     * @ORM\Column(name="""metabolismScore""", type="integer")
     */
    private $metabolismScore;

    /**
     * @var integer
     *
     * @ORM\Column(name="""sumScore""", type="integer")
     */
    private $sumScore;

    /**
     * @var string
     *
     * @ORM\Column(name="""relationQualifier""", type="string", length=2)
     */
    private $relationQualifier;

    /**
     * @var integer
     *
     * @ORM\Column(name="""compoundQualifier""", type="integer")
     */
    private $compoundQualifier;

    /**
     * @var integer
     *
     * @ORM\Column(name="curation", type="integer", nullable=true)
     */
    private $curation;

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
     * @return Compound2Cyp2Document
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
     * @return Compound2Cyp2Document
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
     * Set cyps_mention
     *
     * @param string $cypsMention
     * @return Compound2Cyp2Document
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
     * Set patternRelation
     *
     * @param string $patternRelation
     * @return Compound2Cyp2Document
     */
    public function setPatternRelation($patternRelation)
    {
        $this->patternRelation = $patternRelation;

        return $this;
    }

    /**
     * Get patternRelation
     *
     * @return string
     */
    public function getPatternRelation()
    {
        return $this->patternRelation;
    }

    /**
     * Set patternEvidence
     *
     * @param string $patternEvidence
     * @return Compound2Cyp2Document
     */
    public function setPatternEvidence($patternEvidence)
    {
        $this->patternEvidence = $patternEvidence;

        return $this;
    }

    /**
     * Get patternEvidence
     *
     * @return string
     */
    public function getPatternEvidence()
    {
        return $this->patternEvidence;
    }

    /**
     * Set cypsCanonical
     *
     * @param string $cypsCanonical
     * @return Compound2Cyp2Document
     */
    public function setCypsCanonical()
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
     * Set sentence
     *
     * @param string $sentence
     * @return Compound2Cyp2Document
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
     * Get svmInduction
     *
     * @return string
     */
    public function getSvmInduction()
    {
        return $this->svmInduction;
    }

    /**
     * Set svmInduction
     *
     * @param string $svmInduction
     * @return Compound2Cyp2Document
     */
    public function setSvmInduction($svmInduction)
    {
        $this->svmInduction = $svmInduction;

        return $this;
    }

    /**
     * Get svmInhibition
     *
     * @return string
     */
    public function getSvmInhibition()
    {
        return $this->svmInhibition;
    }

    /**
     * Set svmInhibition
     *
     * @param string $svmInhibition
     * @return Compound2Cyp2Document
     */
    public function setSvmInhibition($svmInhibition)
    {
        $this->svmInhibition = $svmInhibition;

        return $this;
    }

    /**
     * Get svmMetabolism
     *
     * @return string
     */
    public function getSvmMetabolism()
    {
        return $this->svmMetabolism;
    }

    /**
     * Set svmMetabolism
     *
     * @param string $svmMetabolism
     * @return Compound2Cyp2Document
     */
    public function setSvmMetabolism($svmMetabolism)
    {
        $this->svmMetabolism = $svmMetabolism;

        return $this;
    }

    /**
     * Get inductionScore
     *
     * @return integer
     */
    public function getInductionScore()
    {
        return $this->inductionScore;
    }

    /**
     * Set inductionScore
     *
     * @param integer $inductionScore
     * @return Compound2Cyp2Document
     */
    public function setInductionScore($inductionScore)
    {
        $this->inductionScore = $inductionScore;

        return $this;
    }

    /**
     * Get inhibitionScore
     *
     * @return integer
     */
    public function getInhibitionScore()
    {
        return $this->inhibitionScore;
    }

    /**
     * Set inhibitionScore
     *
     * @param integer $inhibitionScore
     * @return Compound2Cyp2Document
     */
    public function setInhibitionScore($inhibitionScore)
    {
        $this->inhibitionScore = $inhibitionScore;

        return $this;
    }

    /**
     * Get metabolismScore
     *
     * @return integer
     */
    public function getMetabolismScore()
    {
        return $this->metabolismScore;
    }

    /**
     * Set metabolismScore
     *
     * @param integer $metabolismScore
     * @return Compound2Cyp2Document
     */
    public function setMetabolismScore($metabolismScore)
    {
        $this->metabolismScore = $metabolismScore;

        return $this;
    }

    /**
     * Get sumScore
     *
     * @return integer
     */
    public function getSumScore()
    {
        return $this->sumScore;
    }

    /**
     * Set sumScore
     *
     * @param integer $sumScore
     * @return Compound2Cyp2Document
     */
    public function setSumScore($sumScore)
    {
        $this->sumScore = $sumScore;

        return $this;
    }

    /**
     * Set relationQualifier
     *
     * @param string $relationQualifier
     * @return Compound2Cyp2Document
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
     * Get compoundQualifier
     *
     * @return integer
     */
    public function getCompoundQualifier()
    {
        return $this->compoundQualifier;
    }

    /**
     * Set compoundQualifier
     *
     * @param integer $compoundQualifier
     * @return Compound2Cyp2Document
     */
    public function setCompoundQualifier($compoundQualifier)
    {
        $this->compoundQualifier = $compoundQualifier;

        return $this;
    }

    /**
     * Set curation
     *
     * @param integer $curation
     * @return Compound2Cyp2Document
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
     * Set created
     *
     * @param \DateTime $created
     * @return Compound2Cyp2Document
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
     * @return Compound2Cyp2Document
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
        $className="Compound2Cyp2Document";
        return $className;
    }

}
