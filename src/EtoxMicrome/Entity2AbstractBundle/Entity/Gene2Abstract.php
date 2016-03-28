<?php

namespace EtoxMicrome\Entity2AbstractBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gene2Abstract
 *
 * @ORM\Table (indexes={@ORM\Index(name="gene2Abstract_genename", columns={"gene_name"}), @ORM\Index(name="gene2Abstract_geneid_index", columns={"gene_id"}), @ORM\Index(name="gene2abstract_hepval_index", columns={"hepval"}), @ORM\Index(name="gene2abstract_patterncount_index", columns={"patternCount"}), @ORM\Index(name="gene2abstract_rulescore_index", columns={"ruleScore"}), @ORM\Index(name="gene2abstract_heptermnormscore_index", columns={"hepTermNormScore"}), @ORM\Index(name="gene2abstract_heptermvarscore_index", columns={"hepTermVarScore"}), @ORM\Index(name="gene2abstract_svmconfidence_index", columns={"svmConfidence"}), @ORM\Index(name="gene2abstract_toxicology_index", columns={"toxicology"}), @ORM\Index(name="gene2abstract_biomarker_index", columns={"biomarker"}) } )
 * @ORM\Entity(repositoryClass="EtoxMicrome\Entity2AbstractBundle\Entity\Gene2AbstractRepository")
 */
class Gene2Abstract
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
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="EtoxMicrome\DocumentBundle\Entity\Abstracts", inversedBy="gene2abstract")
     * @ORM\JoinColumn(name="abstracts_id", referencedColumnName="id")
     */
    private $abstracts;

    /**
     * @var string
     *
     * @ORM\Column(name="gene_name", type="string", length=1024)
     */
    private $geneName;

    /**
     * @var string
     *
     * @ORM\Column(name="gene_id", type="string", length=255)
     */
    private $geneId;

    /**
     * @var integer
     *
     * @ORM\Column(name="tax_id", type="integer")
     */
    private $taxId;

    /**
     * @var integer
     *
     * @ORM\Column(name="tax_id_validated", type="integer")
     */
    private $taxIdValidated;

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
     * @var integer
     *
     * @ORM\Column(name="""curation""", type="integer", nullable=true)
     */
    //private $curation;

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
     * Set pmid
     *
     * @param string $pmid
     * @return Gene2Abstract
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
     * Set geneName
     *
     * @param string $geneName
     * @return Gene2Abstract
     */
    public function setGeneName($geneName)
    {
        $this->geneName = $geneName;

        return $this;
    }

    /**
     * Get geneName
     *
     * @return string
     */
    public function getGeneName()
    {
        return $this->geneName;
    }

    /**
     * Set geneId
     *
     * @param string $geneId
     * @return Gene2Abstract
     */
    public function setGeneId($geneId)
    {
        $this->geneId = $geneId;

        return $this;
    }

    /**
     * Get geneId
     *
     * @return string
     */
    public function getGeneId()
    {
        return $this->geneId;
    }

    /**
     * Set taxId
     *
     * @param integer $taxId
     * @return Gene2Abstract
     */
    public function setTaxId($taxId)
    {
        $this->taxId = $taxId;

        return $this;
    }

    /**
     * Get taxId
     *
     * @return integer
     */
    public function getTaxId()
    {
        return $this->taxId;
    }

    /**
     * Set taxIdValidated
     *
     * @param integer $taxIdValidated
     * @return Gene2Abstract
     */
    public function setTaxIdValidated($taxIdValidated)
    {
        $this->taxIdValidated = $taxIdValidated;

        return $this;
    }

    /**
     * Get taxIdValidated
     *
     * @return integer
     */
    public function getTaxIdValidated()
    {
        return $this->taxIdValidated;
    }

     /**
     * Set hepval
     *
     * @param float $hepval
     * @return Gene2Abstract
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
     * @return Gene2Abstract
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
     * @return Gene2Abstract
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
     * @return Gene2Abstract
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
     * @return Gene2Abstract
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
     * @return Gene2Abstract
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
     * @return Gene2Abstract
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
     * @return Gene2Abstract
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
     * Set curation
     *
     * @param integer $curation
     * @return Gene2Abstract
     */
    //public function setCuration($curation)
    //{
    //    $this->curation = $curation;

    //    return $this;
    //}

    /**
     * Get curation
     *
     * @return integer
     */
    //public function getCuration()
    //{
    //    return $this->curation;
    //}

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Gene2Abstract
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
     * @return Gene2Abstract
     */
    public function setUpdate($updated)
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
