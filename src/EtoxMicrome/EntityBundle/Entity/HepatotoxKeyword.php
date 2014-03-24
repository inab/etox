<?php

namespace EtoxMicrome\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HepatotoxKeyword
 *
 * @ORM\Table(indexes={@ORM\Index(name="hepatotoxKeyword_term_index", columns={"term"}),@ORM\Index(name="hepatotoxKeyword_norm_index", columns={"norm"}),@ORM\Index(name="hepatotoxKeyword_pos_index", columns={"pos"}),@ORM\Index(name="hepatotoxKeyword_EFPIA_index", columns={"""EFPIA"""}),@ORM\Index(name="hepatotoxKeyword_COSTART_index", columns={"""COSTART"""}),@ORM\Index(name="hepatotoxKeyword_MedDRA_index", columns={"""MedDRA"""}),@ORM\Index(name="hepatotoxKeyword_MPheno_index", columns={"""MPheno"""}),@ORM\Index(name="hepatotoxKeyword_adverse_events_index", columns={"""adverseEvents"""}),@ORM\Index(name="hepatotoxKeyword_do_index", columns={"do"}),@ORM\Index(name="hepatotoxKeyword_gemina_symptom_index", columns={"""geminaSymptom"""}),@ORM\Index(name="hepatotoxKeyword_human_phenotype_index", columns={"""humanPhenotype"""}),@ORM\Index(name="hepatotoxKeyword_mpath_index", columns={"mpath"}),@ORM\Index(name="hepatotoxKeyword_MESH_OMIM_index", columns={"""MESH_OMIM"""}),@ORM\Index(name="hepatotoxKeyword_polysearch_index", columns={"polysearch"}),@ORM\Index(name="hepatotoxKeyword_etox_index", columns={"etox"}) } )
 * @ORM\Entity(repositoryClass="EtoxMicrome\EntityBundle\Entity\HepatotoxKeywordRepository")
 */
