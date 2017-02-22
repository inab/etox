<?php

namespace EtoxMicrome\ToxicEndpointBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ToxicEndpoint
 *
 * @ORM\Table(indexes={@ORM\Index(name="toxicEndpoint_uid_index", columns={"uid"}),@ORM\Index(name="toxicEndpoint_entityId1_index", columns={"entityId1"}),@ORM\Index(name="toxicEndpoint_entityId2_index", columns={"entityId2"}) } ,name="""ToxicEndpoint""")
 * @ORM\Entity(repositoryClass="EtoxMicrome\ToxicEndpointBundle\Entity\ToxicEndpointRepository")
 */
class ToxicEndpoint
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
     * @ORM\Column(name="sentenceId", type="integer")
     */
    private $sentenceId;

    /**
     * @var string
     *
     * @ORM\Column(name="entityId1", type="string", length=255)
     */
    private $entityId1;

    /**
     * @var string
     *
     * @ORM\Column(name="entityId2", type="string", length=255)
     */
    private $entityId2;

    /**
     *
     * @ORM\Column(name="qualifier", type="string",columnDefinition="ENUM('cytochromes', 'markers', 'patterns', 'rules', 'co_mentions', 'machine_learning')")
     */
    private $qualifier;

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
     * Set kind
     *
     * @param string $kind
     * @return ToxicEndpoint
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
     * @return ToxicEndpoint
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
     * @param integer $sentenceId
     * @return ToxicEndpoint
     */
    public function setSentenceId($sentenceId)
    {
        $this->sentenceId = $sentenceId;

        return $this;
    }

    /**
     * Get sentenceId
     *
     * @return integer
     */
    public function getSentenceId()
    {
        return $this->sentenceId;
    }

    /**
     * Set entityId1
     *
     * @param string $entityId1
     * @return ToxicEndpoint
     */
    public function setEntityId1($entityId1)
    {
        $this->entityId1 = $entityId1;

        return $this;
    }

    /**
     * Get entityId1
     *
     * @return string
     */
    public function getEntityId1()
    {
        return $this->entityId1;
    }

    /**
     * Set entityId2
     *
     * @param string $entityId2
     * @return ToxicEndpoint
     */
    public function setEntityId2($entityId2)
    {
        $this->entityId2 = $entityId2;

        return $this;
    }

    /**
     * Get entityId2
     *
     * @return string
     */
    public function getEntityId2()
    {
        return $this->entityId2;
    }

    /**
     * Set qualifier
     *
     * @param string $qualifier
     * @return ToxicEndpoint
     */
    public function setQualifier($qualifier)
    {
        $this->qualifier = $qualifier;

        return $this;
    }

    /**
     * Get qualifier
     *
     * @return string
     */
    public function getQualifier()
    {
        return $this->qualifier;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return ToxicEndpoint
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
     * @return ToxicEndpoint
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
