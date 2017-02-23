<?php

namespace EtoxMicrome\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CypsUniprotRanking
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EtoxMicrome\EntityBundle\Entity\CypsUniprotRankingRepository")
 */
class CypsUniprotRanking
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
     * @ORM\Column(name="uniprotAccession", type="string", length=255)
     */
    private $uniprotAccession;

    /**
     * @var integer
     *
     * @ORM\Column(name="ranking", type="integer")
     */
    private $ranking;


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
     * Set uniprotAccession
     *
     * @param string $uniprotAccession
     * @return CypsUniprotRanking
     */
    public function setUniprotAccession($uniprotAccession)
    {
        $this->uniprotAccession = $uniprotAccession;
    
        return $this;
    }

    /**
     * Get uniprotAccession
     *
     * @return string 
     */
    public function getUniprotAccession()
    {
        return $this->uniprotAccession;
    }

    /**
     * Set ranking
     *
     * @param integer $ranking
     * @return CypsUniprotRanking
     */
    public function setRanking($ranking)
    {
        $this->ranking = $ranking;
    
        return $this;
    }

    /**
     * Get ranking
     *
     * @return integer 
     */
    public function getRanking()
    {
        return $this->ranking;
    }
}
