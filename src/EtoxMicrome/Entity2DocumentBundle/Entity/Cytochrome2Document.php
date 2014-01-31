<?php

namespace EtoxMicrome\Entity2DocumentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cytochrome2Document
 *
 * @ORM\Table(indexes={@ORM\Index(name="tagMethod_index", columns={"tagMethod"}), @ORM\Index(name="cypsMention_index", columns={"cypsMention"}) })
 * @ORM\Entity(repositoryClass="EtoxMicrome\Entity2DocumentBundle\Entity\Cytochrome2DocumentRepository")
 */
class Cytochrome2Document
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
     * @ORM\ManyToOne(targetEntity="EtoxMicrome\DocumentBundle\Entity\Document", inversedBy="cytochrome2document")
     * @ORM\JoinColumn(name="document_id", referencedColumnName="id")
     */

    private $document;

    /**
     * @var string
     *
     * @ORM\Column(name="tagMethod", type="string", length=255)
     */
    private $tagMethod;

    /**
     * @var string
     *
     * @ORM\Column(name="baseName", type="string", length=255)
     */
    private $baseName;

    /**
     * @var string
     *
     * @ORM\Column(name="rootName", type="string", length=255)
     */
    private $rootName;

    /**
     * @var string
     *
     * @ORM\Column(name="cypsMention", type="string", length=255)
     */
    private $cypsMention;

    /**
     * @var string
     *
     * @ORM\Column(name="sentence", type="text")
     */
    private $sentence;

    /**
     * @var string
     *
     * @ORM\Column(name="cypsCanonical", type="string", length=255)
     */
    private $cypsCanonical;

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
     * Set tagMethod
     *
     * @param string $tagMethod
     * @return Cytochrome2Document
     */
    public function setTagMethod($tagMethod)
    {
        $this->tagMethod = $tagMethod;

        return $this;
    }

    /**
     * Get tagMethod
     *
     * @return string
     */
    public function getTagMethod()
    {
        return $this->tagMethod;
    }

    /**
     * Set baseName
     *
     * @param string $baseName
     * @return Cytochrome2Document
     */
    public function setBaseName($baseName)
    {
        $this->baseName = $baseName;

        return $this;
    }

    /**
     * Get baseName
     *
     * @return string
     */
    public function getBaseName()
    {
        return $this->baseName;
    }

    /**
     * Set rootName
     *
     * @param string $rootName
     * @return Cytochrome2Document
     */
    public function setRootName($rootName)
    {
        $this->rootName = $rootName;

        return $this;
    }

    /**
     * Get rootName
     *
     * @return string
     */
    public function getRootName()
    {
        return $this->rootName;
    }

    /**
     * Set cypsMention
     *
     * @param string $cypsMention
     * @return Cytochrome2Document
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
     * Set sentence
     *
     * @param string $sentence
     * @return Cytochrome2Document
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
     * Set cypsCanonical
     *
     * @param string $cypsCanonical
     * @return Cytochrome2Document
     */
    public function setCypsCanonical($cypsCanonical)
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
     * Set curation
     *
     * @param integer $curation
     * @return Cytochrome2Document
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
     * @return Cytochrome2Document
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
     * @return Cytochrome2Document
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
