<?php

namespace EtoxMicrome\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GeneDictionary
 *
 * @ORM\Table(indexes={@ORM\Index(name="geneDictionary_gene_id_index", columns={"gene_id"}),@ORM\Index(name="geneDictionary_gene_name_index", columns={"gene_name"})} )
 * @ORM\Entity(repositoryClass="EtoxMicrome\EntityBundle\Entity\GeneDictionaryRepository")
 */
class GeneDictionary
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
     * @ORM\Column(name="gene_id", type="string", length=255)
     */
    private $geneId;

    /**
     * @var string
     *
     * @ORM\Column(name="gene_name", type="string", length=512)
     */
    private $geneName;

    /**
     * @var integer
     *
     * @ORM\Column(name="tax_id", type="integer")
     */
    private $taxId;


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
     * Set geneId
     *
     * @param string $geneId
     * @return GeneDictionary
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
     * Set geneName
     *
     * @param string $geneName
     * @return GeneDictionary
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
     * Set taxId
     *
     * @param integer $taxId
     * @return GeneDictionary
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
}