class HepatotoxKeyword
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
     * @ORM\Column(name="validated", type="integer")
     */
    private $validated;

    /**
     * @var string
     *
     * @ORM\Column(name="term", type="string", length=500)
     */
    private $term;

    /**
     * @var string
     *
     * @ORM\Column(name="norm", type="string", length=500)
     */
    private $norm;

    /**
     * @var string
     *
     * @ORM\Column(name="pos", type="string", length=500)
     */
    private $pos;

    /**
     * @var string
     *
     * @ORM\Column(name="""EFPIA""", type="string", length=30, nullable=true)
     */
    private $EFPIA;

    /**
     * @var string
     *
     * @ORM\Column(name="""COSTART""", type="string", length=30, nullable=true)
     */
    private $COSTART;

    /**
     * @var string
     *
     * @ORM\Column(name="""MedDRA""", type="string", length=30, nullable=true)
     */
    private $MedDRA;

    /**
     * @var string
     *
     * @ORM\Column(name="""MPheno""", type="string", length=30, nullable=true)
     */
    private $MPheno;

    /**
     * @var string
     *
     * @ORM\Column(name="""adverseEvents""", type="string", length=30, nullable=true)
     */
    private $adverseEvents;

    /**
     * @var string
     *
     * @ORM\Column(name="do", type="string", length=30, nullable=true)
     */
    private $do;

    /**
     * @var string
     *
     * @ORM\Column(name="""geminaSymptom""", type="string", length=30, nullable=true)
     */
    private $geminaSymptom;

    /**
     * @var string
     *
     * @ORM\Column(name="""humanPhenotype""", type="string", length=30, nullable=true)
     */
    private $humanPhenotype;

    /**
     * @var string
     *
     * @ORM\Column(name="mpath", type="string", length=30, nullable=true)
     */
    private $mpath;

    /**
     * @var string
     *
     * @ORM\Column(name="""MESH_OMIM""", type="string", length=30, nullable=true)
     */
    private $MESH_OMIM;

    /**
     * @var string
     *
     * @ORM\Column(name="polysearch", type="string", length=30, nullable=true)
     */
    private $polysearch;

    /**
     * @var string
     *
     * @ORM\Column(name="etox", type="string", length=30, nullable=true)
     */
    private $etox;

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
     * Set validated
     *
     * @param integer $validated
     * @return HepatotoxKeyword
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;
        return $this;
    }

    /**
     * Get validated
     *
     * @return integer
     */
    public function getValidated()
    {
        return $this->validated;
    }

    /**
     * Set term
     *
     * @param string $term
     * @return HepatotoxKeyword
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
     * Set norm
     *
     * @param string $norm
     * @return HepatotoxKeyword
     */
    public function setNorm($norm)
    {
        $this->norm = $norm;

        return $this;
    }

    /**
     * Get norm
     *
     * @return string
     */
    public function getNorm()
    {
        return $this->norm;
    }

    /**
     * Set pos
     *
     * @param string $pos
     * @return HepatotoxKeyword
     */
    public function setPos($pos)
    {
        $this->pos = $pos;

        return $this;
    }

    /**
     * Get pos
     *
     * @return string
     */
    public function getPos()
    {
        return $this->pos;
    }

    /**
     * Set EFPIA
     *
     * @param string $EFPIA
     * @return HepatotoxKeyword
     */
    public function setEFPIA($EFPIA)
    {
        $this->EFPIA = $EFPIA;

        return $this;
    }

    /**
     * Get EFPIA
     *
     * @return string
     */
    public function getEFPIA()
    {
        return $this->EFPIA;
    }

    /**
     * Set COSTART
     *
     * @param string $COSTART
     * @return HepatotoxKeyword
     */
    public function setCOSTART($COSTART)
    {
        $this->COSTART = $COSTART;

        return $this;
    }

    /**
     * Get COSTART
     *
     * @return string
     */
    public function getCOSTART()
    {
        return $this->COSTART;
    }

    /**
     * Set MedDRA
     *
     * @param string $MedDRA
     * @return HepatotoxKeyword
     */
    public function setMedDRA($MedDRA)
    {
        $this->MedDRA = $MedDRA;

        return $this;
    }

    /**
     * Get MedDRA
     *
     * @return string
     */
    public function getMedDRA()
    {
        return $this->MedDRA;
    }

    /**
     * Set MPheno
     *
     * @param string $MPheno
     * @return HepatotoxKeyword
     */
    public function setMPheno($MPheno)
    {
        $this->MPheno = $MPheno;

        return $this;
    }

    /**
     * Get MPheno
     *
     * @return string
     */
    public function getMPheno()
    {
        return $this->MPheno;
    }

    /**
     * Set adverseEvents
     *
     * @param string $adverseEvents
     * @return HepatotoxKeyword
     */
    public function setAdverseEvents($adverseEvents)
    {
        $this->adverseEvents = $adverseEvents;

        return $this;
    }

    /**
     * Get adverseEvents
     *
     * @return string
     */
    public function getAdverseEvents()
    {
        return $this->adverseEvents;
    }

    /**
     * Set do
     *
     * @param string $do
     * @return HepatotoxKeyword
     */
    public function setDo($do)
    {
        $this->do = $do;

        return $this;
    }

    /**
     * Get do
     *
     * @return string
     */
    public function getDo()
    {
        return $this->do;
    }

    /**
     * Set geminaSymptom
     *
     * @param string $geminaSymptom
     * @return HepatotoxKeyword
     */
    public function setGeminaSymptom($geminaSymptom)
    {
        $this->geminaSymptom = $geminaSymptom;

        return $this;
    }

    /**
     * Get geminaSymptom
     *
     * @return string
     */
    public function getGeminaSymptom()
    {
        return $this->geminaSymptom;
    }

    /**
     * Set humanPhenotype
     *
     * @param string $humanPhenotype
     * @return HepatotoxKeyword
     */
    public function setHumanPhenotype($humanPhenotype)
    {
        $this->humanPhenotype = $humanPhenotype;

        return $this;
    }

    /**
     * Get humanPhenotype
     *
     * @return string
     */
    public function getHumanPhenotype()
    {
        return $this->humanPhenotype;
    }

    /**
     * Set mpath
     *
     * @param string $mpath
     * @return HepatotoxKeyword
     */
    public function setMpath($mpath)
    {
        $this->mpath = $mpath;

        return $this;
    }

    /**
     * Get mpath
     *
     * @return string
     */
    public function getMpath()
    {
        return $this->mpath;
    }

    /**
     * Set MESH_OMIM
     *
     * @param string $MESH_OMIM
     * @return HepatotoxKeyword
     */
    public function setMESH_OMIM($MESH_OMIM)
    {
        $this->MESH_OMIM = $MESH_OMIM;

        return $this;
    }

    /**
     * Get MESH_OMIM
     *
     * @return string
     */
    public function getMESH_OMIM()
    {
        return $this->MESH_OMIM;
    }

    /**
     * Set polysearch
     *
     * @param string $polysearch
     * @return HepatotoxKeyword
     */
    public function setPolysearch($polysearch)
    {
        $this->polysearch = $polysearch;
        return $this;
    }

    /**
     * Get polysearch
     *
     * @return string
     */
    public function getPolysearch()
    {
        return $this->polysearch;
    }

    /**
     * Set etox
     *
     * @param string $etox
     * @return HepatotoxKeyword
     */
    public function setEtox($etox)
    {
        $this->etox = $etox;

        return $this;
    }

    /**
     * Get etox
     *
     * @return string
     */
    public function getEtox()
    {
        return $this->etox;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Term
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
     * @return Term
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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->term;
    }
}