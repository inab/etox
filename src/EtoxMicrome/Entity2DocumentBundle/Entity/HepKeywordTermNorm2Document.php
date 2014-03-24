<?php

namespace EtoxMicrome\Entity2DocumentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HepKeywordTermNorm2Document
 *
 * @ORM\Table(indexes={ @ORM\Index(name="hepKeywordTermNorm_kind_index", columns={"kind"}) } )
 * @ORM\Entity(repositoryClass="EtoxMicrome\Entity2DocumentBundle\Entity\HepKeywordTermNorm2DocumentRepository")
 */
class HepKeywordTermNorm2Document
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
     * @ORM\Column(name="""hepKeywordNorm""", type="string", length=500)
     */
    private $hepKeywordNorm;

    /**
     * @ORM\ManyToOne(targetEntity="EtoxMicrome\DocumentBundle\Entity\Document", inversedBy="hepKeywordTermNorm2document")
     * @ORM\JoinColumn(name="document_id", referencedColumnName="id")
     */
    private $document;

    /**
     *
     * @ORM\Column(name="kind", type="string",columnDefinition="ENUM('pubmed', 'epar', 'nda', 'fulltext')")
     */
    private $kind;

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
     * Set hepKeywordNorm
     *
     * @param string $hepKeywordNorm
     * @return HepKeywordTermNorm2Document
     */
    public function setHepKeywordNorm($hepKeywordNorm)
    {
        $this->hepKeywordNorm = $hepKeywordNorm;

        return $this;
    }

    /**
     * Get hepKeywordNorm
     *
     * @return string
     */
    public function getHepKeywordNorm()
    {
        return $this->hepKeywordNorm;
    }

    /**
     * Set document
     * @return HepKeywordTermNorm2Document
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
     * Set kind
     *
     * @param string $kind
     * @return HepKeywordTermNorm2Document
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
     * Set curation
     *
     * @param integer $curation
     * @return HepKeywordTermNorm2Document
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
     * @return HepKeywordTermNorm2Document
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
     * @return HepKeywordTermNorm2Document
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
        return ("HepKeywordTermNorm2Document");
    }
}
