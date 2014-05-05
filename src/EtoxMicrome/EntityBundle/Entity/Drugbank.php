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
}
