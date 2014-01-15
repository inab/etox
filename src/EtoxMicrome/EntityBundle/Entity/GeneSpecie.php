<?php

namespace EtoxMicrome\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GeneSpecie
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EtoxMicrome\EntityBundle\Entity\GeneSpecieRepository")
 */
class GeneSpecie
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
     * @ORM\ManyToOne(targetEntity="EtoxMicrome\EntityBundle\Entity\Gene", inversedBy="geneSpecie")
     * @ORM\JoinColumn(name="gene_id", referencedColumnName="id")
     **/
    private $gene;

    /**
     * @ORM\ManyToOne(targetEntity="EtoxMicrome\EntityBundle\Entity\Specie", inversedBy="geneSpecie")
     * @ORM\JoinColumn(name="specie_id", referencedColumnName="id")
     **/
    private $specie;

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
     * Set gene
     *
     * @param string $gene
     * @return GeneSpecie
     */
    public function setGene(\EtoxMicrome\EntityBundle\Entity\Gene $gene)
    {
        $this->gene = $gene;

        return $this;
    }

    /**
     * Get gene
     *
     * @return string
     */
    public function getGene()
    {
        return $this->gene;
    }

    /**
     * Set specie
     *
     * @param string $specie
     * @return GeneSpecie
     */
    public function setSpecie(\EtoxMicrome\EntityBundle\Entity\Specie $specie)
    {
        $this->specie = $specie;

        return $this;
    }

    /**
     * Get specie
     *
     * @return string
     */
    public function getSpecie()
    {
        return $this->specie;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return GeneSpecie
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
     * @return GeneSpecie
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
