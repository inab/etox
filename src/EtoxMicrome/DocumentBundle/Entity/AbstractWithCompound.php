<?php

namespace EtoxMicrome\DocumentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AbstractWithCompound
 *
 * @ORM\Table(indexes={@ORM\Index(name="pmid_index", columns={"pmid"})})
 * @ORM\Entity(repositoryClass="EtoxMicrome\DocumentBundle\Entity\AbstractWithCompoundRepository")
 */
class AbstractWithCompound
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
     * @ORM\Column(name="pmid", type="string", length=255)
     */
    private $pmid;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="text")
     */
    private $title;

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
     * Set pmid
     *
     * @param string $pmid
     * @return Abstracts
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
     * Set title
     *
     * @param string $title
     * @return Abstract
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Abstract
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
     * @return Abstracts
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
     * Set created
     *
     * @param \DateTime $created
     * @return Abstracts
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
     * @return Abstracts
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

    public function getClassName()
    {
        $className="AbstractWithCompound";
        return $className;
    }

    public function __toString()
    {
        return $this->text;
    }
}