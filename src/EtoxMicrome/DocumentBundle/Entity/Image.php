<?php

namespace EtoxMicrome\DocumentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EtoxMicrome\DocumentBundle\Entity\ImageRepository")
 */
class Image
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
     * @var integer
     *
     * @ORM\Column(name="compound", type="integer")
     */
    private $compound;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="blob")
     */
    private $image;


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
     * Set compound
     *
     */
    public function setCompound(\EtoxMicrome\EntityBundle\Entity\CompoundDict $compound)
    {
        $this->compound = $compound;

        return $this;
    }

    /**
     * Get compound
     *
     */
    public function getCompound()
    {
        return $this->compound;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Image
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
}
