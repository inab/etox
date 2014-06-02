<?php

namespace EtoxMicrome\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Drugbank
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EtoxMicrome\EntityBundle\Entity\DrugbankRepository")
 */
class Drugbank
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
     * @ORM\Column(name="drugbankid", type="string", length=10)
     */
    private $drugbankid;

    /**
     * @var string
     *
     * @ORM\Column(name="drugbankname", type="string", length=255)
     */
    private $drugbankname;

    /**
     * @var string
     *
     * @ORM\Column(name="approval", type="string", length=255)
     */
    private $approval;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=255)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="target_relation", type="text")
     */
    private $targetRelation;

    /**
     * @var integer
     *
     * @ORM\Column(name="hepval_counter", type="integer", nullable=true)
     */
    private $hepvalCounter;

    /**
     * @var integer
     *
     * @ORM\Column(name="svm_confidence_counter", type="integer", nullable=true)
     */
    private $svmConfidenceCounter;

    /**
     * @var integer
     *
     * @ORM\Column(name="pattern_counter", type="integer", nullable=true)
     */
    private $patternCounter;

    /**
     * @var integer
     *
     * @ORM\Column(name="term_counter", type="integer", nullable=true)
     */
    private $termCounter;

    /**
     * @var integer
     *
     * @ORM\Column(name="rule_counter", type="integer", nullable=true)
     */
    private $ruleCounter;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_mentions", type="integer", nullable=true)
     */
    private $totalMentions;

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
     * Set drugbankid
     *
     * @param string $drugbankid
     * @return Drugbank
     */
    public function setDrugbankid($drugbankid)
    {
        $this->drugbankid = $drugbankid;

        return $this;
    }

    /**
     * Get drugbankid
     *
     * @return string
     */
    public function getDrugbankid()
    {
        return $this->drugbankid;
    }

    /**
     * Set drugbankname
     *
     * @param string $drugbankname
     * @return Drugbank
     */
    public function setDrugbankname($drugbankname)
    {
        $this->drugbankname = $drugbankname;

        return $this;
    }

    /**
     * Get drugbankname
     *
     * @return string
     */
    public function getDrugbankname()
    {
        return $this->drugbankname;
    }

    /**
     * Set approval
     *
     * @param string $approval
     * @return Drugbank
     */
    public function setApproval($approval)
    {
        $this->approval = $approval;

        return $this;
    }

    /**
     * Get approval
     *
     * @return string
     */
    public function getApproval()
    {
        return $this->approval;
    }

    /**
     * Set category
     *
     * @param string $category
     * @return Drugbank
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set targetRelation
     *
     * @param string $targetRelation
     * @return Drugbank
     */
    public function setTargetRelation($targetRelation)
    {
        $this->targetRelation = $targetRelation;

        return $this;
    }

    /**
     * Get targetRelation
     *
     * @return string
     */
    public function getTargetRelation()
    {
        return $this->targetRelation;
    }

    /**
     * Set hepvalCounter
     *
     * @param integer $hepvalCounter
     * @return Drugbank
     */
    public function setHepvalCounter($hepvalCounter)
    {
        $this->hepvalCounter = $hepvalCounter;

        return $this;
    }

    /**
     * Get hepvalCounter
     *
     * @return integer
     */
    public function getHepvalCounter()
    {
        return $this->hepvalCounter;
    }

    /**
     * Set svmConfidenceCounter
     *
     * @param integer $svmConfidenceCounter
     * @return Drugbank
     */
    public function setSvmConfidenceCounter($svmConfidenceCounter)
    {
        $this->svmConfidenceCounter = $svmConfidenceCounter;

        return $this;
    }

    /**
     * Get svmConfidenceCounter
     *
     * @return integer
     */
    public function getSvmConfidenceCounter()
    {
        return $this->svmConfidenceCounter;
    }

    /**
     * Set patternCounter
     *
     * @param integer $patternCounter
     * @return Drugbank
     */
    public function setPatternCounter($patternCounter)
    {
        $this->patternCounter = $patternCounter;

        return $this;
    }

    /**
     * Get patternCounter
     *
     * @return integer
     */
    public function getPatternCounter()
    {
        return $this->patternCounter;
    }

    /**
     * Set termCounter
     *
     * @param integer $termCounter
     * @return Drugbank
     */
    public function setTermCounter($termCounter)
    {
        $this->termCounter = $termCounter;

        return $this;
    }

    /**
     * Get termCounter
     *
     * @return integer
     */
    public function getTermCounter()
    {
        return $this->termCounter;
    }

    /**
     * Set ruleCounter
     *
     * @param integer $ruleCounter
     * @return Drugbank
     */
    public function setRuleCounter($ruleCounter)
    {
        $this->ruleCounter = $ruleCounter;

        return $this;
    }

    /**
     * Get ruleCounter
     *
     * @return integer
     */
    public function getRuleCounter()
    {
        return $this->ruleCounter;
    }

    /**
     * Set totalMentions
     *
     * @param integer $totalMentions
     * @return Drugbank
     */
    public function setTotalMentions($totalMentions)
    {
        $this->totalMentions = $totalMentions;

        return $this;
    }

    /**
     * Get totalMentions
     *
     * @return integer
     */
    public function getTotalMentions()
    {
        return $this->totalMentions;
    }
}
