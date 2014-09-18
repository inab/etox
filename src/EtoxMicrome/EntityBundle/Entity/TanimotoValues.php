<?php

namespace EtoxMicrome\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TanimotoValues
 *
 * @ORM\Table(indexes={@ORM\Index(name="tanimotovalues_idcompound1_index", columns={"idcompound1"}),@ORM\Index(name="tanimotovalues_idcompound2_index", columns={"idcompound2"})
  } )
 * @ORM\Entity(repositoryClass="EtoxMicrome\EntityBundle\Entity\TanimotoValuesRepository")
 */
class TanimotoValues
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
     * @ORM\ManyToOne(targetEntity="EtoxMicrome\EntityBundle\Entity\Compounddict", inversedBy="tanimoto2compound1")
     * @ORM\JoinColumn(name="idcompound1", referencedColumnName="id", nullable=true)
     */
    private $compound1;

    /**
     * @ORM\ManyToOne(targetEntity="EtoxMicrome\EntityBundle\Entity\Compounddict", inversedBy="tanimoto2compound2")
     * @ORM\JoinColumn(name="idcompound2", referencedColumnName="id", nullable=true)
     */
    private $compound2;

    /**
     * @var string
     *
     * @ORM\Column(name="smile1", type="text", nullable=true)
     */
    private $smile1;

    /**
     * @var string
     *
     * @ORM\Column(name="smile2", type="text", nullable=true)
     */
    private $smile2;

    /**
     * @var string
     *
     * @ORM\Column(name="inChi1", type="text", nullable=true)
     */
    private $inChi1;

    /**
     * @var string
     *
     * @ORM\Column(name="inChi2", type="text", nullable=true)
     */
    private $inChi2;

    /**
     * @var float
     *
     * @ORM\Column(name="tanimoto", type="float", nullable=true)
     */
    private $tanimoto;

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
     * Set compound1
     *
     * @return TanimotoValues
     */
    public function setCompound1(\EtoxMicrome\EntityBundle\Entity\Compounddict $compound1)
    {
        $this->compound1 = $compound1;
    
        return $this;
    }

    /**
     * Get compound1
     *
     * @return integer 
     */
    public function getCompound1()
    {
        return $this->compound1;
    }

    /**
     * Set compound2
     *
     * @return TanimotoValues
     */
    public function setCompound2(\EtoxMicrome\EntityBundle\Entity\Compounddict $compound2)
    {
        $this->compound2 = $compound2;
    
        return $this;
    }

    /**
     * Get idcompound2
     *
     * @return integer 
     */
    public function getCompound2()
    {
        return $this->compound2;
    }

    /**
     * Set smile1
     *
     * @param string $smile1
     * @return TanimotoValues
     */
    public function setSmile1($smile1)
    {
        $this->smile1 = $smile1;
    
        return $this;
    }

    /**
     * Get smile1
     *
     * @return string 
     */
    public function getSmile1()
    {
        return $this->smile1;
    }

    /**
     * Set smile2
     *
     * @param string $smile2
     * @return TanimotoValues
     */
    public function setSmile2($smile2)
    {
        $this->smile2 = $smile2;
    
        return $this;
    }

    /**
     * Get smile2
     *
     * @return string 
     */
    public function getSmile2()
    {
        return $this->smile2;
    }

    /**
     * Set inChi1
     *
     * @param string $inChi1
     * @return TanimotoValues
     */
    public function setInChi1($inChi1)
    {
        $this->inChi1 = $inChi1;
    
        return $this;
    }

    /**
     * Get inChi1
     *
     * @return string 
     */
    public function getInChi1()
    {
        return $this->inChi1;
    }

    /**
     * Set inChi2
     *
     * @param string $inChi2
     * @return TanimotoValues
     */
    public function setInChi2($inChi2)
    {
        $this->inChi2 = $inChi2;
    
        return $this;
    }

    /**
     * Get inChi2
     *
     * @return string 
     */
    public function getInChi2()
    {
        return $this->inChi2;
    }

    /**
     * Set tanimoto
     *
     * @param float $tanimoto
     * @return TanimotoValues
     */
    public function setTanimoto($tanimoto)
    {
        $this->tanimoto = $tanimoto;
    
        return $this;
    }

    /**
     * Get tanimoto
     *
     * @return float 
     */
    public function getTanimoto()
    {
        return $this->tanimoto;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return TanimotoValues
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
     * @return TanimotoValues
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
