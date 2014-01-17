<?php

namespace EtoxMicrome\DocumentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Document
 *
 * @ORM\Table(indexes={ @ORM\Index(name="uid_index", columns={"uid"}), @ORM\Index(name="kind_index", columns={"kind"}), @ORM\Index(name="sentenceId_index", columns={"sentenceId"}), @ORM\Index(name="hepval_index", columns={"hepval"}), @ORM\Index(name="cardval_index", columns={"cardval"}), @ORM\Index(name="nephval_index", columns={"nephval"}), @ORM\Index(name="phosval_index", columns={"phosval"}) })
 * @ORM\Entity(repositoryClass="EtoxMicrome\DocumentBundle\Entity\DocumentRepository")
 */
class Document
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
     * @ORM\Column(name="sentenceId", type="string", length=255)
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
     * @ORM\OneToMany(targetEntity="EtoxMicrome\Entity2DocumentBundle\Entity\Entity2Document", mappedBy="document")
     **/
    private $entity2document;

    /**
     * @ORM\OneToMany(targetEntity="EtoxMicrome\Entity2DocumentBundle\Entity\Cytochrome2Document", mappedBy="document")
     **/
    private $cytochrome2document;

    /**
     * @ORM\OneToMany(targetEntity="EtoxMicrome\Entity2DocumentBundle\Entity\HepKeywordTermNorm2Document", mappedBy="document")
     **/
    private $hepKeywordTermNorm2document;

    /**
     * @ORM\OneToMany(targetEntity="EtoxMicrome\Entity2DocumentBundle\Entity\HepKeywordTermVariant2Document", mappedBy="document")
     **/
    private $hepKeywordTermVariant2document;




    /**
    * Constructor de la clase
    **/
    public function __construct() {
        $this->entity2document = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cytochrome2document = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return Document
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
     * @return Document
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
     * @return Document
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
     * @return Document
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
     * @return Document
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
     * @return Document
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
     * @return Document
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
     * @return Document
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
     * Set created
     *
     * @param \DateTime $created
     * @return Document
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
     * @return Document
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
     * Set entity2document
     *
     * @return integer
     */
    public function setEntity2Document($entity2document)
    {
        $this->entity2document =$entity2document;
        return $this;
    }

    /**
     * Get entity2Document
     *
     * @return integer
     */
    public function getEntity2Document()
    {
        return $this->entity2document;
    }

    /**
     * Set cytochrome2document
     *
     * @return integer
     */
    public function setCytochrome2Document($cytochrome2document)
    {
        $this->cytochrome2document =$cytochrome2document;
        return $this;
    }

    /**
     * Get cytochrome2Document
     *
     * @return integer
     */
    public function getCytochrome2Document()
    {
        return $this->cytochrome2document;
    }

    /**
     * Set setHepKeywordTermNorm2document
     *
     * @return integer
     */
    public function setHepKeywordTermNorm2document($hepKeywordTermNorm2document)
    {
        $this->hepKeywordTermNorm2document =$hepKeywordTermNorm2document;
        return $this;
    }

    /**
     * Get hepKeywordTermNorm2document
     *
     * @return integer
     */
    public function getHepKeywordTermNorm2document()
    {
        return $this->hepKeywordTermNorm2document;
    }




    /**
     * Set hepKeywordTermVariant2document
     *
     * @return integer
     */
    public function setHepKeywordTermVariant2document($hepKeywordTermVariant2document)
    {
        $this->hepKeywordTermVariant2document =$hepKeywordTermVariant2document;
        return $this;
    }

    /**
     * Get hepKeywordTermVariant2document
     *
     * @return integer
     */
    public function getHepKeywordTermVariant2document()
    {
        return $this->hepKeywordTermVariant2document;
    }

    /**
     * Get className
     *
     * @return string
     */
    public function getClassName()
    {
        $className="Document";
        return $className;
    }

    public function __toString()
    {
        return $this->text;
    }
}
